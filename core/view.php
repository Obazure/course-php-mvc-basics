<?

session_start();

class View
{
	
	//public $template_view; // здесь можно указать общий вид по умолчанию.
	
	/*
	$content_file - виды отображающие контент страниц;
	$template_file - общий для всех страниц шаблон;
	$data - массив, содержащий элементы контента страницы. Обычно заполняется в модели.
	*/
	function generate($content_view, $template_view, $data = null)
	{
		
		/*
		if(is_array($data)) {
			
			// преобразуем элементы массива в переменные
			extract($data);
		}
		*/
		
		/*
		динамически подключаем общий шаблон (вид),
		внутри которого будет встраиваться вид
		для отображения контента конкретной страницы.
		*/
		$PATH = 'http://'.$_SERVER['HTTP_HOST'];
		
		include 'app/views/'.$template_view;
	}
	
	public static function messageFrame($msg='',$type=''){
		
		switch ($type){
			case 1: $type = 'Error'; break;
			case 2: $type = 'Information'; break;
			default: $type = ''; break;
		}
		
		return '<section><pre>'.'<b>'.$type.'</b>: '.$msg.'</pre></section>';
		
		//if ($type == 0) $type = 'success';if ($type == 1) $type = 'danger';if ($type == 2) $type = 'info';
		//return '<div class="alert alert-dismissible alert-'.$type.'"><button type="button" class="close" data-dismiss="alert">&times;</button>'.$msg.'</div>';
	}
}
