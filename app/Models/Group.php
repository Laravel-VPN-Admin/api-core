<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Group extends Model
{
    protected $table   = 'groups';
    protected $guarded = ['id'];
    protected $dates   = [
        'created_at',
        'updated_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function users(): MorphToMany
    {
        return $this->morphedByMany(User::class, 'grouped', 'grouped');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function servers(): MorphToMany
    {
        return $this->morphedByMany(Server::class, 'grouped', 'grouped');
    }
}
