<?php

namespace The3LabsTeam\NovaGoogleAnalyticsCards\Abstract;

use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use Laravel\Nova\Nova;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\Period;

class GoogleAnalyticsCounter extends Value
{
    public $name;

    public function __construct(?string $name = null)
    {
        parent::__construct();
        $this->name = $name ?? __($this->title);
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [
            7 => Nova::__('7 Days'),
            30 => Nova::__('30 Days'),
            60 => Nova::__('60 Days'),
            90 => Nova::__('90 Days'),
            365 => Nova::__('365 Days'),
        ];
    }

    /**
     * Determine the amount of time the results of the metric should be cached.
     *
     * @return \DateTimeInterface|\DateInterval|float|int|null
     */
    public function cacheFor()
    {
        return now()->addMinutes(config('nova-google-analytics-cards.cache_ttl'));
    }

    /**
     * Calculate the value of the metric.
     *
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        $results = $this->getData($request, $this->metrics);

        if (is_int($results)) {
            $format = '0,0';
        } else {
            $format = '0.00%';
        }

        return $this->result($results)->format($format);
    }

    /**
     * Return data from Google Analytics API
     */
    public function getData(NovaRequest $request, string $metrics): mixed
    {
        $analyticsData = Analytics::get(Period::days($request->range), [$metrics]);
        $results = $analyticsData[0][$metrics];

        return $results;
    }
}
