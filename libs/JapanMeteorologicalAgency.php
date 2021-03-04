<?php
/**
 * Japan Meteorological Agency
 * Get a weather data from Japan Meteorological Agency website.
 */
date_default_timezone_set ('Asia/Tokyo');

$jma = file_get_contents('https://www.jma.go.jp/bosai/forecast/data/forecast/400000.json');
$jma = mb_convert_encoding($jma, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
$forecast = json_decode($jma, true);

//echo $forecast[0]['timeSeries'][2]['areas'][0]['temps'][0];

$entries = [];
$update = date('Y-m-d H:i:s');
$venue = $forecast[0]['timeSeries'][0]['areas'][0]['area']['name'];
$venue = str_replace('地方', '', $venue);
$day = $forecast[0]['reportDatetime'];
$datetime = DateTime::createFromFormat('Y-m-d\TH:i:s+', $day);
$datetime = (array)$datetime;
$year = new DateTime($datetime['date']);
$year = $year->format('Y');
$month = new DateTime($datetime['date']);
$month = $month->format('n');
$day = new DateTime($datetime['date']);
$day = $day->format('j');
$weather = $forecast[0]['timeSeries'][0]['areas'][0]['weathers'][0];
$weather_id = '';
$weather_image = '';
$codes = $forecast[0]['timeSeries'][0]['areas'][0]['weatherCodes'][0];
$svg = 'https://www.jma.go.jp/bosai/forecast/img/'. $codes .'.svg';
$temp = $forecast[0]['timeSeries'][2]['areas'][0]['temps'][0];

if ( $codes == '100' || $codes == '500' ) {
  $weather_id = '1';
  $weather_image = 'sunny.png';
} elseif ( $codes == '200' ) {
  $weather_id = '2';
  $weather_image = 'cloudly.png';
} elseif ( $codes == '300' || $codes == '308' ) {
  $weather_id = '3';
  $weather_image = 'rain.png';
} elseif ( $codes == '400' || $codes == '406' ) {
  $weather_id = '4';
  $weather_image = 'snow.png';
} elseif ( $codes == '101' || $codes == '110' || $codes == '201' || $codes == '210' || $codes == '501' || $codes == '510' || $codes == '601' || $codes == '610' ) {
  $weather_id = '5';
  $weather_image = 'sunny_then_cloudy.png';
} elseif ( $codes == '102' || $codes == '112' || $codes == '301' || $codes == '311' || $codes == '502' || $codes == '512' || $codes == '701' || $codes == '711' ) {
  $weather_id = '6';
  $weather_image = 'sunny_then_rain.png';
} elseif ( $codes == '104' || $codes == '115' || $codes == '401' || $codes == '411' || $codes == '504' || $codes == '515' || $codes == '801' || $codes == '811' ) {
  $weather_id = '7';
  $weather_image = 'sunny_then_snow.png';
} elseif ( $codes == '202' || $codes == '212' || $codes == '214' || $codes == '302' || $codes == '313' ) {
  $weather_id = '8';
  $weather_image = 'cloudy_then_rain.png';
} elseif ( $codes == '204' || $codes == '215' || $codes == '402' || $codes == '413' ) {
  $weather_id = '9';
  $weather_image = 'cloudy_then_snow.png';
} elseif ( $codes == '303' || $codes == '314' || $codes == '403' || $codes == '414' ) {
  $weather_id = '10';
  $weather_image = 'rain_then_snow.png';
} else {
  $weather_id = '0';
  $weather_image = 'sunny.png';
}

$json_url = '../assets/json/weather.json';
$json = file_get_contents($json_url);
$json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
$json_array = json_decode($json, true);

if ( $json_array != NULL ) {
  $daytime_temp = $json_array[0]['temp'];
}

if ( !$temp ) {
  $temp = $daytime_temp;
}

$entries[] = [
  'update'        => $update,
  'venue'         => $venue,
  'year'          => $year,
  'month'         => $month,
  'day'           => $day,
  'weather'       => $weather,
  'weather_id'    => $weather_id,
  'weather_image' => $weather_image,
  'codes'         => $codes,
  'svg'           => $svg,
  'temp'          => $temp,
];
var_dump($entries);

$array = json_encode($entries);
file_put_contents($json_url , $array);

?>
