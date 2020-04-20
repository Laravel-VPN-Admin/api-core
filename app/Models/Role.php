<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
  public function Users()
  {
    return $this->belongsToMany(User::class);
  }
}
