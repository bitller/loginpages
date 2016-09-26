<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable {

    use Notifiable;
    use EntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'google_id', 'facebook_id', 'github_id', 'name', 'email',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    public function subscription() {
        return $this->hasOne('App\Subscription');
    }

    public function favoritePages() {
        return $this->belongsToMany('App\Page', 'users_favorite_pages');
    }

    public function scopeGoogle($query) {
        return $query->whereNotNull('google_id');
    }

    public function scopeFacebook($query) {
        return $query->whereNotNull('facebook_id');
    }

    public function scopeGithub($query) {
        return $query->whereNotNull('github_id');
    }

    public function scopeLatest($query) {
        return $query->orderBy('created_at', 'desc');
    }
}
