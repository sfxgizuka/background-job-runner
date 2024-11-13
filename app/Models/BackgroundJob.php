<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BackgroundJob extends Model
{
    protected $fillable = [
        'class_name',
        'method_name',
        'parameters',
        'status',
        'error_message'
    ];

    protected $casts = [
        'parameters' => 'array'
    ];

    public function getParametersAttribute($value)
    {
        return json_decode($value, true) ?? [];
    }

    public function setParametersAttribute($value)
    {
        $this->attributes['parameters'] = json_encode($value);
    }
}
