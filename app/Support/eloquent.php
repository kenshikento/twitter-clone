<?php

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use MyCLabs\Enum\Enum;

/**
 * Helper for model getters using enums.
 *
 * @param  string $class
 * @param  mixed $value
 * @return ?Enum
 */
function enum_getter(string $class, $value = null)
{
    if (is_numeric($value)) {
        $value = (int) $value;
    }

    if ($value instanceof Enum) {
        $value = $value->getValue();
    }

    return (! is_null($value)) ? new $class($value) : null;
}

/**
 * Helper for model setters using enums.
 *
 * @param  string       $class
 * @param  mixed       $value
 * @param  bool|bool $nullable
 * @return mixed
 */
function enum_setter(string $class, $value, bool $nullable = false)
{
    if ($nullable && is_null($value)) {
        return;
    }

    if (! $value instanceof $class) {
        $value = new $class((string) $value);
    }

    return $value->getValue();
}

/**
 * Helper for model setters using enums.
 *
 * @param  string       $class
 * @param  mixed       $value
 * @return mixed
 */
function enum_setter_int(string $class, $value)
{
    if (! $value instanceof $class) {
        $value = new $class((int) $value);
    }

    return $value;
}

/**
 * Get the page html schema declaration.
 *
 * @param  ...Model $models
 * @return ?Illuminate\Support\HtmlString
 */
function splice_models(Collection $ones, Collection $twos) : Collection
{
    $onesAndTwos = new Collection;

    $ones->each(function ($model) use ($onesAndTwos, $twos) {
        $onesAndTwos->push($model);

        if ($twos->isNotEmpty() && mt_rand(1, 10) > 4) {
            $onesAndTwos->push($twos->shift());
        }
    });

    $twos->each(function ($model) use ($onesAndTwos) {
        $onesAndTwos->push($model);
    });

    return $onesAndTwos;
}

/**
 * Get the content to index.
 *
 * @param  string|stdClass $content
 * @return string
 */
function prepare_content_for_algolia($content) : string
{
    return strip_tags(render_content($content)->toHtml());
}

/**
 * Assign attributes from old to new.
 *
 * @param  Illuminate\Database\Eloquent\Model  $from
 * @param  Illuminate\Database\Eloquent\Model  $to
 * @param  array  $ignore
 * @return Illuminate\Database\Eloquent\Model
 */
function reassign_model_attributes(Model $from, Model $to, array $ignore) : Model
{
    // Get all of the attribuets
    $keys = collect($from->getAttributes())
        // Forget about the ones we don't care about
        ->reject(function ($raw, $key) use ($ignore) {
            return in_array($key, $ignore);
        })
        // Convert links
        ->map(function ($raw) use ($from, $to) {
            if (is_string($raw) && Str::startsWith($raw, $from->route)) {
                return str_replace($from->route, $to->route, $raw);
            }

            return $raw;
        })
        // Then assign them to the new model
        ->each(function ($raw, $key) use ($from, $to) {
            $to->setAttribute($key, $from->getAttribute($key));
        });

    return $to;
}