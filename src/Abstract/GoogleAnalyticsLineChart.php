<?php

namespace The3LabsTeam\NovaGoogleAnalyticsCards\Abstract;

use Carbon\Carbon;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Trend;
use Laravel\Nova\Nova;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\OrderBy;
use Spatie\Analytics\Period;

class GoogleAnalyticsLineChart extends Trend
{
    public $name;

    public function __construct(?string $name = null)
    {
        parent::__construct();
        $this->name = $name ?? __($this->title);
    }

    public function getAnalyticsData(
        int $numberOfDays,
        string $metrics,
        bool $dimensionSortByDesc = false,
        bool $metricSortByDesc = false
    ): array {
        $startDate = Carbon::now()->subDays($numberOfDays);
        $endDate = Carbon::now();
        $orderBy = [
            OrderBy::dimension('date', $dimensionSortByDesc),
            OrderBy::metric($metrics, $metricSortByDesc),
        ];

        $analyticsData = Analytics::get(
            period: Period::create($startDate, $endDate),
            metrics: [$metrics],
            dimensions: ['date'],
            maxResults: $numberOfDays,
            orderBy: $orderBy
        );

        $formattedData = [];
        foreach ($analyticsData as $data) {
            $formattedData[$data['date']->isoFormat('YYYY-MM-DD')] = $data[$metrics];
        }

        $total = array_sum($formattedData);

        return [$total, $formattedData];
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
            //            90 => Nova::__('90 Days'),
        ];
    }

    /**
     * Calculate the value of the metric.
     *
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {

        [$total, $data] = $this->getAnalyticsData(numberOfDays: $request->range, metrics: $this->metrics);

        if (is_int($total)) {
            $format = '0,0';
        } else {
            $format = '0.00%';
            $total = $total / $request->range;
        }

        return $this->result($total) // total values
            ->trend($data) // dates => value
            ->format($format);
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
}
