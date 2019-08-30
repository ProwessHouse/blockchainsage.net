<?php
namespace app\controllers;
use lithium\storage\Session;
use app\extensions\action\GoogleAuthenticator;
use app\extensions\action\Functions;
use app\extensions\action\Uuid;

use app\models\X_coaches;
use app\models\X_courses;

use \Swift_MailTransport;
use \Swift_Mailer;
use \Swift_Message;
use \Swift_Attachment;

class CoachController extends \lithium\action\Controller {

	protected function _init(){
		parent::_init();
		$this->_render['layout'] = 'coach';
	}

	public function index($json=null){
		$courses = X_courses::find('all',
			array(
				'order'=>array('Title',array('ASC'=>1))
			));
		if($json==null){
			return compact('courses');
		}else{
			$data = array();
			foreach($courses as $course){
				$coach = X_coaches::find('first',
						array('conditions'=>array('CoachID'=>$course['CoachID']))
				);
				array_push($data,array('Title'=>$course['Title'],'Coach'=>$coach['FirstName'].' '.$coach['LastName']));
			}
			return $this->render(array('json' => array("success"=>"Yes",'courses'=>$data)));		      
		}
	}
	public function register(){
		if($this->request->data){
			$uuid = new Uuid();
			$data = array(
				'DateTime'=> new \MongoDate(),
				'FirstName'=>ucfirst(strtolower($this->request->data['FirstName'])),
				'LastName'=>ucfirst(strtolower($this->request->data['LastName'])),
				'Email'=>strtolower($this->request->data['Email']),
				'Gender'=>strtolower($this->request->data['Gender']),
				'DateofBirth'=>strtolower($this->request->data['DateofBirth']),
				'Mobile'=>$this->request->data['Mobile'],
				'CountryCode'=>$this->request->data['CountryCode'],
				'Password'=>password_hash($this->request->data['Password'], PASSWORD_BCRYPT),
				'CoachID'=> str_replace("}","",str_replace("{","",$uuid->create_guid())),
			);
			$coach = X_coaches::find('first',array(
				'conditions' => array(
					'Email'=>$this->request->data['Email'],
					'Mobile'=>$this->request->data['Mobile']
				)
			));

			if(count($coach)==1){
				$Message = "Already Registered! Please signin!";
				if($this->request->data['json']=='true'){
					return $this->render(array('json' => array("success"=>"No",compact('Message'))));		      
				}else{
					return compact('Message');
				}
			}else{
				$coaches = X_coaches::create()->save($data);
				$smsotp = $this->sendotp($data['Mobile'],$data['CountryCode'],$data['CoachID']);
				$mobileotp = $this->sendEmailTo($data['Email'],$data['CoachID']);
				$Message = "Registered! Please verify your email / phone!";
				if($this->request->data['json']=='true'){
					return $this->render(array('json' => array("success"=>"Yes","Message"=>$Message,"coaches"=>$coaches)));		      
				}else{
					return compact('Message');
				}
			}
		}
	}
	public function signin(){
		if($this->request->data){
			$email = $this->request->data['Email'];
			$coach = X_coaches::find('first',array(
				'conditions' => array(
					'Email'=>strtolower($this->request->data['Email']),
				)
			));
			
			if(count($coach)==1){
				if (password_verify($this->request->data['Password'], $coach['Password'])) {
					$Message = "Registered! Please verify your email / phone!";
					if($this->request->data['json']=='true'){
						return $this->render(array('json' => array("success"=>"Yes",compact('Message'))));		      
					}else{
						return compact('Message');
					}
				}else{
					$Message = "Email / Password is incorrect!";
					if($this->request->data['json']=='true'){
						return $this->render(array('json' => array("success"=>"Yes",compact('Message'))));		      
					}else{
						return compact('Message');
					}
					
				}
			}else{
				$Message = "Not Registered!";
				if($this->request->data['json']=='true'){
					return $this->render(array('json' => array("success"=>"Yes",compact('Message'))));		      
				}else{
					$Message = "Registered! Please verify your email / phone!";
					return compact('Message');
				}
			}
		}
	}
	
	
	public function sendotp($mobile,$countrycode,$coachid){
  
  $mobile = $countrycode.$mobile;
		$ga = new GoogleAuthenticator();
		$otp = $ga->getCode($ga->createSecret(64));	 
 		$data = array(
				'otp.mobile' => $otp,
			);
		$conditions = array("CoachID"=>(string)$coachid);
		X_coaches::update($data,$conditions);
  $function = new Functions();
  $msg =  $otp . " is the OTP to verify your mobile number/n-- Coaching Hub";
  $returnvalues = $function->twilio($mobile,$msg,$otp);	 // Testing if it works 
  $returnvalues = $function->sendSms($mobile,$msg);	 // Testing if it works 
  return $otp;		
 }
	 private function sendEmailTo($email,$coachid){
			$ga = new GoogleAuthenticator();
			$otp = $ga->getCode($ga->createSecret(64));	 
			$data = array(
			'otp.email' => $otp,
			);
			
			$coach = X_coaches::find('first',array(
				'conditions'=>array('Email'=>$email)
			));
			$emaildata = array(
				'coach' => $coach,
				'email' => $email,
				'otp.email'=>$otp
			);
			$conditions = array("CoachID"=>(string)$coachid);
			X_coaches::update($data,$conditions);
			$function = new Functions();
			$compact = array('data'=>$emaildata);
			$from = array(NOREPLY => "noreply@sff.team");
			$email = $email;
			
			$function->sendEmailTo($email,$compact,'coach','otp','Email Verify - OTP',$from,'','','','');
// sendEmailTo($email, $compact ,$controller,$template,$subject,$from,$mail1,$mail2 ,$mail3,$attach )
	}
}
?>