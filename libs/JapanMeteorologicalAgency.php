<?php
/**
 * Japan Meteorological Agency
 * Get a weather data from Japan Meteorological Agency website.
 */

date_default_timezone_set ('Asia/Tokyo');

$html = file_get_contents('https://www.jma.go.jp/jp/yoho/346.html');
//$html = file_get_contents('https://www.jma.go.jp/en/yoho/346.html');
$html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
$dom = new DOMDocument;
@$dom->loadHTML($html);
$xpath = new DOMXPath($dom);

$entries = [];
$datetime = date('Y-m-d H:i:s');
$venue = $xpath->evaluate('normalize-space(//table[@class="forecast"]/tr/th[1])', $node);
$venue = str_replace('地方', '', $venue);
$day = $xpath->evaluate('normalize-space(//table[@class="forecast"]/tr[2]/th[1])', $node);
$day = preg_replace('/[^0-9]/', '', $day);
$weather = $xpath->evaluate('normalize-space(//table[@class="forecast"]/tr[2]/th[1]/img/@alt)', $node);
$weather_id = '';
$weather_image = '';
$icon = $xpath->evaluate('normalize-space(//table[@class="forecast"]/tr[2]/th[1]/img/@src)', $node);
$icon = preg_replace('/[^0-9]/', '', $icon);
$temp = $xpath->evaluate('normalize-space(//table[@class="forecast"]/tr[2]/td[3][@class="temp"]/div/table/tr[2]/td[3])', $node);
$temp = str_replace('度', '', $temp);

if ( $icon == '100' || $icon == '700' ) {
  $weather_id = '1';
  $weather_image = 'sunny.png';
} elseif ( $icon == '200' ) {
  $weather_id = '2';
  $weather_image = 'cloudy.png';
} elseif ( $icon == '300' || $icon == '308' ) {
  $weather_id = '3';
  $weather_image = 'rain.png';
} elseif ( $icon == '400' || $icon == '406' ) {
  $weather_id = '4';
  $weather_image = 'snow.png';
} elseif ( $icon == '101' || $icon == '110' || $icon == '201' || $icon == '210' || $icon == '701' || $icon == '704' || $icon == '707' || $icon == '710' ) {
  $weather_id = '5';
  $weather_image = 'sunny_then_cloudy.png';
} elseif ( $icon == '102' || $icon == '112' || $icon == '301' || $icon == '311' || $icon == '702' || $icon == '705' || $icon == '708' || $icon == '711' ) {
  $weather_id = '6';
  $weather_image = 'sunny_then_rain.png';
} elseif ( $icon == '104' || $icon == '115' || $icon == '401' || $icon == '411' || $icon == '703' || $icon == '706' || $icon == '709' || $icon == '712' ) {
  $weather_id = '7';
  $weather_image = 'sunny_then_snow.png';
} elseif ( $icon == '202' || $icon == '212' || $icon == '302' || $icon == '313' ) {
  $weather_id = '8';
  $weather_image = 'cloudy_then_rain.png';
} elseif ( $icon == '204' || $icon == '215' || $icon == '402' || $icon == '413' ) {
  $weather_id = '9';
  $weather_image = 'cloudy_then_snow.png';
} elseif ( $icon == '303' || $icon == '314' || $icon == '403' || $icon == '414' ) {
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
  'datetime' => $datetime,
  'venue'    => $venue,
  'day'      => $day,
  'weather'  => $weather,
  'weather_id'  => $weather_id,
  'weather_image'  => $weather_image,
  'icon'     => $icon,
  'temp'     => $temp,
];
var_dump($entries);

// 個別にノード取得する処理
//echo $xpath->evaluate('string(//table[@class="forecast"]/tr/th)', $node);
//echo $xpath->evaluate('normalize-space(//table[@class="forecast"]/tr/th[1])', $node);
//echo $xpath->evaluate('string(//table[@class="forecast"]/tr/th[2])', $node);
//echo $xpath->evaluate('string(//table[@class="forecast"]/tr/th[3])', $node);
//echo $xpath->evaluate('normalize-space(//table[@class="forecast"]/tr[2]/th[1])', $node);
//echo $xpath->evaluate('normalize-space(//table[@class="forecast"]/tr[2]/th[1]/img/@alt)', $node);
//echo $xpath->evaluate('normalize-space(//table[@class="forecast"]/tr[2]/th[1]/img/@src)', $node);
//echo $xpath->evaluate('normalize-space(//table[@class="forecast"]/tr[2]/td[3][@class="temp"]/div/table/tr[2]/td[3])', $node);
//echo $xpath->evaluate('string(//table[@class="forecast"]/tr[3]/td[3][@class="temp"]/div/table/tr[2]/td[3])', $node);

// foreach で回してノード取得する処理
/*foreach ($xpath->query('//table[@class="forecast"]/tr') as $node) {
  foreach ($xpath->query('.//th', $node) as $tag_node) {
    echo $tag_node->nodeValue;
    echo "\n";
    echo '<br>';
  }
}*/
/*var_dump($entries);*/

$array = json_encode($entries);
file_put_contents('../assets/json/weather.json' , $array);
?>
