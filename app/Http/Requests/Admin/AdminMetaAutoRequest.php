<?php namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use \Input;

class AdminMetaAutoRequest extends FormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {

        $validation = [
            'word_title1' => 'required',
            'word_title2' => 'required',
        ];
        // 
        $count = Input::get('title_word_count');

        if ($count >= 3) {
            $input = $this->all();
            for ($index = 3; $index <= $count; $index++) {
                $validation['word_title' . $index] = 'required';
            }
            $this->replace($input);
        }
        // 
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
