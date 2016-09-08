<?php 
	class category extends ACore{
		public function __construct(){
			$this->pdo = new PDO($this->dsn, USER, PASS, $this->option);
		}
		public function get_content(){
			
			//Нужно сверстать куда количество лайков выводить и подписки
			printf('<div class="container content">
					<div class="row addContent">
					');
					
					
					if(isset($_GET['idC']) && $_GET['idC'] <= 31 && $_GET['idC'] >= 0){
						$start = array("всё","мода","обучение","праздники","путешествия","природа","сделай сам","спорт","татуировки","мемы","фотографии","цитаты","юмор","гики","дизайн","женская мода",
										"мода для мужчин","животные","здоровье и фитнес","знаменитости","искусство","история","кино, музыка, книги","гаджеты","подарки","машины и мотоциклы","наука","еда и напитки"
										,"космос","аниме","игры","селфи");
						$catId = $this->clear_StringData((int)$_GET['idC']);
						echo '<div class="start">
									<h1>Вы находитесь в категории '.$start[$catId].'</h1>
									<h5>
										<p>Оценивайте фото других пользователей и выкладывайте свои</p>
										А также, любите фотографии и фотографироваться</h5>
								</div>';
					}else{
						printf('<div class="start">Такой категории нет</div>');
						exit;
					}
					
					if(!$this->setTrueCookies()){
						$title = 'Чтобы оценить или подписаться нужно авторизоваться';
					}else{
						$title = "";
					}
					if(!$catId){
						$stmt = $this->pdo->prepare('SELECT u.id,u.name,u.alias,u.minAVA,
													up.photo,up.likePhoto,up.idPhoto,up.description,up.category
													FROM users u JOIN usersphoto up WHERE u.id = up.keyId
													ORDER BY up.dateTime DESC LIMIT 12');
						$stmt->execute();
					}else{
						$stmt = $this->pdo->prepare('SELECT u.id,u.name,u.alias,u.minAVA,
													up.photo,up.likePhoto,up.idPhoto,up.description,up.category
													FROM users u JOIN usersphoto up WHERE up.category = :catId AND u.id = up.keyId
													ORDER BY up.dateTime DESC LIMIT 12');
						$stmt->execute([
							':catId' => $catId
						]);
					}
					
					$fl = false;
					$count = 0;
					foreach($stmt as $row){
						$fl = true;
						if($count % 3 == 0){
							printf('<div class="row borderThreeImg">');
						}
						/* 
							Сортировка происходит по количеству лайков
							так фото с примерным количеством лайков будут в одном ряду
							
							//Создать в подписках ссылку на емаил по которому выдаст данные пользователя
						*/
						printf('<div class="col-xs-4 col-sm-4">
									<div class="thumbnail">
										<a href="?option=view&id=%s">
											<div class="caption">
												<img src="%s"class="minAva" alt="">
												<i class="textMinAva">
													<b>%s</b>
												</i><br />
												<i class="alias">%s</i>
											</div>
										</a>
										<img src="img/loader.gif" class="loading">
										<div class="hoverC">
											<img src="img/hoverBackground.png" class="hoverComents">
											<div class="svetlyi">
												<span class="hoverComentsText">Просмотр <i class="glyphicon glyphicon-comment"></i></span>
											</div>
										</div>
										<img src="%s" alt="%s" class="im" onLoad="loadImg(this)">
										<div class="caption" title="%s">
											<i id="%s" class="glyphicon glyphicon-heart navbar-brand right heaet">
												<span class="right plusOne">+1</span>
												<div id="%s" class="heaetLike">
													<b class="text-info">%s</b>
												</div>
											</i>
											<div id="%s" class="subscribe clickLog">
												<b>Подписаться</b>
											</div>
											<br />
										</div>
									</div>
								</div>',$row['id'],$row['minAVA'],$row['name'],$row['alias'],$row['photo'],$row['description'],$title,$row['idPhoto'],$row['id'],$row['likePhoto'],$row['id']);
						if($count % 3 == 2){
								printf('</div>');
							}
						$count++;
					}
					/*
					
					*/
			if($fl){
					printf('</div>
							<div class="moreLoading">Загрузка<br /><i class="glyphicon glyphicon-refresh"></i></div>
							<div class="err"></div>
							<div class="moreCategory">ещё</div><br /><br />
						</div>
					</div>');
			}else{
				printf('<div class="start"><br /><i class="glyphicon glyphicon-warning-sign"></i>   В этой котегории нет фото. Добавте их и будет вам счастье</div>
					</div>');
			}
			
		}
		public function numberCategory(){
			
		}
	}
?>