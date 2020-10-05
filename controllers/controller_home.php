<?

session_start();

/*
uses ('app/models/extracost');
uses ('app/models/user');
*/
class Controller_Home extends Controller
{	
	function action_index()
	{	
		$this->data['title']='Добро пожаловать!';
		$this->view->generate('view_home.php', 'layout_default.php', $this->data);
	}
}