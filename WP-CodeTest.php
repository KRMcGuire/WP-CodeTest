<?php
/*
 Plugin Name: Codetest TeamDivision
 */
require __DIR__ . '/vendor/autoload.php';

function WPCTBuildTable() {
    $apiKey = get_option("wpct-api-key");
    $teamsData = new WPCT\Supporting\TeamsData($apiKey, 'http://delivery.chalk247.com/team_list/NFL.JSON?api_key=');
    $html = $teamsData->getMarkup();

    return $html;
}

function WPCTAddScripts() {
    wp_register_script('wpct-script', plugins_url('/js/wpct.js', __FILE__));
    wp_enqueue_script('wpct-script');
}

$settings = new WPCTSettings();

add_shortcode('teamsdata', 'WPCTBuildTable');
add_action('wp_enqueue_scripts', 'WPCTAddScripts');

?>
