<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resource_downloads', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('file_path');
            $table->string('download_name')->nullable();
            $table->unsignedBigInteger('download_count')->default(0);
            $table->timestamps();
        });

        DB::table('resource_downloads')->insert([
            'slug' => 'ctc-executive-brochure',
            'title' => 'CTC Executive Brochure',
            'file_path' => 'CTC-Executive-Bronchure.pdf',
            'download_name' => 'CTC-Executive-Brochure.pdf',
            'download_count' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('resource_downloads');
    }
};
