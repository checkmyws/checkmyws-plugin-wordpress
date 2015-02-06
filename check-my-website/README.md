# Check my Website for Wordpress

## API

Check my Website plugin api documentation.

### URL ID

To use the plugin, you **have to set the URL ID** on the Check my Website settings page. Otherwise, the plugin will not work because it is required to query the Check my Website API.

The URL ID is a unique key for each url monitored by Check my Website. You can obtain it on the [Check my Website console](https://console.checkmy.ws). Don't forget to enable the API access for your url too. Go to settings of your url on the console and set "Status page" to "Yes" and get your url id (url id example : 624e853d-b0f3-9bf9-8417-c7157aze7t).

*Note : the Check my Website API access required a [subscription plan](https://checkmy.ws/en/pricing). Not available for free plan.*

### Request interval

To allow you to choose a specific interval query cache for the Check my Website API (the data are stored in your database), the plugin provide an interval option.

You can select 1, 5 or 10 minutes interval on the Check my Website settings page of the plugin.

## Options

Check my Website plugin options documentation.

### Style

To allow you to choose a specific stylesheet by default for the plugin display (dashboard and widget), the plugin provide a style option.

You can select classic (simple design) / light (more convenient for white theme) / dark (more convenient for black theme) on the Check my Website settings page of the plugin.

### Time unit

To allow you to choose a specific time unit by default for the plugin metrics (dashboard, widgets and shortcode), the plugin provide a unit option.

You can select millisecond (ms) / second (s) on the Check my Website settings page of the plugin.

### Shortcode

To allow you to display your Check my Website data anywhere on your site, the plugin provide a shortcode.

You can enable / disable this option on the Check my Website settings page of the plugin.

#### Usage

Check my Website shortcode is easy to use it. You must write **[cmws]** with parameters in your Wordpress post or page.

display :
- description : choose display type (all or some data)
- values : full (default) / custom

label :
- description : show labels (names)
- values : true (default) / false

url :
- description : show monitored url
- values : true / false (default)

state :
- description : show current state
- values : true / false (default)

duration :
- description : show state duration
- values : true / false (default)

grade :
- description : show YSlow grade (performance)
- values : true / false (default)

score :
- description : show YSlow score (performance)
- values : true / false (default)

availability :
- description : show availability on 24h
- values : true / false (default)

response :
- description : show latest response time
- values : true / false (default)

average :
- description : show average response time on 24h
- values : true / false (default)

#### Examples

- display all

`[cmws display=full]`

you can use this way too :

`[cmws display=custom label=true url=true state=true duration=true grade=true score=true availability=true response=true average=true]`

- display a specific data

`[cmws display=custom grade=true]`

you can disable data label display :

`[cmws display=custom label=false grade=true]`

### Dashboard widget

To allow you to display your Check my Website data resume on your home admin site, the plugin provide a dashboard widget.

You can enable / disable this option on the Check my Website settings page of the plugin.

### Widget

To allow you to display your Check my Website data on your public site, the plugin provide a widget.

You can enable / disable this option on the Check my Website settings page of the plugin.

Then go to the Widgets page of your Wordpress admin-site to configure it like any other Wordpress plugin.