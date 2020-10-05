<?

session_start();

/*
uses ('app/models/extracost');
uses ('app/models/user');
*/
class Controller_api extends Controller
{
		
	function action_index()
	{	
		$this->data['title']='API';
		$this->putItemsToNavBar();
			
		$this->view->generate('view_api_home.php', 'layout_default.php', $this->data);
	}
	
	function action_request(){
		$this->view->generate('view_api_options.php', 'layout_empty.php', $this->data);
	}
	
	function putItemsToNavBar (){
		array_unshift ($this->data['navbar'],['link'=>'/api/request','text'=>'Запрос']);
	}
	

}