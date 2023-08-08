<p align="center">
<img src="https://github.com/the-3labs-team/nova-google-analytics-cards/raw/HEAD/art/banner.png" width="100%" 
alt="Logo Nova Google Analytics Cards by The3LabsTeam"></p>

# Nova Google Analytics Cards

Stay on top of your website's performance with the Google Analytics Insights Package for Laravel Nova. This powerful integration empowers you to seamlessly integrate Google Analytics data directly into your Nova dashboard, offering you a comprehensive and real-time overview of your website's key metrics.


## Requirements

* php >= 8.1
* laravel/framework >= 10.0

## Installation

You can install the package via composer:
```bash
composer require the-3labs-team/nova-google-analytics-cards
```

You can publish the config file with:

```bash
php artisan vendor:publish
```
and choose: `The3LabsTeam\NovaGoogleAnalyticsCards\NovaGoogleAnalyticsCardsServiceProvider`.

You can publish the Google Analytics config file with:
```bash
php artisan vendor:publish
```
**and select: `Spatie\Analytics\AnalyticsServiceProvider`.**

**Note:** this package uses [Laravel Analytics](https://github.com/spatie/laravel-analytics), so you need to configure it
in your `config/analytics.php` file.

**The config file is documented, so choose the option that best suits your needs.**

## Usage

```php
use The3LabsTeam\NovaGoogleAnalyticsCards\Counter\ActiveUsersCounter;use The3LabsTeam\NovaGoogleAnalyticsCards\Counter\NewUsersCounter;use The3LabsTeam\NovaGoogleAnalyticsCards\Counter\PageViewsCounter;use The3LabsTeam\NovaGoogleAnalyticsCards\LineChart\PageViewLineChart;

...

(new ActiveUsersCounter())
(new NewUsersCounter())
(new PageViewsCounter())
            
(new PageViewLineChart())

```
You can also override the name of cards like this:

```php
use The3LabsTeam\NovaGoogleAnalyticsCards\Counter\ActiveUsersCounter;
...

(new ActiveUsersCounter(name: 'The name of the card (string)'))


```

