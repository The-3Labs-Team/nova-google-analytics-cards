<p align="center">
<img src="https://github.com/the-3labs-team/nova-google-analytics-cards/raw/HEAD/art/banner.png" width="100%" 
alt="Logo Nova Google Analytics Cards by The3LabsTeam"></p>

# Nova Google Analytics Cards

Stay on top of your website's performance with the Google Analytics Insights Package for Laravel Nova. This powerful integration empowers you to seamlessly integrate Google Analytics data directly into your Nova dashboard, offering you a comprehensive and real-time overview of your website's key metrics.

## Requirements

* php ^8.1|^8.2|^8.3
* laravel/framework ^10.0|^11.0

## Version Compatibility

| Laravel | Nova | PHP     | Package  |
|---------|------|---------|----------|
| 10.x    | 4.x  | 8.1     | 1.x      |
| 11.x    | 4.x  | 8.2/8.3 | 2.x      |


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

### Using the `PageViewLineChart` and `RefClickPartition` card in single Article

1. Add in your `Article` model the following attribute:

```php
/**
* Return the page path for Google Analytics
*/
public function getGaPagePathAttribute(): string
{
   return str_replace(config('app.url'), '', $this->route);
}
```

2. Add the card in your `Nova\Article` resource:

```php
public function cards(NovaRequest $request)
{
    return [
        (new PageViewLineChart(articleId: $request->resourceId))->width('1/2 ')
            ->onlyOnDetail()
            ->height('dynamic'),
        (new RefClickPartition(articleId: $request->resourceId))->width('1/3')
                ->onlyOnDetail()
                ->height('dynamic'),
    ];
}
```
## Sponsor

<div>  
    <a href="https://www.tomshw.it/" target="_blank" rel="noopener noreferrer">
        <img  src="https://3labs-assets.b-cdn.net/assets/logos/banner-github/toms.png" alt="Tom's Hardware - Notizie, recensioni, guide all'acquisto e approfondimenti per tutti gli appassionati di computer, smartphone, videogiochi, film, serie tv, gadget e non solo" />  
    </a>
    <a href="https://spaziogames.it/" target="_blank" rel="noopener noreferrer" >
        <img src="https://3labs-assets.b-cdn.net/assets/logos/banner-github/spazio.png" alt="Spaziogames - Tutto sul mondo dei videogiochi. Troverai tantissime anteprime, recensioni, notizie dei giochi per tutte le console, PC, iPhone e Android." />
    </a>
    <br/>
    <a href="https://cpop.it/" target="_blank" rel="noopener noreferrer" >
        <img src="https://3labs-assets.b-cdn.net/assets/logos/banner-github/cpop.png" alt="Cpop - News, recensioni, guide su fumetto, cinema & serie TV, gioco da tavolo e di ruolo e collezionismo. Tutto quello di cui hai bisogno per rimanere aggiornato sul mondo della cultura pop"/>
    </a>
    <a href="https://data4biz.com/" target="_blank" rel="noopener noreferrer" >
        <img src="https://3labs-assets.b-cdn.net/assets/logos/banner-github/d4b.png" alt="Data4Biz - Sito dedicato alla trasformazione digitale del business" />
    </a>
    <br/>
    <a href="https://soshomegarden.com/" target="_blank" rel="noopener noreferrer" >
        <img src="https://3labs-assets.b-cdn.net/assets/logos/banner-github/sos.png" alt="SOS Home & Garden - Realtà dedicata a 360 gradi ai settori della casa e del giardino." />
    </a>
    <a href="https://global.techradar.com/it-it" target="_blank" rel="noopener noreferrer" >
        <img src="https://3labs-assets.b-cdn.net/assets/logos/banner-github/techradar.png" alt="Techradar - Le ultime notizie e recensioni dal mondo della tecnologia, su computer, sistemi per la casa, gadget e altro." />
    </a>
    <br/>
    <a href="https://aibay.it/" target="_blank" rel="noopener noreferrer" >
        <img src="https://3labs-assets.b-cdn.net/assets/logos/banner-github/aibay.png" alt="Aibay - Scopri AiBay, il leader delle notizie sull'intelligenza artificiale. Resta aggiornato sulle ultime innovazioni, ricerche e tendenze del mondo AI con approfondimenti, interviste esclusive e analisi dettagliate." />
    </a>
    <a href="https://coinlabs.it/" target="_blank" rel="noopener noreferrer" >
        <img src="https://3labs-assets.b-cdn.net/assets/logos/banner-github/coinlabs.png" alt="Coinlabs - Notizie, analisi approfondite, guide e opinioni aggiornate sul mondo delle criptovalute, blockchain e finanza" />
    </a>

</div>

