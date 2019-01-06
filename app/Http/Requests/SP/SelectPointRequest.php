<?php

namespace App\Http\Requests\SP;

use App\Rules\PointIsActiveRule;
use App\Rules\PointNotSelectedByOtherUserRule;
use Illuminate\Foundation\Http\FormRequest;

class SelectPointRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "id"=>[
                "bail",
                "required",
                "exists:sp_points,code",
                new PointIsActiveRule(),
                new PointNotSelectedByOtherUserRule()
            ]
        ];
    }
}
