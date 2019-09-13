<?php
namespace app\controllers;
use lithium\storage\Session;

class RegisterController extends \lithium\action\Controller {
	protected function _init(){
		$this->_render['layout'] = 'amp';
		parent::_init();
	}
	public function index(){
		
	}
	public function newuser(){}
}
?>