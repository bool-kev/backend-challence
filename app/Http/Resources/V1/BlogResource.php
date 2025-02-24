<?php

namespace App\Http\Resources\V1;

use App\Http\Resources\V1\Collection\CommentaireCollection;
use App\Http\Resources\V1\Collection\ThemeCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'titre' => $this->titre,
            'content' => $this->content,
            'image' => $this->image?asset(Storage::url($this->image)):NULL,
            'slug' => $this->slug,
            'status' => $this->status,
            'vues' => $this->vue,
            'like' => $this->likes->count(),
            'themes' => $this->when($this->relationLoaded('themes'),  ThemeResource::collection($this->themes)),
            'commentaires' => $this->when($this->relationLoaded('commentaires'),  CommentaireResource::collection($this->commentaires)),
            'author' => $this->when($this->relationLoaded('user'), new UserResource($this->user)),
            'publishedAt' => $this->published_at,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
