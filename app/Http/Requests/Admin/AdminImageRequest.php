<?php namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminImageRequest extends FormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {

        $validation = [
            'title' => 'required|min:2',
            'url_thumb' => 'required|url|max:255',
            'url' => 'required|url|max:255',
            'visible' => 'required|integer',
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
