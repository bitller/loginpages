<?php

namespace App\Http\Requests\AdminCenter;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validate data used to delete a newsletter.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class DeleteNewsletter extends FormRequest {

    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'newsletter_id' => ['required', 'exists:newsletters,id', 'newsletter_not_sent']
        ];
    }

}
