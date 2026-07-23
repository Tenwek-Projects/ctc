<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use App\Support\TrixHtmlSanitizer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TeamMemberController extends Controller
{
    public function index(): View
    {
        $members = TeamMember::query()->ordered()->get();
        $groupLabels = config('ctc.team_groups', []);

        $grouped = collect();
        foreach ($groupLabels as $key => $label) {
            $groupMembers = $members->where('team_group', $key)->values();
            if ($groupMembers->isNotEmpty()) {
                $grouped->put($key, [
                    'label' => $label,
                    'members' => $groupMembers,
                ]);
            }
        }

        $ungrouped = $members->filter(fn (TeamMember $member) => blank($member->team_group))->values();
        if ($ungrouped->isNotEmpty()) {
            $grouped->put('other', [
                'label' => 'Ungrouped',
                'members' => $ungrouped,
            ]);
        }

        return view('admin-dashboard.team-members.index', [
            'members' => $members,
            'grouped' => $grouped,
        ]);
    }

    public function create(): View
    {
        return view('admin-dashboard.team-members.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'credentials' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'team_group' => ['nullable', 'string', 'max:80', 'in:'.implode(',', TeamMember::teamGroupKeys())],
            'specialization' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:20000',
            'photo' => 'nullable|image|max:10240',
            'photo_url' => 'nullable|string|max:500',
            'slug' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_visible' => 'boolean',
            'show_on_homepage' => 'boolean',
        ]);
        $validated['is_visible'] = $request->boolean('is_visible');
        $validated['show_on_homepage'] = $request->boolean('show_on_homepage');
        $validated['team_group'] = $validated['team_group'] ?: null;
        $validated['credentials'] = filled($validated['credentials'] ?? null) ? $validated['credentials'] : null;
        if (! array_key_exists('sort_order', $validated) || $validated['sort_order'] === null || $validated['sort_order'] === '') {
            $validated['sort_order'] = $this->nextSortOrderForGroup($validated['team_group']);
        } else {
            $validated['sort_order'] = (int) $validated['sort_order'];
        }
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']) . '-' . time();
        }
        $validated['bio'] = TrixHtmlSanitizer::sanitize($validated['bio'] ?? '');

        $member = TeamMember::create(collect($validated)->except(['photo', 'photo_url'])->all());

        try {
            if ($request->hasFile('photo')) {
                $member->update(['photo' => $this->storeTeamPhoto($request->file('photo'), $member)]);
            } elseif (! empty($validated['photo_url'])) {
                $member->update(['photo' => $validated['photo_url']]);
            }
        } catch (\Throwable $e) {
            report($e);

            return redirect()
                ->route('admin-dashboard.team-members.edit', $member)
                ->with('error', 'Member created, but the photo could not be published. Ensure public/storage/team is writable.');
        }

        return redirect()->route('admin-dashboard.team-members.index')->with('success', 'Team member created.');
    }

    public function edit(TeamMember $team_member): View
    {
        return view('admin-dashboard.team-members.edit', ['member' => $team_member]);
    }

    public function update(Request $request, TeamMember $team_member): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'credentials' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'team_group' => ['nullable', 'string', 'max:80', 'in:'.implode(',', TeamMember::teamGroupKeys())],
            'specialization' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:20000',
            'photo' => 'nullable|image|max:10240',
            'photo_url' => 'nullable|string|max:500',
            'remove_photo' => 'sometimes|boolean',
            'slug' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_visible' => 'boolean',
            'show_on_homepage' => 'boolean',
        ]);
        $validated['is_visible'] = $request->boolean('is_visible');
        $validated['show_on_homepage'] = $request->boolean('show_on_homepage');
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);
        $validated['team_group'] = $validated['team_group'] ?: null;
        $validated['credentials'] = filled($validated['credentials'] ?? null) ? $validated['credentials'] : null;
        if (empty($validated['slug'])) {
            $validated['slug'] = $team_member->slug ?: (Str::slug($validated['name']) . '-' . $team_member->id);
        }
        $validated['bio'] = TrixHtmlSanitizer::sanitize($validated['bio'] ?? '');

        if (! empty($_FILES['photo']['name'] ?? null) && (int) ($_FILES['photo']['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK && ! $request->hasFile('photo')) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'The photo did not upload. Use a JPG/PNG under about 8MB, or ask hosting to raise upload_max_filesize.');
        }

        $team_member->update(collect($validated)->except(['photo', 'photo_url', 'remove_photo'])->all());

        try {
            if ($request->boolean('remove_photo')) {
                $this->deleteStoredPhoto($team_member->photo);
                $team_member->update(['photo' => null]);
            } elseif ($request->hasFile('photo')) {
                $this->deleteStoredPhoto($team_member->photo);
                $team_member->update(['photo' => $this->storeTeamPhoto($request->file('photo'), $team_member)]);
            } elseif (! empty($validated['photo_url'])) {
                $this->deleteStoredPhoto($team_member->photo);
                $team_member->update(['photo' => $validated['photo_url']]);
            }
        } catch (\Throwable $e) {
            report($e);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Profile saved, but the photo could not be published to the public web folder. On shared hosting, ensure public/storage/team is writable.');
        }

        return redirect()->route('admin-dashboard.team-members.index')->with('success', 'Team member updated.');
    }

    public function updatePhoto(Request $request, int $team_member): RedirectResponse
    {
        $member = TeamMember::query()->findOrFail($team_member);

        try {
            $request->validate([
                'photo' => ['required', 'file', 'mimes:jpg,jpeg,png,webp,gif', 'max:10240'],
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()
                ->route('admin-dashboard.team-members.index')
                ->with('error', $e->validator->errors()->first('photo') ?: 'Photo upload failed validation.');
        }

        try {
            $this->deleteStoredPhoto($member->photo);
            $path = $this->storeTeamPhoto($request->file('photo'), $member);
            $member->update(['photo' => $path]);
        } catch (\Throwable $e) {
            report($e);

            return redirect()
                ->route('admin-dashboard.team-members.index')
                ->with('error', 'Could not save the photo. Please try again or use a smaller JPG/PNG file.');
        }

        return redirect()
            ->route('admin-dashboard.team-members.index')
            ->with('success', "Photo updated for {$member->name}.");
    }

    public function toggleHomepage(int $team_member): RedirectResponse
    {
        $member = TeamMember::query()->findOrFail($team_member);

        $member->update([
            'show_on_homepage' => ! $member->show_on_homepage,
        ]);

        $state = $member->show_on_homepage ? 'shown on' : 'removed from';

        return redirect()
            ->route('admin-dashboard.team-members.index')
            ->with('success', "{$member->name} {$state} the homepage.");
    }

    public function reorder(Request $request, int $team_member): RedirectResponse
    {
        $validated = $request->validate([
            'direction' => ['required', 'in:up,down'],
        ]);

        $member = TeamMember::query()->findOrFail($team_member);
        $siblings = $this->siblingsInGroup($member);

        $index = $siblings->search(fn (TeamMember $sibling) => $sibling->id === $member->id);
        if ($index === false) {
            return redirect()->route('admin-dashboard.team-members.index');
        }

        $swapIndex = $validated['direction'] === 'up' ? $index - 1 : $index + 1;
        if ($swapIndex < 0 || $swapIndex >= $siblings->count()) {
            return redirect()
                ->route('admin-dashboard.team-members.index')
                ->with('error', 'That member is already at the edge of its group.');
        }

        $ordered = $siblings->values()->all();
        $temp = $ordered[$index];
        $ordered[$index] = $ordered[$swapIndex];
        $ordered[$swapIndex] = $temp;

        foreach ($ordered as $position => $sibling) {
            $sibling->update(['sort_order' => ($position + 1) * 10]);
        }

        return redirect()
            ->route('admin-dashboard.team-members.index')
            ->with('success', "Order updated for {$member->name}.");
    }

    public function destroy(TeamMember $team_member): RedirectResponse
    {
        $this->deleteStoredPhoto($team_member->photo);
        $team_member->delete();
        return redirect()->route('admin-dashboard.team-members.index')->with('success', 'Team member deleted.');
    }

    /**
     * @return \Illuminate\Support\Collection<int, TeamMember>
     */
    private function siblingsInGroup(TeamMember $member)
    {
        return TeamMember::query()
            ->when(
                filled($member->team_group),
                fn ($query) => $query->where('team_group', $member->team_group),
                fn ($query) => $query->where(function ($inner) {
                    $inner->whereNull('team_group')->orWhere('team_group', '');
                })
            )
            ->orderBy('sort_order')
            ->orderBy('name')
            ->orderBy('id')
            ->get();
    }

    private function nextSortOrderForGroup(?string $teamGroup): int
    {
        $max = TeamMember::query()
            ->when(
                filled($teamGroup),
                fn ($query) => $query->where('team_group', $teamGroup),
                fn ($query) => $query->where(function ($inner) {
                    $inner->whereNull('team_group')->orWhere('team_group', '');
                })
            )
            ->max('sort_order');

        return ((int) $max) + 10;
    }

    private function storeTeamPhoto(UploadedFile $file, TeamMember $member): string
    {
        $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension() ?: 'jpg');
        if (! in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'gif'], true)) {
            $extension = 'jpg';
        }

        // Unique filename every upload so browsers/CDNs cannot keep serving an old
        // broken Git LFS pointer at the same public URL.
        $base = Str::slug($member->name) ?: ('team-member-'.$member->id);
        $filename = $base.'-'.$member->id.'-'.time().'.'.$extension;
        $directory = 'team';
        $disk = Storage::disk('public');

        if (! $disk->exists($directory)) {
            $disk->makeDirectory($directory);
        }

        $path = $file->storeAs($directory, $filename, 'public');

        if (! $path || ! $disk->exists($path)) {
            throw new \RuntimeException('Failed to store team photo.');
        }

        // Shared hosting often uses a real public/storage folder (not a symlink).
        // Mirror so the web server can serve the newly uploaded binary.
        $this->mirrorPublicStoragePath($path);

        return $path;
    }

    private function deleteStoredPhoto(?string $photo): void
    {
        if ($photo && ! str_starts_with($photo, 'http')) {
            Storage::disk('public')->delete($photo);
            $this->deleteMirroredPublicStoragePath($photo);
        }
    }

    private function mirrorPublicStoragePath(string $relativePath): void
    {
        $publicStorage = public_path('storage');

        if (is_link($publicStorage)) {
            return;
        }

        $source = Storage::disk('public')->path($relativePath);
        $target = $publicStorage.DIRECTORY_SEPARATOR.str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $relativePath);
        $dir = dirname($target);

        if (! is_dir($dir) && ! mkdir($dir, 0755, true) && ! is_dir($dir)) {
            throw new \RuntimeException('Could not create public storage directory for team photo.');
        }

        if (! is_file($source) || ! @copy($source, $target)) {
            throw new \RuntimeException('Could not publish team photo to the public web folder.');
        }
    }

    private function deleteMirroredPublicStoragePath(string $relativePath): void
    {
        $publicStorage = public_path('storage');

        if (is_link($publicStorage)) {
            return;
        }

        $target = $publicStorage.DIRECTORY_SEPARATOR.str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $relativePath);

        if (is_file($target)) {
            @unlink($target);
        }
    }
}
