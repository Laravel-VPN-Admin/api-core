<?php

namespace App;

use App\Models\Group;
use App\Models\Role;
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

  public function Roles()
  {
    return $this->belongsToMany(Role::class);
  }

  public function getRoleNameByPriority()
  {
    $role = $this->roles()->orderBy('priotiry', 'desc')->first();
    return $role['name'];
  }

  public function getRoleNames()
  {
    return $this->roles()->get();
  }

  /**
   * @param array $roles
   *
   * @return bool
   */
  public function hasAnyRoles(array $roles): bool
  {
    if ($this->roles()->whereIn('name', $roles)->first()) {
      return true;
    }

    return false;
  }

  /**
   * @param string $role
   *
   * @return bool
   */
  public function hasRole(string $role): bool
  {
    if ($this->roles()->where('name', $role)->first()) {
      return true;
    }

    return false;
  }
}
