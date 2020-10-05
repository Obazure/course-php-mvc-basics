<?

session_start();

class Model_main extends Model
{
	function __construct()
	{
		parent::__construct();
	}
	function putLogo($p1 = 0)
	{
		$this->data['TP']['logo'] = $p1;
	}
	
	function getTeamMember(){
		$this->db->sql('SELECT `name`,`title`,`phone`,`email`,`social`,`sociallink` FROM `members` GROUP BY `id` ORDER BY `name`');
		foreach ($this->db->getResult(1) as $key => $data)
		{
			$this->data['PAGE']['teamMembers'][] = array(
					'name'=>$data['name'],
					'title'=>$data['title'],
					'phone'=>$data['phone'],
					'email'=>$data['email'],
			);
		}
		if (empty($this->data['PAGE']['teamMembers']))
		{
			$this->data['PAGE']['teamMembers'][] = array(
					'name'=>'*',
					'title'=>'*',
					'phone'=>'*',
					'email'=>'*');
				
		}
	}
	
	function getLastNews($p1 = 3){
		
		$sql = 'SELECT  `a`.`id`, `a`.`timestamp`, `a`.`type`, `a`.`content`, `m`.`name` as `author`
				FROM `articles` `a` INNER JOIN  `members` `m` ON  `a`.`author_id` =  `m`.`id`
				ORDER BY `a`.`timestamp` DESC LIMIT '.$p1;
		$this->db->sql($sql);
		
		if (!empty($this->db->getResult()))
		{
			$sqlresponse = $this->db->getResult(1);
			$zeroiteration = array_shift($sqlresponse);
			$this->data['PAGE']['articles'][] = $this->formResponse($zeroiteration,2);
			
			foreach ($sqlresponse as $key => $data)
			{
				$this->data['PAGE']['articles'][] = $this->formResponse($data,2);
			}
		}
	}
	function getLastReview($p1 = 3){
	
		$sql = 'SELECT `a`.`id`, `a`.`timestamp`, `a`.`type`, `a`.`content`, `m`.`name` as `author` 
				FROM `articles` `a` INNER JOIN  `members` `m` ON  `a`.`author_id` =  `m`.`id`
				WHERE `a`.`type` = 2 ORDER BY `a`.`timestamp` DESC LIMIT '.$p1;
		$this->db->sql($sql);
		if (!empty($this->db->getResult()))
		{
			$sqlresponse = $this->db->getResult(1);
			$zeroiteration = array_shift($sqlresponse);
			$this->data['PAGE']['review'][] = $this->formResponse($zeroiteration,2);
			foreach ($sqlresponse as $key => $data)
			{
				$this->data['PAGE']['review'][] = $this->formResponse($data,1);
			}
		}
	}
	
	
	private function formResponse($data = '',$plimit=2)
	{
		$file = 'images/article/'.$data['content'].'.html';
		if(file_exists ($file))
		{
			$html = file_get_html('http://'.$_SERVER['HTTP_HOST'].'/'.$file);
			$h1 = $html->find("h1");
			$p = $html->find("p");
		}
		$title =(!empty($h1))? $h1[0]->innertext : 'No article found by id '.$data['id'];
		for ($i=0, $pforcontent = '';$i<$plimit;$i++)
		{
			$pforcontent.= $p[$i];
		}
		$content =(!empty($pforcontent))? $pforcontent:'';
		
		$type = ($data['type']==2) ? 'review':'news';
		$data['id'] +=0;
		$link = ($data['id']!=0) ? '/article/view/page/'.$data['id']: '#';
		
		unset($html);
		
		return array(
				'title'=>$title,
				'content'=>$content,
				//'type'=>$type, 
				'link'=>$link,
				'author'=>$data['author'],
				'timestamp'=>$data['timestamp']
		);
	}
	
	
	
	
	function action_request(){
		$_POST['name'] = $this->formChars($_POST['name']);
		$_POST['email'] = $this->formChars(mb_strtolower($_POST['email']));
		$_POST['message'] = $this->formChars($_POST['message']);
		$_POST['captcha'] = $this->formChars($_POST['captcha']);
	
		if (!$_POST['name'] or !$_POST['email'] or !$_POST['message'] or !$_POST['captcha']) MessageSend(1,'All field are required!');
		if($_SESSION['captcha']!=md5($_POST['captcha'])) MessageSend(1,'Wrong Captcha!');
	
		$this->db->select('members', 'email'); 
		$admindata = $this->db->getResult(1);
	
		$allrecipients = '';
		foreach($admindata as $key => $data)
		{
			$allrecipients .= $data['email'];
			if (count ($admindata)>$key+1) $allrecipients .= ', ';
		}
		$subject = "Message from ".$_POST['name']." on ".$_SERVER['HTTP_HOST'];
		$body = "Hi guys! \n\nYou have received message from ".$_POST['name']." - ".$_POST['email'].". \n\n".$_POST['message']." \n\n--\nMessage sent by mailbot. \nAll recipients: ".$allrecipients;
		$headers = "From: notification@code-executors.bot";
	
		foreach($admindata as $key => $data)
		{
			$to = $data['email'];
			mail( $to, $subject, $body, $headers);
		}
	
		$insertdata = $_POST['name'].",".$_POST['email'].",".$_POST['message'];
		$colums = 'name,email,message';
	
		if ($this->db->insert('messages', $insertdata, $colums))
			MessageSend(3,'Done!');
			else MessageSend(1,'Try again later!');
	
	}
	function action_signin()
	{
		if ($_POST['enter'])
		{
			$_POST['email'] = $this->formChars(mb_strtolower($_POST['email']));
			$_POST['password'] = $this->formChars($_POST['password']);
			if (!$_POST['email'] or !$_POST['password']) MessageSend(1,'Data is incorrect!');
			$_POST['password'] = $this->encPass($_POST['password'],$_POST['email']);
			
			$sql = 'SELECT * FROM `members` WHERE `email`=\''.$_POST['email'].'\' ORDER BY timestamp DESC LIMIT 1';
			$this->db->sql($sql);
			$userdata = $this->db->getResult();
			//print_r ($userdata);
			if (!$userdata['passhash']) MessageSend(1,'User not found!');
			echo $_POST['password'].'<hr/>';
			echo $userdata['passhash'];
			if (0!=strcmp($userdata['passhash'],$_POST['password']))
			{
				$_SESSION['wrongcounter'] +=0;
				$_SESSION['wrongcounter'] ++;
				if ($_SESSION['wrongcounter'] >3)
				{
					MessageSend(1,'Wrong password 3 times, go try again.','/');
				}
				MessageSend(1,'Incorrect password!');
			}
			
			//if ($userdata['active']!=1) MessageSend(1, '<b>'.$_POST['email'].'</b> is not active!');
				
			$this->addUserDataToSession($userdata);
				
			//if ($_REQUEST['rememberme'])
				//setcookie("user", $_POST['password'], time()+3600*24*7, "/");
					
			MessageSend(2, 'Hi <b>'.$_SESSION['USER_NAME'].'</b>!', '/');
		} else MessageSend(1, 'Opsss..', '/404');
	}
	private function addUserDataToSession($p1)
	{
		$_SESSION['USER_ID'] = $p1['id'];
		$_SESSION['USER_EMAIL'] = $p1['email'];
		$_SESSION['USER_NAME'] = $p1['name'];
		$_SESSION['USER_HASH'] = $this->getUserHash($p1['email'], $p1['id']); //mail+id+?pass+salt
		$_SESSION['USER_LOG_IN'] = 1;
	}
	
	function action_logout()
	{ 
		//setcookie("user", "", time() - 1, "/");
		$_SESSION = array();
		session_destroy();
		header("Location: http://".$_SERVER['HTTP_HOST']);
	}
}
?>