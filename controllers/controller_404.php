<?

session_start();


class Controller_404 extends Controller
{
	
	function action_index()
	{
		$this->data['title']='Ошибка';
		$this->data['showlogo']=true;
		$this->view->generate('view_404.php', 'layout_default.php', $this->data);
	}
}
