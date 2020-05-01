<?php

namespace App\Values;

use Illuminate\Support\Collection;
use MyCLabs\Enum\Enum as Base;

class Enum extends Base
{
    /**
     * Get the values and keys as a collection.
     *
     * @return Illuminate\Support\Collection
     */
    public static function toCollection() : Collection
    {
        return collect(static::toArray());
    }

    /**
     * Get the raw values.
     *
     * @return Illuminate\Support\Collection
     */
    public static function rawValues() : Collection
    {
        return static::toCollection()->values();
    }

    /**
     * Get the friendly values for the enum.
     *
     * Value => Friendly Name
     *
     * @return Illuminate\Support\Collection
     */
    public static function friendlyValues() : Collection
    {
        return static::toCollection()
            ->flip()
            ->map(function ($value) {
                return strtolower($value);
            })
            ->map('snake_case')
            ->map(function ($value) {
                return str_replace('_', ' ', $value);
            })
            ->map(function ($value) {
                return ucwords($value);
            });
    }

    /**
     * Get the friendly value.
     *
     * @return string
     */
    public function friendlyValue() : string
    {
        return static::friendlyValues()
            ->get($this->value);
    }

    /**
     * Get a random enum.
     *
     * @return MyCLabs\Enum\Enum
     */
    public static function random() : self
    {
        return new static(static::toCollection()->random());
    }
}