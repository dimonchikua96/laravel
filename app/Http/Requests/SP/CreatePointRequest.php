<?php

namespace App\Http\Requests\SP;

use Illuminate\Foundation\Http\FormRequest;

class CreatePointRequest extends FormRequest
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
            "name"=>[
                "required"
            ],
            "state_id"=>[
                "required",
                "in:active,inactive"
            ],
            "group_id"=>[
                "required",
                "exists:sp_groups,id"
            ],
        ];
    }
}
