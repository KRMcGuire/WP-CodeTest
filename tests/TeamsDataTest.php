<?php
/**
 * Unit tests for the TeamsData class.
 * 
 * PHP version 7.0
 *
 * @author Kieran McGuire <kieran.r.mcguire@gmail.com>
 */

require __DIR__ . '/../vendor/autoload.php';

class TeamsDataTest extends PHPUnit\Framework\TestCase {
    public function testWorksFromValidFile() {
	$teamData = new WPCT\Supporting\TeamsData("34", __DIR__ . "/resources/full.json?api_key=");
	//agh
	$testString = "<div id='teams'><p><input id='teamfilter'></input> <button onclick='wpctFilter()'>filter</button></p>"
            . "<h2>NFC</h2><h3>West</h3><ul><li>Arizona</li><li>LA Rams</li><li>San Francisco</li><li>Seattle</li></ul><h3>South</h3><ul><li>Atlanta</li><li>Carolina</li>"
	    . "<li>New Orleans</li><li>Tampa Bay</li></ul><h3>North</h3><ul><li>Chicago</li><li>Detroit</li><li>Green Bay</li><li>Minnesota</li></ul><h3>East</h3><ul><li>Dallas</li>"
	    . "<li>NY Giants</li><li>Philadelphia</li><li>Washington</li></ul><h2>AFC</h2><h3>North</h3><ul><li>Baltimore</li><li>Cincinnati</li><li>Cleveland</li><li>Pittsburgh</li>"
	    . "</ul><h3>East</h3><ul><li>Buffalo</li><li>Miami</li><li>NY Jets</li><li>New England</li></ul><h3>West</h3><ul><li>Denver</li><li>Kansas City</li><li>LA Chargers</li>"
	    . "<li>Oakland</li></ul><h3>South</h3><ul><li>Houston</li><li>Indianapolis</li><li>Jacksonville</li><li>Tennessee</li></ul></div>";
	$this->assertEquals($testString, $teamData->getMarkup());
	
	return $teamData;
    }

    /**
     * @depends testWorksFromValidFile
     */
    public function testWorksFromRebuild($teamData) {
	$teamData->setAPIKey('20');
	$teamData->setAPIURL(__DIR__ . "/resources/partial.json?api_key=");
	$testString = "<div id='teams'><p><input id='teamfilter'></input> <button onclick='wpctFilter()'>filter</button></p>"
	    . "<h2>NFC</h2><h3>West</h3><ul><li>Arizona</li><li>LA Rams</li></ul><h3>East</h3><ul><li>Dallas</li></ul></div>";

	$teamData->fetchData();
	$this->assertEquals($testString, $teamData->getMarkup());
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage JSON was unable to be parsed
     */
    public function testFailsGracefullyFromInvalidJSON() {
        $teamData = new WPCT\Supporting\TeamsData("42", __DIR__ ."/resources/broken.json?api_key=");
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage Invalid JSON path
     */
    public function testFailsGracefullyFromInvalidPath() {
	$teamData = new WPCT\Supporting\TeamsData("5453", __DIR__ . "/kangaroo/pizza.xml?stuff=");
    }
}


?>
