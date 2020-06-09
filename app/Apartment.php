<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    protected $fillable = [
        'user_id', 'title', 'description', 'rooms', 'beds', 'bathrooms', 'square_meters', 'address', 'latitude', 'longitude',  'main_img', 'visibility'
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
    
}


