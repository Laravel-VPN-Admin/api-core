<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Configuration extends Model
{
    protected $table     = 'configurations';
    protected $guarded   = ['id'];
    protected $dates     = ['created_at', 'updated_at'];
    protected $withCount = ['servers'];
    protected $casts     = ['options' => 'object'];

    public const TYPE_OPENVPN = 1;
    public const TYPE_XL2TP   = 2;

    public const TYPES = [
        self::TYPE_OPENVPN => 'OpenVPN',
        self::TYPE_XL2TP   => 'XL2TP',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function servers(): HasMany
    {
        return $this->hasMany(Server::class, 'configuration_id', 'id');
    }
}
