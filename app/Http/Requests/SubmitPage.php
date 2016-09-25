<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validate submit page request.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class SubmitPage extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'page_name' => ['required', 'string', 'between:3,30'],
            'page_url' => ['required', 'url']
        ];
    }
}
