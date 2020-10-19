<?php

namespace App\Models;

use App\Models\Group;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $guarded = ['id'];
    protected $hidden  = ['password', 'remember_token'];
    protected $casts   = [
        'email_verified_at' => 'datetime',
    ];
    protected $dates   = [
        'created_at',
        'updated_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function groups(): MorphToMany
    {
        return $this->morphToMany(Group::class, 'grouped', 'grouped');
    }
}
