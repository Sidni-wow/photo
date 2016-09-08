<?php
	header("Content-Type: text/html; charset='utf-8'");
	
	require_once("config.php");
	require_once("classes/class.Acore.php");
	//Нужно создать механ фильрации $_GET['option']
	if(isset($_GET['option'])){
		$class = trim(strip_tags($_GET['option']));
	}else{
		$class = "main";
	}
	if(file_exists("classes/class.".$class.".php")){
		include_once("classes/class.".$class.".php");
		if(class_exists($class)){
			$obj = new $class;
			$obj->get_body();
		}else{
			exit('Класса нет');
		}
	}else{
		exit("<p>Не правильный адрес</p>");
	}
?>