<?
session_start();

uses('app/models/user.php');

class Controller_User extends Controller
{
	function action_index(){
		$this->data['title']='Войти / Регистрация';
		$this->data['formpath']='/user/signinhandler';
		
		$this->view->generate('view_singform.php', 'layout_default.php', $this->data);
	}
	
	function action_signinhandler(){ /* обработка формы почта+пароль */
		if($_POST['enter']){
			$email = $_POST['email'] = $this->makeCharsSecure($_POST['email']);
			$password = $_POST['password'] = $this->makeCharsSecure($_POST['password']);
			
			$user = User::getInstance();
			$activation = $user->checkActivation($email);
			
			if($activation==true){/*Проверить авторизован и активирован*/
				/*Если авторизован то в мой аккаунт*/
				if ($user->openSession($email,$password))
					Route::Redirect(0, '', '/user/myaccount');
				else Route::Redirect(1,'Неверный пароль.');
			}else{
				/*Если нет то в почту*/
				$user->mailToNewAccount($email,$password);
			}
		}else MessageSend(1, 'Упс...', '/404');
	}

	function action_activate()
	{
		if ($code = $this->makeCharsSecure($_POST['_params']['code']))
		{
			$user = User::getInstance();
			$user->mailHandlerActivator($code);
		} else Route::Redirect(1, 'Ошибка активации.', '/');
	}
	
	
	function action_logout()
	{
		setcookie("user", "", time() - 1, "/");
		$_SESSION = array();
		session_destroy();
		header("Location: http://".$_SERVER['HTTP_HOST']);
	}
	
	function action_account(){
		$this->view->generate('view_singform.php', 'layout_default.php', $this->data);
	}
	
}