<?php
namespace app\controllers;
use lithium\storage\Session;
use app\extensions\action\GoogleAuthenticator;
use app\extensions\action\Functions;
use app\extensions\action\Uuid;

use app\models\X_coaches;
use app\models\X_courses;
use app\models\X_topics;
use app\models\X_assignments;
use app\models\X_quizes;
use app\models\X_categories;
use app\models\X_urls;
use app\models\X_personalitytests;
use app\models\X_personalityusers;
use app\models\X_personalityresults;

class AssessmentController extends \lithium\action\Controller {

	protected function _init(){
		parent::_init();
		$this->_render['layout'] = 'coach';
	}

	public function index(){
		
	if($this->request->data){
		$data = $this->request->data;
		$person = X_personalityusers::create();
		$id = $person->save($data);
	//	print_r($id);
		$questions = X_personalitytests::find('all');
		$this->redirect(['Assessment::index'], ['exit' => true]);
	}
		$questions = X_personalitytests::find('all');
		return compact('questions');
		
	}
public function assess($id=null){
	
	$personalityusers = X_personalityusers::find('first',array(
		'conditions'=>array('_id'=>$id)
	));
	
	$a=14;$e=20;$n=38;$c=14;$o=8;
	
	
	for($i=1;$i<=50;$i++){
		$question = 'selected'.$i;
		$questions = X_personalitytests::find('first', array(
			'conditions'=>array('Number'=>(string)$i)
		));
		$variable = 'selected'.$i;
		
					// print_r($questions['Category'].": ");
					// print_r($variable.": ");
					// print_r($questions['Action']);
					// print_r($personalityusers[$variable]."# ");
		switch ($questions['Category']){
			case "A":
			if($questions['Action']=="+"){
				$a = $a + $personalityusers[$variable];
			}
			if($questions['Action']=="-"){
				$a = $a - $personalityusers[$variable];
			}
			break;
			case "E":
			if($questions['Action']=="+"){
				$e = $e + $personalityusers[$variable];
			}else{
				$e = $e - $personalityusers[$variable];
			}
			break;
			case "N":
			if($questions['Action']=="+"){
				$n = $n + $personalityusers[$variable];
			}else{
				$n = $n - $personalityusers[$variable];
			}
			break;
			case "C":
			if($questions['Action']=="+"){
				$c = $c + $personalityusers[$variable];
			}else{
				$c = $c - $personalityusers[$variable];
			}
			break;
			case "O":
			if($questions['Action']=="+"){
				$o = $o + $personalityusers[$variable];
			}else{
				$o = $o - $personalityusers[$variable];
			}
			break;
			
		}
	}
	
	$a = (integer)$a/10;
	$e = (integer)$e/10;
	$n = (integer)$n/10;
	$c = (integer)$c/10;
	$o = (integer)$o/10;
	
	$resultA = X_personalityresults::find('all',array(
		'conditions'=>array(
			'Category'=>'A',
			),
		));
	foreach($resultA as $r){
		if($r['Point']==round($a)){
			$AnalysisA = $r['Discription']." (".$a."): ". $r['Analysis'];
		}
	}
		$resultE = X_personalityresults::find('all',array(
		'conditions'=>array(
			'Category'=>'E',
			),
		));
	foreach($resultE as $r){
		if($r['Point']==round($e)){
			$AnalysisA = $r['Discription']." (".$e."): ". $r['Analysis'];
		}
	}
		$resultN = X_personalityresults::find('all',array(
		'conditions'=>array(
			'Category'=>'N',
			),
		));
	foreach($resultN as $r){
		if($r['Point']==round($n)){
			$AnalysisN = $r['Discription']." (".$n."): ". $r['Analysis'];
		}
	}
		$resultC = X_personalityresults::find('all',array(
		'conditions'=>array(
			'Category'=>'C',
			),
		));
	foreach($resultC as $r){
		if($r['Point']==round($c)){
			$AnalysisC = $r['Discription']." (".$c."): ". $r['Analysis'];
		}
	}
		$resultO = X_personalityresults::find('all',array(
		'conditions'=>array(
			'Category'=>'O',
			),
		));
	foreach($resultO as $r){
		if($r['Point']==round($o)){
			$AnalysisO = $r['Discription']." (".$o."): ". $r['Analysis'];
		}
	}
		
	return compact('personalityusers','a','e','n','c','o','AnalysisA','AnalysisE','AnalysisC','AnalysisN','AnalysisO');
}
}
?>