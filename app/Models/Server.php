<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Collection;

class Server extends Model
{
    protected $table   = 'servers';
    protected $guarded = ['id'];
    protected $dates   = [
        'created_at',
        'updated_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function groups(): MorphToMany
    {
        return $this->morphToMany(Group::class, 'grouped', 'grouped');
    }

    /**
     * Get list of all users which can connect to this server
     *
     * @return \Illuminate\Support\Collection
     */
    public function getUsersAttribute(): Collection
    {
        $users  = collect();
        $groups = $this->groups()->get();

        $groups->map(static function (Group $group) use (&$users) {
            $groupUsers = $group->users()->get();
            $users      = $users->merge($groupUsers);
        });

        return $users;
    }

    /**
     * Return amount of users in group
     *
     * @return int
     */
    public function getUsersCountAttribute(): int
    {
        return $this->users->count();
    }

    /**
     * Check if use may connect to this server
     *
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function hasUser(User $user): bool
    {
        return $this->users->has($user);
    }
}
