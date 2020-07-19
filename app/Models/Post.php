<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'content', 'user_id'
    ];

    /**
     * Armado de relación de un post con su usuario
     */
    public function user(){
        // El segundo parámetro es el nombre de la llave foránea
        // Para detalle explicado de esto, ver User model
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * Armado de relación de un post con sus comentarios
     */
    public function comments(){
        return $this->hasMany('App\Models\Comment');
    }
}
