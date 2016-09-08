<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <link rel="shortcut icon" href="img/ava.ico">
	<title><?php 	$start = array("всё","мода","обучение","праздники","путешествия","природа","сделай сам","спорт","татуировки","мемы","фотографии","цитаты","юмор","гики","дизайн","женская мода",
										"мода для мужчин","животные","здоровье и фитнес","знаменитости","искусство","история","кино, музыка, книги","гаджеты","подарки","машины и мотоциклы","наука","еда и напитки"
										,"космос","аниме","игры","селфи");
					$idCaa = $_GET['idC'];
					if(isset($idCaa) && $idCaa <= 31 && $idCaa >= 0){ 
						echo 'Photoslike - каталог фото и картинок вы находитесь в категории '.$start[$idCaa].' | Photos like';
					}else{
						echo 'Photoslike - каталог фото и картинок главная страница | Photos like';
					}
			?>
	</title>

    <!-- Bootstrap -->
	<link href='css/bootstrap.css' rel='stylesheet'>
	<link href='css/style.css' rel='stylesheet'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	
	<!--
	<script src='https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js'></script>
	<script src='https://oss.maxcdn.com/respond/1.4.2/respond.min.js'></script>
	<script src='js/jsExplorer.js'></script>
	<! [endif]-->
	
	<script src='js/jquery1_12.js'></script>
	
	<script src='js/salvattore.min.js'></script>
	<script src='js/bootstrap.js'></script>
	<script src='js/js.js'></script>
	
</head>
<body>
<div class="container">
    <div class="row">
        <div class="navbar navbar-default navbar-static-top header">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse"  data-target="#responsive-menu">
                        <span class="sr-only">Открыть навигацию</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="?option=main" class="navbar-brand">PL<i class="glyphicon glyphicon-heart logoHeart"></i></a>
                </div>