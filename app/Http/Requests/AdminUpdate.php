<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminUpdate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @param $id
     *
     * @return array
     */
    public function rules($id)
    {
        return [
            'name' => 'sometimes|required|max:255',
            'email' => 'sometimes|email|max:255|unique:users,email,' . $id,
        ];
    }
}
