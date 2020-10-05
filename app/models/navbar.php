<?

session_start();

uses('app/models/user');

class NavBar extends Model {
	
	private static $_singleton; 
	
	public static function getInstance() {
		if(!self::$_singleton) {
			self::$_singleton = new NavBar();
		}
		return self::$_singleton;
	}
	
	public static function getNavBar(){
		$rtn=[
			['link'=>'/api/','text'=>'API'],
			
		];

		$user = User::getInstance();
		if ($user->checkLoginStatus()==true){
			array_unshift ($rtn,['link'=>'/user/account','text'=>'Личный кабинет']);
			array_push ($rtn,['link'=>'/user/logout','text'=>'Выйти']);
			
			$currentuser = $user->getUser();
			if ($currentuser['role']==1)
				array_unshift($rtn,['link'=>'/moderator','text'=>'Администрирование']);
		} else {
			array_unshift($rtn,['link'=>'/user/singin','text'=>'Войти']);
		}
		return $rtn;
	}
	
	/*public static function moderatorMenu(){
		$rtn=[
				['link'=>'/moderator/todayfood','text'=>'Меню на сегодня'],
				['link'=>'/moderator/account/print/on','text'=>'Печать'],
				['link'=>'/moderator/allfood','text'=>'Редактировать каталог'],
				['link'=>'/moderator/usermoney','text'=>'Пополнить баланс']
				
		];
		return $rtn;
	}*/
	
}