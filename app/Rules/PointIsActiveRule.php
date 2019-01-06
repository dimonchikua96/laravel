<?php

namespace App\Rules;

use App\Models\SP\PointsModel;
use Illuminate\Contracts\Validation\Rule;

class PointIsActiveRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $point = PointsModel::where('code', $value)->first();
        //point is active when group is active and when point active itself
        return ($point->group->state_id  == 'active' and $point->state_id == 'active');
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Точка либо ее корневая группа не активна';
    }
}
