<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Autoresponder extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_id',
        'provider',
        'api_uri',
        'name',
        'campaign',
        'public_key',
        'private_key',
        'is_enabled'
    ];

    /**
     * Get the project.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the project.
     */
    public function server()
    {
        return $this->belongsTo(Server::class);
    }
}
