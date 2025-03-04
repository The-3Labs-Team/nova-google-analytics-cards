<?php

namespace The3LabsTeam\NovaGoogleAnalyticsCards\Partition;

use Carbon\Carbon;
use Google\Analytics\Data\V1beta\Filter;
use Google\Analytics\Data\V1beta\Filter\StringFilter;
use Google\Analytics\Data\V1beta\Filter\StringFilter\MatchType;
use Google\Analytics\Data\V1beta\FilterExpression;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\Period;

class RefClickPartition extends Partition
{
    public $article;

    public function __construct(?int $articleId = null)
    {
        parent::__construct();

        $this->name = __('nova-google-analytics-cards::messages.refClickPartitionTitle');
        $this->article = config('nova-google-analytics-cards.article_model')::find($articleId);
    }

    public function getAnalyticsData(): ?array
    {
        $numberOfDays = 30;
        $startDate = Carbon::now()->subDays($numberOfDays);
        $endDate = Carbon::now();

        if ($this->article && $this->article->isNotPublished()) {
            return null;
        }

        $dimensionFilter = null;
        if ($this->article && $this->article->ga_page_path) {
            $dimensionFilter = new FilterExpression([
                'filter' => new Filter([
                    'field_name' => 'pagePath',
                    'string_filter' => new StringFilter([
                        'match_type' => MatchType::EXACT,
                        'value' => $this->article->ga_page_path,
                    ]),
                ]),
            ]);
        }

        $analyticsData = Analytics::get(
            period: Period::create($startDate, $endDate),
            metrics: ['eventCount'],
            dimensions: ['linkDomain'],
            maxResults: $numberOfDays,
            dimensionFilter: $dimensionFilter
        );

        return $analyticsData->toArray();
    }

    /**
     * Calculate the value of the metric.
     *
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        $analyticsData = $this->getAnalyticsData('linkDomain');

        $results = [
            'Amazon' => 0,
            'Ebay' => 0,
            'Instant Gaming' => 0,
            'Socials' => 0,
            __('Others') => 0,
        ];

        if (! $analyticsData) {
            return $this->result($results);
        }

        $socials = config('nova-google-analytics-cards.socials');
        foreach ($analyticsData as $data) {
            if ($data['linkDomain'] === '') {
                continue;
            }
            if ($data['linkDomain'] === 'amazon.it') { // Amazon
                $results['Amazon'] += $data['eventCount'];
            } elseif ($data['linkDomain'] === 'ebay.it' || $data['linkDomain'] === 'ebay.com') { // Ebay
                $results['Ebay'] += $data['eventCount'];
            } elseif ($data['linkDomain'] === 'instant-gaming.com') {// Instant Gaming
                $results['Instant Gaming'] += $data['eventCount'];
            } elseif (in_array($data['linkDomain'], $socials)) { // Socials
                $results['Socials'] += $data['eventCount'];
            } else {
                $results[__('Others')] += $data['eventCount'];
            }
        }

        return $this->result($results);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'users-by-plan';
    }
}
