<?php

namespace App\Models\SP;

use Illuminate\Database\Eloquent\Model;

class PointsModel extends Model
{
    protected $table = 'sp_points';
    protected $hidden = ['updated_at'];
}
