<?php

namespace App\Http\Requests\AdminCenter;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validate upload page request data.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class UploadPage extends FormRequest {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'page_name' => ['required', 'string', 'between:3,30'],
            'page_url' => ['required', 'url'],
            'page_image' => ['required', 'mimes:png'],
        ];
    }

}
