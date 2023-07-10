<?php

namespace App\Models\Traits;

trait AdditionalData
{
    protected static function bootAdditionalData()
    {
        static::deleting(function ($model) {
            $model->additionalData()->delete();
        });
    }

    public function additionalData()
    {
        return $this->morphMany(\App\Models\AdditionalData::class, 'related');
    }

    public function getData(string $key, $default = null)
    {
        return $this->additionalData()->where('key', $key)->value('value') ?? $default;
    }

    public function storeData(string | array $key, mixed $value = null)
    {
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                $this->storeData($k, $v);
            }
        } else {
            if ($value === null) {
                throw new \Exception('Value cannot be null');
            }

            $data = $this->additionalData()->where('key', $key)->first();
            if ($data !== null) {
                $data->update([
                    'value' => $value,
                ]);

                return $data;
            }

            return $this->additionalData()->create([
                'key' => $key,
                'value' => $value,
            ]);
        }
    }

    protected function incrementOrDecrementData($key, $amount, $method)
    {
        if (! is_numeric($amount)) {
            throw new \InvalidArgumentException('The amount parameter must be numeric');
        }

        $data = $this->additionalData()->where('key', $key)->first();
        if ($data === null) {
            throw new \Exception("The {$key} key does not exist");
        }

        $value = (float) $data->value;
        $value = ($method === 'increment') ? $value + $amount : $value - $amount;

        return $this->storeData($key, $value);
    }

    public function incrementData($key, $amount = 1)
    {
        return $this->incrementOrDecrementData($key, $amount, 'increment');
    }

    public function decrementData($key, $amount = 1)
    {
        return $this->incrementOrDecrementData($key, $amount, 'decrement');
    }
}
