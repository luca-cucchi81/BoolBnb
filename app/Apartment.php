<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    protected $fillable = [
        'user_id', 'title', 'description', 'rooms', 'beds', 'bathrooms', 'square_meters', 'address', 'lat', 'lng',  'main_img', 'visibility', 'slug'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function messages() {
        return $this->hasMany('App\Message');
    }

    public function views() {
        return $this->hasMany('App\View');
    }

    public function images() {
        return $this->hasMany('App\Image');
    }

    public function services() {
        return $this->belongsToMany('App\Service');
    }

    public function sponsorships() {
        return $this->belongsToMany('App\Sponsorship')->withPivot('start_date', 'end_date');
    }

    public function visits()
    {
        return visits($this)->relation();
    }
}
