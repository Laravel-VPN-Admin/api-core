<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Configuration extends Model
{
    protected $table     = 'configurations';
    protected $guarded   = ['id'];
    protected $dates     = [
        'created_at',
        'updated_at',
    ];
    protected $withCount = [
        'servers'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function servers(): HasMany
    {
        return $this->hasMany(Server::class, 'configuration_id', 'id');
    }
}
