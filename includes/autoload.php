<?PHP
spl_autoload_register(function($className) {
	//поддиректории классов
    $dirs=[];
    $name= !strrchr($className, '\\') ? strtolower($className) : strtolower(substr(strrchr($className, '\\'), 1 ));
    $class_dir = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR .'App'; //путь к каталогу классов приложения для автозагрузки
	$dirs[]=$class_dir . DIRECTORY_SEPARATOR;
    if ($open_dir = opendir($class_dir)) {
        while (false !== ($file = readdir($open_dir))) {
            if ( is_dir($class_dir. DIRECTORY_SEPARATOR .$file) && $file != '.' && $file != '..') {
                $dirs[]=$class_dir . DIRECTORY_SEPARATOR . $file . DIRECTORY_SEPARATOR;
            }
        }
        closedir($open_dir);
    }
	//ищем в каждой директории
    foreach($dirs as $dir)
    {
        //файл существует
        if(file_exists($dir . $name . '.php'))
        {
            require_once($dir . $name . '.php');
			$dirs=null;
			break;
        }           
    }
});