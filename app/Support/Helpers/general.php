<?php

use Illuminate\Support\Collection;
use App\Domain\Enums\LogEnum;
use Carbon\Carbon;

if (!function_exists('add_log')) {
    function add_log(LogEnum $log, array $data): string
    {
        $string = $log->value;

        foreach ($data as $key => $value)
            $string = str_replace( "@" . strtoupper($key) . "@", $data[$key], $string);

        return $string;
    }
}

if (!function_exists('format_date')) {
    /**
     * Format a given date into a specified format.
     *
     * @param string|int|\DateTimeInterface|null $date
     * @param string $format
     * @param string|null $timezone
     * @return string|null
     */
    function format_date($date, string $format = 'Y-m-d', string $timezone = null): ?string
    {
        if (empty($date)) {
            return null;
        }

        try {
            $carbon = Carbon::parse($date);
            if ($timezone) {
                $carbon->setTimezone($timezone);
            }

            return $carbon->format($format);
        } catch (\Exception $e) {
            return null;
        }
    }
}

if (!function_exists('now')) {

    function now(): ?string
    {
        return Carbon::now();
    }
}

if (!function_exists('toLabelValue')) {
    function toLabelValue(Collection $collection, string $labelKey = 'name', string $valueKey = 'id'): array
    {
        return $collection->map(function ($item) use ($labelKey, $valueKey) {
            return [
                'label' => $item->{$labelKey},
                'value' => $item->{$valueKey},
            ];
        })->toArray();
    }
}
