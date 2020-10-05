<?

session_start();

// подключаем файлы ядра
require_once 'core/model.php';
require_once 'core/view.php';
require_once 'core/controller.php';

require_once 'core/sqlconnector.php';

function uses ($file=''){
	if(file_exists($file.'.php')){
		include_once $file.'.php';
	}
}
/*
Здесь обычно подключаются дополнительные модули, реализующие различный функционал:
	> аутентификацию
	> кеширование
	> работу с формами
	> абстракции для доступа к данным
	> ORM
	> Unit тестирование
	> Benchmarking
	> Работу с изображениями
	> Backup
	> и др.
*/
require_once 'core/route.php';
Route::start(); // запускаем маршрутизатор