<?php
/*
 Plugin Name: Codetest TeamDivision
 */
require __DIR__ . '/vendor/autoload.php';

function WPCTbuildTable() {
    $apiKey = get_option("wpct-api-key");
    $teamsData = new WPCT\Supporting\TeamsData($apiKey);
    $html = $teamsData->getMarkup();

    return $html;
}

$settings = new WPCTSettings();

add_shortcode('teamsdata', 'WPCTbuildTable');

?>
