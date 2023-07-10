<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdditionalData extends Model
{
    protected $table = 'additional_data';

    protected $fillable = [
        'key',
        'value',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'value' => 'json',
    ];

    public function related()
    {
        return $this->morphTo('related');
    }
}
