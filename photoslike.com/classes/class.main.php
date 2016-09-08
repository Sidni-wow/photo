<?php 
	class main extends ACore{
		public function __construct(){
			$this->pdo = new PDO($this->dsn, USER, PASS, $this->option);
		}
		public function get_content(){
			//Нужно сверстать куда количество лайков выводить и подписки
			printf('<div class="container content">
					<div class="row addContent">
					');
					include_once('start.php');
					$minID = 1;
					$stmt = $this->pdo->prepare('SELECT max(idPhoto) FROM usersphoto');
					$stmt->execute();
					while($row = $stmt->fetch(PDO::FETCH_LAZY)){
						$maxID = $row['max(idPhoto)'];
					}
					$number = array();
					$number = $this->noRepeat($maxID,$minID);
					/*
						работает норм но все данные перемешиваються наверное нужно через for() выводить но гемора много
						
						
						///////////////
						SELECT keyId,photo,likePhoto,name,alias,minAVA FROM usersphoto WHERE 
								id = :one OR id = :two OR id = :three 
								OR id = :four OR id = :five OR id = :six ORDER BY likePhoto
						
					*/
					$stmt = $this->pdo->prepare('SELECT u.id,u.name,u.alias,u.minAVA,
												up.photo,up.likePhoto,up.idPhoto,up.description
												FROM users u JOIN usersphoto up WHERE up.keyId = u.id AND  
												(up.idPhoto = :one OR up.idPhoto = :two OR up.idPhoto = :three 
												OR up.idPhoto = :four OR up.idPhoto = :five OR up.idPhoto = :six OR
												up.idPhoto = :one1 OR up.idPhoto = :two1 OR up.idPhoto = :three1 
												OR up.idPhoto = :four1 OR up.idPhoto = :five1 OR up.idPhoto = :six1) ORDER BY likePhoto');
					$stmt->execute([
						':one' => $number[0],
						':two' => $number[1],
						':three' => $number[2],
						':four' => $number[3],
						':five' => $number[4],
						':six' => $number[5],
						':one1' => $number[6],
						':two1' => $number[7],
						':three1' => $number[8],
						':four1' => $number[9],
						':five1' => $number[10],
						':six1' => $number[11]
					]);
					$count = 0;
					if(!$this->setTrueCookies()){
						$title = 'Чтобы оценить или подписаться нужно авторизоваться';
					}else{
						$title = "";
					}
					foreach($stmt as $row){
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
			printf('</div>
					<div class="moreLoading">Загрузка<br /><i class="glyphicon glyphicon-refresh"></i></div>
					<div class="more">ещё</div><br /><br />
				</div>
			</div>
			');
		}
		//Создание массива с неповторяющимися рандомными числами
		public function noRepeat($maxIDFunc,$minIDFunc){			
			$limit = 12;
			$used_nums = array();
			while(1) { 
			  $random = rand($minIDFunc, $maxIDFunc); 
			  if(!in_array($random, $used_nums)) { 
				 $used_nums[] = $random; 
			  } 
			  if(count($used_nums) == $limit) { break; } 
			}
			return $used_nums;
		}
	}
?>