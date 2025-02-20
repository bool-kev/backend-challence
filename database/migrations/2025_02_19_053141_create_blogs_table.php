<?php

use App\Models\User;
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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string("titre");
            $table->string("slug")->unique();
            $table->longText("content");
            $table->string("image");
            $table->enum("status", ["publié", "brouillon", "supprimé"])->default("brouillon");
            $table->foreignIdFor(User::class,"author_id")->constrained()->cascadeOnDelete();
            $table->timestamp("published_at")->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
