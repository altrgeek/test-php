<?php

use Carbon\CarbonInterval;
use Illuminate\Support\Carbon;

if (!function_exists('carbon')) {
    // public function __construct($time = null, $tz = null);

    /**
     * Returns a new Carbon instance.
     *
     * Please see the testing aids section (specifically static::setTestNow())
     * for more on the possibility of this constructor returning a test instance.
     *
     * @param DateTimeInterface|string|null $time
     * @param DateTimeZone|string|null      $tz
     *
     * @throws InvalidFormatException
     */
    function carbon(
        DateTimeInterface|string|null $time = null,
        DateTimeZone|string|null $tz = null
    ): Carbon {
        return new Carbon($time, $tz);
    }
}

if (!function_exists('loop')) {
    /**
     * Calls the passed callable specified number of times and returns the
     * array of each call's result.
     *
     * @param  callable $callback
     * @param  array  $parameters
     * @param  int  $times
     * @return array
     */
    function loop(callable $callback, array $parameters = [], int $times = 1): array
    {
        if ($times <= 0)
            return 0;

        $results = [];

        for ($i = 0; $i < $times; $i++)
            $results[] = call_user_func_array($callback, [...array_values($parameters), $i + 1]);

        return $results;
    }
}

if (!function_exists('toHumanReadableTime')) {
    /**
     * Converts passed seconds to human readable duration string.
     *
     * @param  int  $seconds
     * @return string
     */
    function toHumanReadableTime(int $seconds)
    {
        $dt = now();
        $days = $dt->diffInDays($dt->copy()->addSeconds($seconds));
        $hours = $dt->diffInHours($dt->copy()->addSeconds($seconds)->subDays($days));
        $minutes = $dt->diffInMinutes($dt->copy()->addSeconds($seconds)->subDays($days)->subHours($hours));
        return CarbonInterval::days($days)->hours($hours)->minutes($minutes)->forHumans();
    }
}
