<?php

class TeamsData
{

    //The API key
    private $apiKey;

    /**
     * Construct the TeamData object
     */
    public function __construct($key) {
	$this->apiKey = $key;
    }

    /**
     * Fetches the Team Data from the API using the provided key, processes it,
     * and returns it as an associative array
     */
    public function getData() {
	$rawJSON = file_get_contents("http://delivery.chalk247.com/team_list/NFL.JSON?api_key=" . $this->apiKey);
	
	if  (file_get_contents == false)
	{
	    return false;
	}
	
	$processedJSON = json_decode($rawJSON, true);
	
	if ($processedJSON == false) {
	    return false;
	}

	return $processedJSON;
    }


}

?>
