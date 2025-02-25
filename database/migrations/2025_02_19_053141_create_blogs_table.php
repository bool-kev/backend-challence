<?php

use App\Enums\V1\BlogStatus;
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
            $table->string("slug");
            $table->longText("content");
            $table->string("image");
            $table->enum("status", array_map(fn($status) => $status->value, BlogStatus::cases()))->default(BlogStatus::PUBLISHED->value);
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
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
