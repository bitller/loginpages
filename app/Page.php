<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Newsletter;

/**
 * Model of pages table.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class Page extends Model {

    protected $fillable = ['name', 'url', 's3_name', 'status', 's3_url'];

    public function users() {
        return $this->belongsToMany('User', 'users_upvotes');
    }

    public function scopePending($query) {
        return $query->where('status', 'pending');
    }

    public function scopeDeclined($query) {
        return $query->where('status', 'declined');
    }

    public function scopeAccepted($query) {
        return $query->where('status', 'approved');
    }

    public function scopeSinceLastNewsletter($query) {
        $lastNewsletter = Newsletter::orderBy('created_at', 'desc')->first();
        if (!$lastNewsletter) {
            return $query;
        }
        return $query->where('created_on', '>=', $lastNewsletter->created_at);
    }
}
