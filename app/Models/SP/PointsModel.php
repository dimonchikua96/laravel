<?php

namespace App\Models\SP;

use Illuminate\Database\Eloquent\Model;

class PointsModel extends Model
{
    protected $table = 'sp_points';
    protected $hidden = ['updated_at'];
  ///  protected $nullable = ['operator_ldap'];

    /**
     * Get the group for points.
     */
    public function group()
    {
        return $this->hasOne('App\Models\SP\GroupsModel','id', 'group_id');
    }
}
