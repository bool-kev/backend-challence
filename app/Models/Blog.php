<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use SoftDeletes;
   
    protected $fillable = [
        'title',
        'content',
        'user_id',
    ];

    /**
     * Obtenir l'utilisateur qui possède le blog.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtenir les commentaires du blog.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function commentaires()
    {
        return $this->hasMany(Commentaire::class);
    }

    /**
     * Obtenir les thèmes du blog.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function themes()
    {
        return $this->belongsToMany(Theme::class);
    }

    
    /**
     * Obtenir les utilisateurs qui aiment le blog.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes');
    }

    /**
     * Détermine si le blog est aimé par l'utilisateur donné.
     *
     * @param  User  $user
     * @return bool
     */
    public function isLikedBy(User $user)
    {
        return $this->likes->contains($user);
    }
}
