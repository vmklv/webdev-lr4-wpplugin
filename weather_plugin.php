<?php
/*
Plugin Name: Weather Plugin
Description: Вывод информации о погоде в Архангельске
Version: 1.0
Author: Vladimir Markelov
Author URI: https://github.com/vmklv
*/

add_shortcode('weather_plugin', 'weather_plugin_shortcode');

function weather_plugin_shortcode() {
    $api_key = 'a106e787cfb2f11d0da4b96134eed9ba';
    $city = 'Arkhangelsk';

    $url = "https://api.openweathermap.org/data/2.5/weather?q=$city&appid=$api_key&lang=ru";

    $response = wp_remote_get($url);

    if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
        $data = json_decode(wp_remote_retrieve_body($response), true);

        $temperature = isset($data['main']['temp']) ? $data['main']['temp'] : '';
        $humidity = isset($data['main']['humidity']) ? $data['main']['humidity'] : '';
        $wind_speed = isset($data['wind']['speed']) ? $data['wind']['speed'] : '';
        $weather_description = isset($data['weather'][0]['description']) ? $data['weather'][0]['description'] : '';

        $temperature_celsius = round($temperature - 273.15, 1);

        $output = "<p>Температура: $temperature_celsius &#8451;</p>";
        $output .= "<p>Влажность: $humidity%</p>";
        $output .= "<p>Скорость ветра: $wind_speed m/s</p>";
        $output .= "<p>Описание погоды: $weather_description</p>";

        return $output;
    } else {
        return "<p>Failed to retrieve weather data.</p>";
    }
}
?>

//http://ct45863-wordpress-re86a.tw1.ru