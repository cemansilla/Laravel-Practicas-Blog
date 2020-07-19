<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Método para crear relaciones entre modelos
     * El nombre de la función es el model con el que relaciono
     */
    public function posts(){
        // El segundo parámetro indica la llave foránea
        // Se puede omitir si en la creación de la llave en la migración se sigue la convención estándar
        // Esto es, Laravel buscará la relación convirtiendo a minúscula el nombre del model (en este caso user) y concatenando "_id"

        // El tercer parámetro es el nombre de la llave local (en este caso de la tabla users)
        // No es obligatorio, sólo se usaría si se definió un nombre distinto a "id"
        return $this->hasMany('App\Models\Post', 'user_id', 'id');
    }
}
