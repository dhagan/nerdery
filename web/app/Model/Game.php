<?php

App::uses('AppModel', 'Model');
App::import('Vendor', 'nusoap', array('file' => 'nusoap' . DS . 'nusoap.php'));

/**
 * Game Model
 *
 */
class Game extends AppModel {

    public $useTable = false;
    public $url = 'http://xbox.sierrabravo.net/v2/xbox.php';
    public $apiKey = '4116ad5dd4044c90ba663fab468a2b0b';
   
    public $Client;

    /**
     * constructor for soap client
     */
    public function __construct() {
	$this->Client = new nusoap_client($this->url);
    }

    /*
     * wrapper function for checking webservice 
     * 
     * return TRUE for valid apiKey, FALSE for invalid apiKey 
     */
    public function checkKey() {
	$parameters = array('apiKey' => $this->apiKey);
	return $this->Client->call('checkKey', $parameters);
    }
    
    /**
     * get games list
     * 
     * @return array of game ojbects, FALSE for invalid apiKey  
     */
    public function games() {
	$parameters = array('apiKey' => $this->apiKey);
	$games = $this->Client->call('getGames', $parameters);
	return $games;
    }

    /**
     * increment the game vote
     * 
     * @param model game id
     * @return TRUE on success,  FALSE for invalid apiKey  
     */
    public function addVote($id) {
	$parameters = array('apiKey' => $this->apiKey, 'id' => $id);
	return $this->Client->call('addVote', $parameters);
    }

    /**
     * add a game record
     *  
     * @param  model request $data game name
     * @return  TRUE on success,  FALSE for invalid apiKey   
     */
    public function addGame($data) {
	$parameters = array('apiKey' => $this->apiKey, 'title' => $data['Game']['title']);
	return $this->Client->call('addGame', $parameters);;
    }

    /**
     * set game status to goit (from wantit)
     * 
     * @param model game id
     * @return  TRUE on success,  FALSE for invalid apiKey   
     */
    public function setGotIt($id) {
	$parameters = array('apiKey' => $this->apiKey, 'id' => $id);
	return $this->Client->call('setGotIt', $parameters);
    }

}
