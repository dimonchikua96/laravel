<?php

namespace App\Models\SP;

use Illuminate\Database\Eloquent\Model;

class GroupsModel extends Model
{
    protected $table = 'sp_groups';
    protected $hidden = ['updated_at'];

    /**
     * Get the points for the group.
     */
    public function points()
    {
        return $this->hasMany('App\Models\SP\PointsModel', 'group_id', 'id');
    }
}
