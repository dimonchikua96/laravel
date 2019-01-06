<?php

namespace App\Http\Controllers;

use App\Http\Requests\SP\CreateGroupRequest;
use App\Http\Requests\SP\CreatePointRequest;
use App\Http\Requests\SP\GetPointsRequest;
use App\Http\Requests\SP\SelectPointRequest;
use App\Models\SP\GroupsModel;
use App\Models\SP\PointsModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Class ServicePointsController
 * @package App\Http\Controllers
 */
class ServicePointsController extends Controller
{
    /**
     * @param SelectPointRequest $request
     * @return array
     */
    public function selectPoint(SelectPointRequest $request)
    {
        //todo fetch user here
        $user = $request->user;

        DB::transaction(function () use ($user, $request) {
            DB::table('sp_points')
                ->where('operator_ldap', $user)
                ->update(['operator_ldap' => null, 'operator_date' => null]);

            DB::table('sp_points')
                ->where('code', $request->id)
                ->update(['operator_ldap' => $user, 'operator_date' => Carbon::now()]);

        }, 5);


        return ['status' => 'ok'];;

    }

    /**
     * @param CreatePointRequest $request
     * @return array
     */
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

        return ['status' => 'ok'];
    }

    /**
     * @param CreateGroupRequest $request
     * @return array
     */
    public function createGroup(CreateGroupRequest $request)
    {
        $point = new GroupsModel;

        $point->name = $request->name;
        $point->state_id = $request->state_id;
        $point->type_id = $request->type_id;
        $point->branch = $request->branch;

        $point->save();

        return ['status' => 'ok'];
    }

    /**
     * @param GetPointsRequest $request
     * @return mixed
     */
    public function getPoints(GetPointsRequest $request)
    {

        $groupsModel = GroupsModel::select();
        $pointsModel = PointsModel::select();

        if ($request->exists('state')) {
            $groupsModel->where(['state_id' => $request->get('state')]);
            $pointsModel->where(['state_id' => $request->get('state')]);
        }

        if ($request->exists('branch')) {
            $groupsModel->where(['branch' => $request->get('branch')]);
        }

        $groups = $groupsModel->get()->toArray();
        $points = $pointsModel->get()->toArray();

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
