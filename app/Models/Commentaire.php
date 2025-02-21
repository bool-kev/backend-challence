<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Commentaire extends Pivot
{
    protected $table = 'commentaires';
    
    protected $fillable = [
        'contenu',
        'user_id',
        'blog_id',
    ];

    /**
     * Obtenir l'utilisateur qui a écrit le commentaire.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtenir le blog auquel appartient le commentaire.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
}
