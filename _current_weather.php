<?php

	# http://simplehtmldom.sourceforge.net/manual.htm
	require_once './simple_html_dom.php';



	# Get sources data for current weather
	$ya_weather_dom = file_get_html('http://pogoda.yandex.ru/moscow/details');


	# Get the current temperature...
	$temperature = $ya_weather_dom
			->find('div[class=current-weather__thermometer_type_now]', 0)
			->innertext;
	$temperature = preg_replace('#[^\d]#si', '', $temperature);
	$temperature = "{$temperature}&thinsp;&deg;C";
	$temperature_html = "<div class=\"temperature\">{$temperature}</div>";


	# Get the current moon state...
	$el = $ya_weather_dom->find('div[class=forecast-detailed__moon]', 0);
	preg_match('#icon_moon_\d+#si', $el->innertext, $moon_state);
	$moon_html .= "<div class=\"moon_state {$moon_state[0]}\"></div>";


	# Get the weather icon...
	$el = $ya_weather_dom->find('div[class=current-weather] span[class=current-weather__col_type_now] i[class=icon]', 0);
	preg_match('# icon_thumb_([a-z\-]+)"#si', $el->outertext, $weather_icon);
	switch ($weather_icon[1]) {
		case 'skc-d': $weather_class = 'sunny'; break;
		case 'skc-n': $weather_class = 'starry'; break;
		case 'ovc': $weather_class = 'cloudy'; break;
		case 'bkn-d': $weather_class = 'sunny cloudy'; break;
		case 'bkn-n': $weather_class = 'starry cloudy'; break;

		case 'bkn_ra_d': $weather_class = 'sunny rainy'; break;
		case 'bkn_-ra_d': $weather_class = 'sunny rainy'; break;
		case 'bkn_ra_n': $weather_class = 'starry rainy'; break;
		case 'bkn_-ra_n': $weather_class = 'starry rainy'; break;
		case 'ovc_ra': $weather_class = 'rainy'; break;
		case 'ovc_-ra': $weather_class = 'rainy'; break;
		case 'ovc_ts_ra': $weather_class = 'stormy rainy'; break;
		case 'bkn_sn_d': $weather_class = 'sunny snowy'; break;

		case 'bkn_-sn_d': $weather_class = 'sunny snowy'; break;
		case 'bkn_sn_n': $weather_class = 'starry snowy'; break;
		case 'bkn_-sn_n': $weather_class = 'starry snowy'; break;
		case 'ovc_sn': $weather_class = 'snowy'; break;
		case 'ovc_-sn': $weather_class = 'snowy'; break;
		case 'ovc_ts_sn': $weather_class = 'stormy snowy'; break;
		default: $weather_class = null; break;
	}
	/*//
		http://yastatic.net/weather/i/icons/svg/{$weather_icon}.svg

		skc-d 		—	sunny day			—	https://yastatic.net/weather/i/icons/svg/skc-d.svg
		skc-n 		—	starry night		—	https://yastatic.net/weather/i/icons/svg/skc-n.svg
		ovc 		—	cloudy				—	https://yastatic.net/weather/i/icons/svg/ovc.svg
		bkn-d 		—	cloudy day			—	https://yastatic.net/weather/i/icons/svg/bkn-d.svg
		bkn-n 		—	cloudy night		—	https://yastatic.net/weather/i/icons/svg/bkn-n.svg

		bkn_ra_d 	—	very rainy day		—	https://yastatic.net/weather/i/icons/svg/bkn_ra_d.svg
		bkn_-ra_d 	—	rainy day			—	https://yastatic.net/weather/i/icons/svg/bkn_-ra_d.svg
		bkn_ra_n 	—	very rainy night	—	https://yastatic.net/weather/i/icons/svg/bkn_ra_n.svg
		bkn_-ra_n 	—	rainy night			—	https://yastatic.net/weather/i/icons/svg/bkn_-ra_n.svg
		ovc_ra 		—	very rainy			—	https://yastatic.net/weather/i/icons/svg/ovc_ra.svg
		ovc_-ra 	—	rainy				—	https://yastatic.net/weather/i/icons/svg/ovc_-ra.svg
		ovc_ts_ra 	—	rainy storm			—	https://yastatic.net/weather/i/icons/svg/ovc_ts_ra.svg

		bkn_sn_d 	—	very snowy day		—	https://yastatic.net/weather/i/icons/svg/bkn_sn_d.svg
		bkn_-sn_d 	—	snowy day			—	https://yastatic.net/weather/i/icons/svg/bkn_-sn_d.svg
		bkn_sn_n 	—	very snowy night	—	https://yastatic.net/weather/i/icons/svg/bkn_sn_n.svg
		bkn_-sn_n 	—	snowy night			—	https://yastatic.net/weather/i/icons/svg/bkn_-sn_n.svg
		ovc_sn 		—	very snowy			—	https://yastatic.net/weather/i/icons/svg/ovc_sn.svg
		ovc_-sn 	—	snowy				—	https://yastatic.net/weather/i/icons/svg/ovc_-sn.svg
		ovc_ts_sn 	—	snowy storm			—	https://yastatic.net/weather/i/icons/svg/ovc_ts_sn.svg
	//*/

	$weather_html = null;
	$weather_class = explode(' ', $weather_class);
	foreach ($weather_class as $class) {
		$weather_html .= '<div class="' . $class . '"></div>';
	}
	// $nows = ['sunny', 'cloudy', 'rainy', 'snowy', 'rainbow', 'starry', 'stormy'];
	// echo '<div class="'.$nows[mt_rand(0, count($nows)-1)].'"></div>';
	// echo '<div class="starry"></div>';



	$html =
		$weather_html . "\r\n" . $moon_html . "\r\n" . $temperature_html;


	if (isset($_GET['json'])) {
		header( 'Content-Type: application/json' );
		die( json_encode( array(
			'weather_type' => implode(',', $weather_class),
			'moon_state' => $moon_state[0],
			'temp' => $temperature,
			'html' => $html,
	) ) ); } else echo $html;

