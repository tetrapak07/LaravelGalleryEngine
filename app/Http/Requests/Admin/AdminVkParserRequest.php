<?php namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminVkParserRequest extends FormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {

        $validation = [
            'public_id' => 'required|min:2',
            'albom_id' => 'required|min:1',
            'count' => 'required|integer',
            'offset' => 'required|integer',
            'albom' => 'required|integer',
        ];

        return $validation;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

}
