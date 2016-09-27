<?php namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminSettingRequest extends FormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {

        $validation = [
            'name' => 'required|min:2',
            'value' => 'required|min:2',
            'description' => '',
        ];

        $page = \Input::get('page');

        if ($page != '') {
            $validation['page'] = 'integer';
        }

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
