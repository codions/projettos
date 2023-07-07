<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;

trait HasCodeId
{
    protected static function bootHasCodeId()
    {
        static::created(function ($model) {
            if (empty($model->code)) {
                $model->code = (string) Str::upper(Str::random(6) . $model->id);
                $model->save();
            }
        });
    }

    public function scopeCode($query, $code)
    {
        return $query->where('code', $code);
    }

    public static function findCode($code)
    {
        return self::code($code)->first();
    }
}
