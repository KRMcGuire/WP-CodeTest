<?php
/*
 Plugin Name: Codetest TeamDivision
 */
require __DIR__ . '/vendor/autoload.php';

function WPCTbuildTable() {
    $apiKey = get_option("wpct-api-key");
    //$teamsData = new WPCT\Supporting\TeamsData("74db8efa2a6db279393b433d97c2bc843f8e32b0");
    $teamsData = new WPCT\Supporting\TeamsData($apiKey);
    $html = $teamsData->getMarkup();

    return $html;
}

$settings = new WPCTSettings();

add_shortcode('teamsdata', 'WPCTbuildTable');

?>
