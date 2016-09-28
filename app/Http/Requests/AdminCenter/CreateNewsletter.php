<?php

namespace App\Http\Requests\AdminCenter;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validate data used to create a new newsletter.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class CreateNewsletter extends FormRequest {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'newsletter_name' => ['required', 'string', 'between:3,100'],
        ];
    }

}
