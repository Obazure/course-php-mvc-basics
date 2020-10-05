<?

session_start();

class User extends Model {
	
	private static $_singleton;
	
	public static function getInstance() {
		if(!self::$_singleton) {
			self::$_singleton = new User();
		}
		return self::$_singleton;
	}
	
	protected $user = NULL;
	
	public function checkActivation($email){
		$rtn = $this->db->select_query('users',' activation ', ['email'=> $email],'ORDER BY timestamp DESC LIMIT 1');
		return ($rtn['activation']==1)? true: false;
	}
	public function mailToNewAccount($email,$password){	
		if (!$email or !$password)
			Route::Redirect(1,'Данные не корректны!');
		
			$rtn = $this->db->select_query('users',' * ', ['email'=> $email],'ORDER BY timestamp DESC LIMIT 1');
			
			$Code = substr(base64_encode($email), 0, -1);
			mail($email,
				 "Confirmation letter from ".$_SERVER['HTTP_HOST'],
				 "\nHi ".$email."!\nPlease click next link to confirm your registration. \n http://".$_SERVER['HTTP_HOST']."/user/activate/code/".substr($Code, -5).substr($Code, 0, -5),
				 "From: ".$_SERVER['HTTP_HOST']);
			
			if ($this->db->insert_query('users',['email' => $email,'password' => $password]))
				Route::Redirect(2,'Отправлено письмо для подтверждения на эл.почту <b>'.$email.'</b>! Пожалуйста активируйте аккаунт.');
				else Route::Redirect(1,'Что-то пошло не так, попробуйте заного или свяжитесь с администратором!');
	}
	
	public function mailHandlerActivator($code){
		$email = base64_decode(substr($code, 5).substr($code, 0, 5));

		if(strpos($email,'@')!==false)
		{
			$rtn = $this->db->select_query('users',' * ', ['email'=> $email],'ORDER BY timestamp DESC LIMIT 1');
			if ($rtn['activation']!=1)
			{
				$this->db->update_query('users',['activation'=>1],['email'=> $email]);
				Route::Redirect(3,'Активировано.','/');
			} else Route::Redirect(1, 'Email already activated!', '/');
		}else Route::Redirect(1,'Пользователь с почтой '.$email.' не найден.','/');
}
	
	public function checkLoginStatus($what_to_return=NULL)
	{
		
		if (!empty($_SESSION['session_hash']))
		{
			$this->db->execute_query("DELETE FROM `users_session_hash` WHERE timestamp < (NOW() - INTERVAL 1 HOUR)");
				
			$user_hash_face = $this->db->select_query('users_session_hash',' id as hash_id, user as user_id ', ['hash'=> $_SESSION['session_hash']],'ORDER BY timestamp DESC LIMIT 1');
			$user_hash_face['user_id']+=0;
			if ($user_hash_face['user_id']!=0) {
				if (!empty($what_to_return)) 
				{
					return $user_hash_face[$what_to_return];
				}
					else return true;
			}
		}
		return false;
	}
	
	public function getUser($name='',$password=''){
		/*
		 * Проверяем входные данные, чтобы они не были пустыми.
		 */
		$id = $this->checkLoginStatus('user_id');
		

		$name = $this->makeCharsSecure(mb_strtolower($name));
		$password = $this->encryptPass($name, $this->makeCharsSecure($password));


if($id!=0) {
			$this->user = $this->db->select_query('users',' * ',['id'=>$id], 'LIMIT 1');
			return $this->user;
		}else {
		

		if (empty($name) or empty($password)) {Route::Redirect(1,'Введены пустые данные!');}
		
		/*
		 * ПРоверяем существует ли пользователь. Если нет, то создаем.
		 */
		$this->user = $this->db->select_query('users',' * ',['name'=>$name], 'LIMIT 1');
		
		if (!empty($this->user['password']) and $this->user['password']!=$password) Route::Redirect(1,'Неверные логин или пароль!');
		
		if($this->user==false) {
			$this->user['id'] = $this->db->insert_query('users',['name' => $name,'password' => $password]);
			$this->db->insert_query('users_payment_store',['user' => $id,'amount' => '0']);
			$this->user['name'] = $name;
			$this->user['password'] = $password;
			$this->user['role'] = 0;
		}
		
		/*
		 * По пользователю создаем сессию
		 */
		$_SESSION['session_hash'] = md5($this->user['name'].$this->user['password'].time());
		$this->db->insert_query('users_session_hash',['hash' => $_SESSION['session_hash'],'user' => $this->user['id']]);
		
		return $this->user;
		}
	}
	
	public function getCurrentAccount(){
		$tmp = array_values ($this->db->select_query('users_payment_store', 'SUM(amount)', ['user'=>$this->checkLoginStatus('user_id')]));
		$this->user['account'] = $tmp[0] + 0;
		return $this->user['account'];
	}
	
	public function addMoney($user,$money){
		$tmp = $this->db->insert_query('users_payment_store',['user' => $user,'amount' => $money]);
		if (!empty($tmp) and is_numeric($tmp)) return true;
		else return false;	
	}
	
	public function getUsersList(){
		$rtn = $this->db->select_query('users','id,name','');
		return $rtn;
	}
	public function getAccounts(){
		$rtn = $this->db->execute_select_query('users_payment_store','SUM(amount), `users`.name ','INNER JOIN  `users` ON  `users_payment_store`.`user` =  `users`.`id` GROUP BY `users`.`id` ORDER BY `users`.`name` DESC');
		if(!empty($rtn) and empty($rtn[0])) $rtn = array($rtn);
		return $rtn;
	}
	
	private function encryptPass($login,$pass)
	{
		if (!empty($login) and !empty($pass)) return md5(md5($login.'uws'.$pass).$pass);
		return false;
	}
}
