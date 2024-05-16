<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->longText('body');
            $table->string('author_full_name')->nullable();
            $table->string('cover_img_src')->nullable();
            $table->string('cover_img_alt')->nullable();
            $table->boolean('is_active')->default(true);
            $table->date('published_date');
            $table->string('read_time');
            $table->index(['slug', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
