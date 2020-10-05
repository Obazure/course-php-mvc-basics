<?

session_start();

class Model
{
	protected $db = null;
	protected $data;
	
	function __construct()
	{
		$this->db = SQLCONNECTOR::getInstance();
		
		
	
		
	}
	/*
		Модель обычно включает методы выборки данных, это могут быть:
			> методы нативных библиотек pgsql или mysql;
			> методы библиотек, реализующих абстракицю данных. Например, методы библиотеки PEAR MDB2;
			> методы ORM;
			> методы для работы с NoSQL;
			> и др.
	*/
	// метод выборки данных
	public function get_data()
	{
		// todo
		return $this->data;
	}
	
	protected function makeCharsSecure($text)
	{
		if (!empty($text)) return nl2br(htmlspecialchars(trim($text), ENT_QUOTES), false);
		return false;
	}
	
	
	protected function generateCode($length=6)
	{
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
		$code = "";
		$clen = strlen($chars) - 1;
		while (strlen($code) < $length)
		{
			$code .= $chars[mt_rand(0,$clen)];
		}
		return $code;
	}
	
	
}