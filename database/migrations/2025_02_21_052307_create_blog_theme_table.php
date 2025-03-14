<?php

use App\Models\Blog;
use App\Models\Theme;
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
        Schema::create('blog_theme', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Blog::class)->constrained();
            $table->foreignIdFor(Theme::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_theme');
    }
};
