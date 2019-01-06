<?php

namespace App\Rules;

use App\Models\SP\PointsModel;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Request;


class PointNotSelectedByOtherUserRule implements Rule
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
        //todo fetch user here
        $user = Request::get('user');
        $point = PointsModel::where('code', $value)->first();

        //validation passes if point is empty or current user is point operator
        return (
            empty($point->operator_ldap) or
            strtolower($point->operator_ldap) == strtolower($user)
        );
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $point = PointsModel::where('code', Request::get('id'))->first();
        return "В точке работает пользователь {$point->operator_ldap}";
    }
}
