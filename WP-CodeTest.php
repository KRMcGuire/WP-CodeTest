<?php
/*
 Plugin Name: Codetest TeamDivision
 */
defined('ABSPATH') or die('Killed');
require __DIR__ . '/vendor/autoload.php';


function buildTable($attr) {
    $teamsData = new TeamsData("dfsdfdsf");
    $data = $teamsData->getData();
    return $data;
}

add_shortcode('teamsdata', 'buildTable');

?>
