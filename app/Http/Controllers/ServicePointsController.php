<?php

namespace App\Http\Controllers;

use App\Http\Requests\SP\CreateGroupRequest;
use App\Http\Requests\SP\CreatePointRequest;
use App\Models\SP\GroupsModel;
use App\Models\SP\PointsModel;
use Carbon\Carbon;

class ServicePointsController extends Controller
{
    public function selectPoint(){

    }

    public function createPoint(CreatePointRequest $request)
    {
        $point = new PointsModel;

        $point->code = Carbon::now()->format('dmy') . 'SP' . str_random(12);
        $point->name = $request->name;
        $point->state_id = $request->state_id;
        $point->group_id = $request->group_id;
        $point->operator_ldap = '';
        $point->operator_date = '';
        $point->sort_order = 1;

        $point->save();

        return ['status'=>'ok'];

    }

    public function createGroup(CreateGroupRequest $request)
    {
        $point = new GroupsModel;

        $point->name = $request->name;
        $point->state_id = $request->state_id;
        $point->type_id = $request->type_id;
        $point->branch = $request->branch;

        $point->save();

        return ['status'=>'ok'];
    }

    public function getPoints()
    {

        $groups = GroupsModel::all()->toArray();
        $points = PointsModel::all()->toArray();

        $point_groups = [];

        //группируем точки по группам
        foreach ($points as $point) {
            if (!array_key_exists($point['group_id'], $point_groups)) {
                $point_groups[$point['group_id']] = [];
            }
            $point_groups[$point['group_id']][] = $point;
        }

        //добавляем точки в группы
        foreach ($groups as &$group) {
            if (array_key_exists($group['id'], $point_groups)) {
                //если статус группы - неактивна, присваиваем всем точкам этот статус
                if ($group['state_id'] == 'inactive') {
                    foreach ($point_groups[$group['id']] as &$point) {
                        $point['state_id'] = 'inactive';
                    }
                }
                $group['points'] = $point_groups[$group['id']];
            } else {
                $group['points'] = [];
            }
        }

        return $groups;
    }
}
