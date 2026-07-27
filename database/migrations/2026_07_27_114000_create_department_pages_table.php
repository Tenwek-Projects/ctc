<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('department_pages', function (Blueprint $table) {
            $table->id();
            $table->string('url_segment', 64)->unique();
            $table->string('admin_label', 120);
            $table->string('meta_title', 200)->nullable();
            $table->string('meta_description', 320);
            $table->string('intro_kicker', 80)->nullable();
            $table->string('intro_heading', 255);
            $table->string('intro_subheading', 500)->nullable();
            $table->longText('body_html');
            $table->string('featured_image_path')->nullable();
            $table->boolean('is_visible')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('department_pages');
    }
};
