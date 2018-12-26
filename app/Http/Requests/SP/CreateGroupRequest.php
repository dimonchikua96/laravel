<?php

namespace App\Http\Requests\SP;

use Illuminate\Foundation\Http\FormRequest;

class CreateGroupRequest extends FormRequest
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
            "type_id"=>[
                "required",
                "in:cashbox,operating_room"
            ],
        ];
    }
}
