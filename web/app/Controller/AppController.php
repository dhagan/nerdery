<?php

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    /**
     *  DJH added per tutorial; this is what ultimately redirects you to the users/login
     */
    public $components = array(
	'Session'
    );

    public function beforeFilter() {
	$allow_vote = !$this->_isWeekend(date("Y-m-d H:i:s"));

	$vote_created = $this->Session->read('Vote.created');
	if (!empty($vote_created)) {
	    $vote_date = date('Y-m-d', strtotime($vote_created));
	    $today = date('Y-m-d');
	    $allow_vote = $allow_vote && ($today != $vote_date);
	}
	$this->set('allow_vote', $allow_vote);
    }


    /**
     * helper function to determine weekend
     * @param type $date
     * @return type 
     */
    private function _isWeekend($date) {
	return (date('N', strtotime($date)) >= 6);
    }

}
