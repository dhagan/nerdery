<?php

App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

/**
 * Games Controller
 *
 * @property Game $Game
 */
class GamesController extends AppController {

    /**
     * beforeFilter executes before rendering
     * use checkKey()as an early indication that the webserivice is responsive
     */
    public function beforeFilter() {
	parent::beforeFilter();
	if (!$this->Game->checkKey()) {
	    $this->Session->setFlash('Unable to connect to the Xbox Voting WebService.  Please contact support.');
	    $this->render('index');
	    $this->response->send();
	    $this->_stop();
	}
    }

    /**
     * index method - vote view
     *
     * @return void
     */
    public function index() {
	$games = $this->Game->games();
	if (is_array($games)) {
	    $games = Set::sort($games, '{n}.votes', 'desc');
	    $games = array_filter($games, function( $v ) {
			return $v['status'] == 'wantit';
		    });
	    $this->set('games', $games);
	    if (!$this->viewVars['allow_vote']) {
		$this->Session->setFlash('You have already voted today.  Voting will be enabled for you on the next business day.');
	    }
	} else {
	    $this->Session->setFlash('Xbox Voting Webserice has failed.  Please contact support.');
	}
    }

    /**
     * own - games owned by the Nerdery
     *
     * @return void
     */
    public function own() {
	$games = $this->Game->games();
	if (is_array($games)) {
	    $games = Set::sort($games, '{n}.title', 'asc');
	    $games = array_filter($games, function( $v ) {
			return $v['status'] == 'gotit';
		    });
	    $this->set('games', $games);
	} else {
	    $this->Session->setFlash('The Xbox Voting Webserice has failed.  Please contact support.');
	}
    }

    /**
     * update - functionality to specify game as owned by the Nerdery
     *
     * @return void
     */
    public function update($id = null) {
	$games = $this->Game->games();
	if (is_array($games)) {
	    $games = Set::sort($games, '{n}.title', 'asc');
	    $games = array_filter($games, function( $v ) {
			return $v['status'] == 'wantit';
		    });
	    $this->set('games', $games);
	} else {
	    $this->Session->setFlash('The Xbox Voting Webserice has failed.  Please contact support.');
	}
	if ($this->request->is('post')) {
	    if ($this->Game->setGotIt($id)) {
		$this->Session->setFlash(__('The game has been set as owned'));
		$this->_createVoteSession();
		$this->redirect(array('action' => 'index'));
	    } else {
		$this->Session->setFlash(__('The game could not be updated. Please, try again.'));
	    }
	}
    }

    /**
     * add a game record
     *
     * @return void
     */
    public function add() {
	if ($this->request->is('post')) {
	    $games = $this->Game->games();
	    if (is_array($games)) {
		$is_duplicate = Set::matches($this->request->data['Game']['title'], $games);
		if (!$is_duplicate) {
		    if ($this->Game->addGame($this->request->data)) {
			$this->Session->setFlash(__('The game has been saved'));
			$this->_createVoteSession();
			$this->redirect(array('action' => 'index'));
		    } else {
			$this->Session->setFlash(__('The game could not be saved. Please, try again.'));
		    }
		} else {
		    $this->Session->setFlash(__('The title you have entered is a duplicate.'));
		}
	    } else {
		$this->Session->setFlash('The Xbox Voting Webserice has failed.  Please contact support.');
	    }
	}
    }

    /**
     * vote - increment the vote count
     * 
     * @param type $id 
     */
    public function vote($id = null) {
	if ($this->request->is('post') || $this->request->is('put')) {
	    if ($this->Game->addVote($id)) {
		$this->Session->setFlash(__('Thank you for voting for ' . $this->request->data['Game']['title']));
		$this->_createVoteSession();
	    } else {
		$this->Session->setFlash(__('The game could not be updated. Please, try again.'));
	    }
	}
	$this->redirect(array('action' => 'index'));
    }

    /**
     * names - valid xbox title names for input the the add() form
     */
    public function names() {
	$term = empty($this->request->query['term']) ? null : Sanitize::escape(trim($this->request->query['term']));
	$this->loadModel('GameTitle');
	$titles = $this->GameTitle->find('all', array(
		'conditions' => array(		
		    'name LIKE' => '%' . $term . '%',	
		),
		'fields' => 'GameTitle.name'
	    ));
	$this->_renderAjax(json_encode($titles));
    }

    /**
     * helper function to output ajax
     * 
     * @param type $content
     * @param type $set_json_header 
     */
    private function _renderAjax($content = null, $set_json_header = false) {
	if ($content != null)
	    $this->set('content', $content);
	$this->layout = DS . 'bare';
	if ($set_json_header)
	    header('Content-type: application/json');
	$this->render('/Pages/ajax');
    }

    /**
     * _createVoteSession  - create a session cookie after voting or adding, poor man check of 1 vote per day
     * ideally his belongs int the parent AppController
     */
    private function _createVoteSession() {
	$this->Session->write('Vote.created', date("Y-m-d H:i:s"));
    }

}
