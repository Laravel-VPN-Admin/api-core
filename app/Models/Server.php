<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Server extends Model
{
    protected $table   = 'servers';
    protected $guarded = ['id'];
    protected $dates   = [
        'created_at',
        'updated_at',
    ];

    // TODO rewrite to HasManyThrough
//    /**
//     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
//     */
//    public function users(): BelongsToMany
//    {
//        return $this->belongsToMany(User::class, 'user_group', 'group_id', 'id');
//    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'server_group', 'server_id', 'group_id', 'id', 'id');
    }
}
