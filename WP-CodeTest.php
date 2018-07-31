<?php
/*
 Plugin Name: Codetest TeamDivision
 */
require __DIR__ . '/vendor/autoload.php';


function WPCTbuildTable() {
    $teamsData = new WPCT\Supporting\TeamsData("74db8efa2a6db279393b433d97c2bc843f8e32b0");

    $html = $teamsData->getMarkup();

    return $html;
}


add_shortcode('teamsdata', 'WPCTbuildTable');

?>
