# SecretLocation

Share your location and movements without revealing your actual location.

This project allows you to share your location and your movements relative to a location that is only known to you.

Usually, the coordinate system that we use is centered on [Null Island](https://en.wikipedia.org/wiki/Null_Island), the point on earth where the Prime Meridian and the Equator intersect, at exactly 0°N, 0°E. With *SecretLocation* you define your own Null Island and can share your current location and past movements relative to that location. Where this custom Null Island is located is not revealed to the people you are sharing your location with. Your location is not shown on a map, but on a blank canvas.


## Setup

You need an Apache web server with PHP.

Upload the files and folders from this repository to your webserver, whether you access it from its own domain, subdomain or just as a directory does not matter.

Copy `config.sample.json` as `config.json` and modify the copied file to configure SecretLocation:

1. Add a write key.
1. Add a read key.
1. Set how many location reports to keep around.
1. Define your custom Null Island.
1. Add some markers.

Now you should be all set on this end. Make sure that `config.json` and `locations.json` cannot be accessed from the web.


## Config

```json
{
	"writeKey": "demo-write",
	"readKey": "demo-read",
	"keep": 150,
	"nullIsland": {
		"lat": -15.9587411,
		"lon": -5.785443
	},
	"markers": [
		{
			"label": "Home",
			"lat": 0.0,
			"lon": 0.0
		},
		{
			"label": "Work",
			"lat": 1.0,
			"lon": 1.0
		}
	]
}
```

| Parameter | Description |
|-----------|-------------|
| `writeKey` | The secret key to allow adding a new location to your history. I would suggest using an encryption or API key generator (e.g. [this one](https://www.allkeysgenerator.com/Random/Security-Encryption-Key-Generator.aspx) or [that one](https://keygen.io/)) to generate a key. |
| `readKey` | The secret key to allow viewing your location history. I would suggest using an encryption or API key generator (e.g. [this one](https://www.allkeysgenerator.com/Random/Security-Encryption-Key-Generator.aspx) or [that one](https://keygen.io/)) to generate a key. |
| `keep` | The number of location reports to keep. If you update your location every 10 minutes, 144 locations would be 24 hours. |
| `nullIsland` | The center of your custom coordinate system (e.g. the coordinates of your home). |
| `nullIsland.lat` | Latitude |
| `nullIsland.lon` | Longitude |
| `markers` | A list of static markers to be shown alongside your location history. Coordinates are relative to the custom center (i.e. to show a marker at your custom Null Island, set its `lat` and `lon` to `0`). |
| `markers[#].label` | The label shown on that marker |
| `markers[#].lat` | Latitude |
| `markers[#].lon` | Longitude |




## Adding location reports

To report your location and add it to your location history, you need to call `add.php` with your write key and the coordinates as query parameters.

```
https://secretlocation.yourdomain.com/add.php?lat=-15.958&lon=-5.7854&key=yourSecretWriteKey
```

If you are using an Android phone you can use Tasker to periodically get your location and call `add.php` for your.




## Viewing location history

To view your location history, go to `view.php` with the view key as a query parameter.  
Anyone who knows the URL and the view key can see your location history.

```
https://secretlocation.yourdomain.com/view.php?key=yourSecretViewKey
```




## Using Tasker to update your location history (Android only)

- Install and open Tasker
- Make sure you are on the **Profiles** tab (1) and tap the **+** button (2) in the bottom right corner to add a new profile  
<img src="https://i.imgur.com/WlbFFea.png" width="200">

- Select **Time** from the dropdown that appears  
<img src="https://i.imgur.com/1GxxOO6.png" width="200">

- Set the time from 12:00AM to 11:59PM and interval to every 10 minutes (or whatever interval and time frame you want to cover) and click the back arrow in the top left corner.  
<img src="https://i.imgur.com/nU4e7PS.png" width="200">

- You will be back on the Profiles screen and a **New Task** button (1) should be visible. Tap that button.  
<img src="https://i.imgur.com/NOtEGC0.png" width="200">

- Enter a **name** for that task and confirm (1).  
<img src="https://i.imgur.com/BYCySHu.png" width="200">

- From the **Action Category** list pick **Locaton** (1)  
<img src="https://i.imgur.com/47mpIPf.png" width="200">

- Then, from the **Location Action** list pick **Get Location v2** (1)  
<img src="https://i.imgur.com/ZV33iNJ.png" width="200">

- Look through the options for that action to see if you want to change anything (e.g. minimum accuracy, enable location if needed, timeout...), then tap the back arrow in the top left corner to go back to the Task Edit screen.
- Tap the plus button (1) in the bottom right corner to add a new step to the task.  
<img src="https://i.imgur.com/JB6CCS1.png" width="200">

- From the **Action Category** list pick **Net** (1) then **HTTP Request** (1)  
<img src="https://i.imgur.com/x8BuVij.png" width="200"> <img src="https://i.imgur.com/RXWzxki.png" width="200">

- Set **Method** to **GET** (1), **URL** to the URL to **add.php** (2) and **QueryParameters** to `lat=%gl_latitude&lon=%gl_longitude&key=yourSecretWriteKey` (3)  
`%gl_latitude` and `%gl_longitude` are variables received from the previous (get location) step. `yourSecretWriteKey` of course has to be replaced with your write key.  
Once done, tap the back arrow in the top left corner to go back to the Task Edit screen.
<img src="https://i.imgur.com/krMK19G.png" width="200">

- You can use the play button at the bottom of the screen to run the task and test it. If it works you can exit the Task Edit screen (back arrow).
- Make sure Tasker is not disabled.  
<img src="https://i.imgur.com/JnkXR4n.png" width="200">
