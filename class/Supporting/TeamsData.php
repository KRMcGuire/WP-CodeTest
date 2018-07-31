<?php

namespace WPCT\Supporting;

class TeamsData
{

    //The API key
    private $apiKey;
    
    //The API's URL
    private $apiURL;    
	
    //The associative array representing the JSON data
    private $jsonData;

    //An associative array built from jsonData, but sorted for the markup builder.
    private $sortedData;

    //The final HTML string produced at the end of the building process. 
    private $markupString;

    /**
     * Construct the TeamData object
     *
     * @param string $key The API key for the server
     * @param string $url The URL for the server
     *
     * @return TeamsData
     */
    public function __construct($key, $url) {
	$this->apiKey = $key;
	$this->apiURL = $url;
	$this->fetchData();
    }

    /**
     * Calls the json fetcher and markup builder.
     *
     * @param string $key The API key for the server. If not provided, the saved one will be used
     * 
     * @return void
     */
    public function fetchData($key = false) {
	$this->jsonData = false;
	$this->sortedData = false;
	$this->markupString = false;
	if (!$key) {
	    $this->_fetchJSON();
	} else {
            $this->_fetchJSON($key);
	}
        $this->_buildMarkup();
    }

    /**
     * Fetches the Team Data from the API using the provided key, processes it,
     * and assigns the resulting associative array to the object's $jsonData, then
     * sort the data for easier use by _buildMarkup
     *
     * @param string $key (Optional) An API Key for the server. If not provided, the saved one will be used.
     *
     * @return void
     */
    private function _fetchJSON($key = false) {
	if (!$key) {
	    $rawJSON = @file_get_contents($this->apiURL . $this->apiKey);
	} else {
	    $rawJSON = @file_get_contents($this->apiURL . $key);
	}

	if  ($rawJSON === false) {
            throw new \Exception("Invalid JSON path");
	}
	
	$processedJSON = json_decode($rawJSON, true);
	
	if ($processedJSON == false) {
	    throw new \Exception("JSON was unable to be parsed");
	    return false;
	}

	$this->jsonData = $processedJSON;

	$sortedData = [];
	foreach ($this->jsonData['results']['data']['team'] as $team) {
	   $sortedData[$team['conference']][$team['division']][$team['id']] = $team['name']; 
	}
	$this->sortedData = $sortedData;
    }


    /**
     * Build the markup that the shortcode inserts
     *
     * @return void
     */
    private function _buildMarkup() {
	if (!$this->jsonData) {
	    $this->markupString = false;
	}

	$markupString = "";
	foreach ($this->sortedData as $conference => $divisions) {
	    $markupString .= "<h2>$conference</h2>";
	    foreach ($divisions as $division => $teams) {
		$markupString .= "<h3>$division</h3><ul>";
		foreach ($teams as $team) {
		    $markupString .= "<li>$team</li>";
		}
		$markupString .= "</ul>";
	    }
	}
	$this->markupString = $markupString;
    }

    /**
     * Get the saved API Key.
     *
     * @return string
     */
    public function getAPIKey() {
       return $this->apiKey;
    }

    /**
     * Change the saved API Key. The build fetchData() function will
     * need to be rerun before new data is reflected.
     *
     * @param string $key The key to save
     *
     * @return void
     */
    public function setAPIKey($key) {
	$this->apiKey = $key;
    }

    /**
     * Get the API's URL.
     *
     * @return string
     */
    public function getAPIURL() {
	return $this->apiURL;
    }

    /**
     * Set the API's URL
     *
     * @param string $url The URL to set
     *
     * @return void
     */
    public function setAPIURL($url) {
        $this->apiURL = $url;
    }

    /**
     * Get the JSON array
     *
     * @return Associative Array
     */
    public function getJSON() {
        return $this->jsonData;
    }

    /**
     * Get the sorted team data array
     *
     * @return Associative Array
     */
    public function getSortedData() {
       return $this->sortedData;
    }

    /**
     * Get the HTML markup produced by the builder
     * 
     * @return string
     */
    public function getMarkup() {
	return $this->markupString;
    }




}

?>
