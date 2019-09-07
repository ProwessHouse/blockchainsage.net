<?php
namespace app\controllers;
use lithium\storage\Session;
use app\extensions\action\GoogleAuthenticator;
use app\extensions\action\Functions;
use app\extensions\action\Uuid;

use app\models\X_coaches;
use app\models\X_courses;
use app\models\X_categories;
use app\models\X_urls;

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
				array_push($data,array('Title'=>$course['Title'],'Coach'=>$coach['FirstName'].' '.$coach['LastName'],'Category'=>$course['Category']));
			}
			$categories = X_categories::find('all');
			$dataCategory = array();
			foreach($categories as $cat){
				array_push($dataCategory,array('Category'=>$cat['CategoryName']));
			}
			return $this->render(array('json' => array("success"=>"Yes",'courses'=>$data,'categories'=>$dataCategory)));
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
				'geoData'=>json_decode($this->request->data['geoData'],true),
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
					if($coach['otp']['emailVerify']=='Yes' && $coach['otp']['mobileVerify']=='Yes'){
						$Message = "Registered & verified!";
						if($this->request->data['json']=='true'){
							return $this->render(array('json' => array("success"=>"Yes",'verified'=>'Yes',compact('Message'),'coach'=>$coach)));		      
						}
				}else{
						$Message = "Registered! Please verify your email / phone!";
						if($this->request->data['json']=='true'){
							return $this->render(array('json' => array("success"=>"Yes",'verified'=>'No',compact('Message'))));		      
						}else{
						return compact('Message');
					}
				}
			}else{
				$Message = "Not Registered!";
				if($this->request->data['json']=='true'){
					return $this->render(array('json' => array("success"=>"No",compact('Message'))));		      
				}else{
					$Message = "Registered! Please verify your email / phone!";
					return compact('Message');
				}
			}
		}
				return $this->render(array('json' => array("success"=>"No")));		      
		}
	}
	public function coach($email=null,$json=null){
			$coach = X_coaches::find('first',array(
				'conditions' => array(
					'Email'=>strtolower($email),
				)
			));
			if(count($coach)==1){
				if($json=='true'){
					return $this->render(array('json' => array("success"=>"Yes",'coach'=>$coach)));		      
				}
			}else{
				return $this->render(array('json' => array("success"=>"No")));		      
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
			$conditions = array("CoachID"=>(string)$coachid);
			X_coaches::update($data,$conditions);
			
			$coach = X_coaches::find('first',array(
				'conditions'=>array('Email'=>$email)
			));
			
			$emaildata = array(
				'coach' => $coach,
				'email' => $email,
				'otp'=>$otp
			);
			
			
			$function = new Functions();
			$compact = array('data'=>$emaildata);
			$from = array(NOREPLY => "noreply@blockchainsage.net");
			$email = $email;
			
			$function->sendEmailTo($email,$compact,'coach','otp',$otp.' - OTP Verify Email',$from,'','','','');
// sendEmailTo($email, $compact ,$controller,$template,$subject,$from,$mail1,$mail2 ,$mail3,$attach )
	}
	
	public function otpmobile(){
		$json = $this->request->data['json'];
			if($this->request->data){
			$coach = X_coaches::find('first',array(
				'conditions'=>array(
					'CoachID'=>$this->request->data['coachIDMobile'],
					'otp.mobile'=>$this->request->data['otpMobile'],
					)
			));
			if(count($coach)==1){
				if($json=='true'){
					return $this->render(array('json' => array("success"=>"Yes")));		
				}
			}else{
				return $this->render(array('json' => array("success"=>"No")));		      
			}
		}
			return $this->render(array('json' => array("success"=>"No")));		      
	}
	
	public function otpemail(){
		$json = $this->request->data['json'];
		if($this->request->data){
			$coach = X_coaches::find('first',array(
				'conditions'=>array(
					'CoachID'=>$this->request->data['coachIDEmail'],
					'otp.email'=>$this->request->data['otpEmail'],
					)
			));
			if(count($coach)==1){
				if($json=='true'){
					return $this->render(array('json' => array("success"=>"Yes")));		      
				}
			}else{
				return $this->render(array('json' => array("success"=>"No")));		      
			}
		}
		return $this->render(array('json' => array("success"=>"No")));		      
	}
	public function saveverify(){
	$json = $this->request->data['json'];
	
		if($this->request->data){
			$conditions= array('CoachID'=>$this->request->data['coachIDVerify']);
			$data = array(
				'otp.emailVerify'=>'Yes',
				'otp.mobileVerify'=>'Yes',
			);
			$coach = X_coaches::update($data,$conditions);	
			if($coach){
				return $this->render(array('json' => array("success"=>"Yes")));
			}else{
				return $this->render(array('json' => array("success"=>"No")));
			}
		}
		return $this->render(array('json' => array("success"=>"No")));
	}
	public function updateCourse(){
		$uuid = new Uuid();
		if($this->request->data){
			$CourseID = str_replace("}","",str_replace("{","",$uuid->create_guid()));
			$data = array(
				'CourseID' => $CourseID,
				'Category' => $this->request->data['Category'],
				'CoachID' => $this->request->data['CoachID'],
				'Title' => $this->request->data['CourseTitle'],
			);
			$course = X_courses::create()->save($data);
			$data = array(
				'CourseID' => $CourseID
			);
			$conditions = array(
				'CoachID' => $this->request->data['CoachID']
			);
			$coach = X_coaches::update($data,$conditions);	
			return $this->render(array('json' => array("success"=>"Yes")));
		}
		return $this->render(array('json' => array("success"=>"No")));
	}
	public function getCourse(){
		if($this->request->data){
			$conditions = array(
				'CourseID' => $this->request->data['CourseID']
			);
			$course = X_courses::find('first',array(
				$conditions
			));
			return $this->render(array('json' => array("success"=>"Yes",'course'=>$course)));
		}
	}
	
	public function editcourse(){
		if($this->request->data){
			$conditions = array(
				'CourseID' => $this->request->data['CourseID']
			);
			$data = array(
				'Title'=>$this->request->data['CourseTitle'],
				'Category'=>$this->request->data['Category'],
				'Description'=>$this->request->data['Description'],
				'Cost'=>(integer)$this->request->data['Cost'],
				'Duration'=>$this->request->data['Duration'],
			);
			$course = X_courses::update($data,$conditions);	
		}
	return $this->render(array('json' => array("success"=>"Yes",'course'=>$conditions)));
	}
	
	public function urls(){
		$urls = X_urls::find('all');
		$dataUrl = array();
			foreach($urls as $url){
				array_push($dataUrl,array('URL'=>$url['url']));
			}
		return $this->render(array('json' => array("success"=>"Yes",'urls'=>$dataUrl)));
	}
}
?>