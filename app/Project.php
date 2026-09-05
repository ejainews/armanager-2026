<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'code',
        'redirect_uri'
    ];

    /**
     * Get the autoresponders for the projects.
     */
    public function autoresponders()
    {
        return $this->hasMany(Autoresponder::class);
    }

    /**
     * Get the autoresponders for the projects.
     */
    public function subscribers()
    {
        return $this->hasMany(Subscriber::class);
    }
}
