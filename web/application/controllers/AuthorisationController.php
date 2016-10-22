<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class AuthorisationController extends My_SmartPriceController {

    function __construct() {
        parent::__construct();
    }
	
	function login(){
		$credentials = $this->input->post('data');
		$email = $credentials["email"];
		$password = $credentials["password"];
		
		$this->load->model('AuthorisationModel');
		$user = $this->AuthorisationModel->getUser($email, $password);
		if($user != null){
			$this->setUserSession($user);
		}
		else{
			$this->response(NULL, 400);
		}
	}
	
	function signUp(){
		$user = $this->input->post('data');
		$user = (Object)$user;
		
		$this->load->model('AuthorisationModel');
		$existingUser = $this->AuthorisationModel->getUserFromEmail($user->email);
		if(isset($existingUser)){
			echo "User already Exists";
			return;
		}
		$user = $this->createNewUser($user);
		$this->setUserSession($user);
	}
	
	function adminLogin(){
		$credentials = (array)json_decode($this->input->post('data'));
		$email = $credentials["email"];
		$password = $credentials["password"];
		$this->load->model('AuthorisationModel');
		$user = $this->AuthorisationModel->getUser($email, $password);
		if($user != null && 
		   $user->Email == $email &&
		   $user->Password == $password ){
			if($user->Type == 'Admin'){ 
				$this->setUserSession($user);
				echo 'success';
			}
			else{
				echo 'not admin';
			}
		}
		else{
			//$this->response(NULL, 400);
			echo 'fail';
		}		
	}
	
	private function setUserSession($user){
		$_SESSION['user'] = $user;
	}
	
	private function checkExistingUser($user_profile){
		if($user_profile->email){
			$this->load->model('AuthorisationModel');
			$user = $this->AuthorisationModel->getUserFromEmail($user_profile->email);
			if($user != null){
				$this->setUserSession($user);
				
			}
			else{
				//die( json_encode($user_profile));
				$user = $this->createNewUser($user_profile);
				$this->setUserSession($user);
			}
			$prevLocation = $_SESSION['prevLoc'];
			header('Location:'.$prevLocation);
		}
	}
	
	private function createNewUser($user_profile){
		$this->load->model('AuthorisationModel');
		$user = array("Type" => "siteUser",
					"FirstName" => $user_profile->firstName, 
					"LastName" => $user_profile->lastName,
					"Email" => $user_profile->email );
		if(isset($user_profile->password)){
			$user['Password'] = $user_profile->password;
		}
		$user = (Object)$user;
		$user->Id = $this->AuthorisationModel->createNewUser($user);
		return $user;
	}
	
	
	function logout(){
		unset($_SESSION["user"]);
	}
	
	public function hALogin($provider){
		$_SESSION['prevLoc'] = $_SERVER['HTTP_REFERER'];
		log_message('debug', "controllers.HAuth.login($provider) called");

		try
		{
			log_message('debug', 'controllers.HAuth.login: loading HybridAuthLib');
			$this->load->library('HybridAuthLib');

			if ($this->hybridauthlib->providerEnabled($provider))
			{
				log_message('debug', "controllers.HAuth.login: service $provider enabled, trying to authenticate.");
				$service = $this->hybridauthlib->authenticate($provider);

				if ($service->isUserConnected()){
					log_message('debug', 'controller.HAuth.login: user authenticated.');

					$user_profile = $service->getUserProfile();

					log_message('info', 'controllers.HAuth.login: user profile:'.PHP_EOL.print_r($user_profile, TRUE));
					echo json_encode($user_profile);
					$this->checkExistingUser($user_profile);
				}
				else // Cannot authenticate user
				{
					show_error('Cannot authenticate user');
				}
			}
			else // This service is not enabled.
			{
				log_message('error', 'controllers.HAuth.login: This provider is not enabled ('.$provider.')');
				show_404($_SERVER['REQUEST_URI']);
			}
		}
		catch(Exception $e)
		{
			$error = 'Unexpected error';
			switch($e->getCode())
			{
				case 0 : $error = 'Unspecified error.'; break;
				case 1 : $error = 'Hybriauth configuration error.'; break;
				case 2 : $error = 'Provider not properly configured.'; break;
				case 3 : $error = 'Unknown or disabled provider.'; break;
				case 4 : $error = 'Missing provider application credentials.'; break;
				case 5 : log_message('debug', 'controllers.HAuth.login: Authentification failed. The user has canceled the authentication or the provider refused the connection.');
				         //redirect();
				         if (isset($service))
				         {
				         	log_message('debug', 'controllers.HAuth.login: logging out from service.');
				         	$service->logout();
				         }
				         show_error('User has cancelled the authentication or the provider refused the connection.');
				         break;
				case 6 : $error = 'User profile request failed. Most likely the user is not connected to the provider and he should to authenticate again.';
				         break;
				case 7 : $error = 'User not connected to the provider.';
				         break;
			}

			if (isset($service))
			{
				$service->logout();
			}

			log_message('error', 'controllers.HAuth.login: '.$error);
			show_error('Error authenticating user.');
		}
	}

	public function endpoint()
	{

		log_message('debug', 'controllers.HAuth.endpoint called.');
		log_message('info', 'controllers.HAuth.endpoint: $_REQUEST: '.print_r($_REQUEST, TRUE));

		if ($_SERVER['REQUEST_METHOD'] === 'GET')
		{
			log_message('debug', 'controllers.HAuth.endpoint: the request method is GET, copying REQUEST array into GET array.');
			$_GET = $_REQUEST;
		}

		log_message('debug', 'controllers.HAuth.endpoint: loading the original HybridAuth endpoint script.');
		require_once APPPATH.'/third_party/hybridauth/index.php';

	}
}

?>