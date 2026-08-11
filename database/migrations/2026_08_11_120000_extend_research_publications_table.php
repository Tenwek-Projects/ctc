<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('research_publications', function (Blueprint $table) {
            $table->string('import_key', 64)->nullable()->unique()->after('id');
            $table->text('tenwek_authors')->nullable()->after('authors');
            $table->string('publication_type', 120)->nullable()->after('journal');
            $table->string('doi', 255)->nullable()->after('publication_type');
            $table->string('pmid', 32)->nullable()->after('doi');
            $table->string('specialty', 160)->nullable()->after('pmid');
            $table->text('full_citation')->nullable()->after('specialty');
        });

        Schema::table('research_publications', function (Blueprint $table) {
            $table->text('title')->change();
            $table->text('authors')->nullable()->change();
            $table->string('journal', 500)->nullable()->change();
            $table->string('url', 2000)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('research_publications', function (Blueprint $table) {
            $table->dropColumn([
                'import_key',
                'tenwek_authors',
                'publication_type',
                'doi',
                'pmid',
                'specialty',
                'full_citation',
            ]);
        });
    }
};
