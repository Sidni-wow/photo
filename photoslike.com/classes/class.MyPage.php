<?php
	class MyPage extends ACore{
		public function get_content(){
			$id = $this->clear_StringData(base64_decode($_COOKIE['id']));
			//Сюда добавляеться ава по умолчанию
			//ПРийдёться делать 2 запроса :( печаль
			/*
			$stmt = $this->pdo->prepare("SELECT u.alias,u.xp,u.my_like,u.lvl,u.name,u.web_site,
											u.count_photo,u.my_subscribers,u.i_subscriber,u.minAva,
											u.status,up.photo FROM users u JOIN usersphoto up 
											WHERE u.id = :id AND up.keyId = :id");
			*/
			
			$stmt = $this->pdo->prepare("SELECT alias,xp,my_like,lvl,name,web_site,
											count_photo,my_subscribers,i_subscriber,minAva,
											status,id FROM users WHERE id = :id");
			$stmt->execute([':id' => $id]);
				foreach($stmt as $row){
					$name = $row['name'];
					$alias = $row['alias'];
					$minAva = $row['minAva'];
					$idUs = $row['id'];
					$i_sub = json_decode($row['i_subscriber']);
					$my_sub_s = json_decode($row['my_subscribers']);
					$my_like = $row['lvl'] * 100 + $row['xp'];
						printf('<div class="row widthContent">
									<div class="col-xs-3 col-sm-3" style="padding:0px;">
										<div class="thumbnail thumbnailAva">
											<div class="uploadAva">
												<div class="uploadAvaglyphicon">
													<i class="glyphicon glyphicon-upload"></i>
													<p>Загрузить новое фото</p>
												</div>
											</div>
											<img src="%s" alt="">
											
										</div>
									</div>
									
									<div class="col-xs-9 col-sm-9">
										<div class="thumbnail lineHigDataUsers">
										<ul class="nav navbar-nav usersMenuT">
												<li class="dropdown">
													<a href="?option=uploadImg" class="iconPage"><i class="glyphicon glyphicon-camera"></i> <br><span class="sizeText">Загрузить</span></a>
												</li>
												<li class="dropdown" >
													<a href="#" class="iconPage dropdown-toggle"  data-toggle="dropdown"><i class="glyphicon glyphicon-align-justify"><br><span class="sizeText">Редактировать</span></i></a>
													<ul class="dropdown-menu dropdown-menu-right">
														<!--<li><a href="#">Сменить пароль</a></li>-->
														<li><a href="?option=EditInfo" >Редактировать информацию</a></li>
													</ul>
												</li>
												<li class="dropdown">
													<a href="#" class="dropdown-toggle iconPage" data-toggle="dropdown"><i class="glyphicon glyphicon-off"><br /><span class="sizeText">Выход</span></i></a>
													<ul class="dropdown-menu dropdown-menu-right">
														<li><a href="" class="exit">Выход</a></li>
													</ul>
												</li>
												
											</ul>
											<div class="caption noBottomBorder">
												<img src="%s"class="minAva" alt="">
												<i class="textMinAva">
													<b>%s</b>
												</i><br />
												<i class="alias">%s</i>
											</div>
											<div class="caption"><br /><br />
											<div class="alert alert-info"><h5>%s</h5></div>
											
											<div >
											  <div class="dataLvl"><b>Опыт:</b> %s%%</div>
											  <div class="dataLvl"><b>Уровень:</b> %s</div>
											  <div class="dataLvl"><b>Оценил:</b> %s фото</div>
											</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row widthContent">
									<div class="col-xs-12 col-sm-12">
										<div class="thumbnail">
											<div class="btn-group btn-group-justified">
											  <!--<div class="btn-group">
												<button type="button" class="btn btn-default">Photos: %s</button>
											  </div>-->
											  <div class="btn-group">
												<button type="button" class="btn btn-default">Подписчиков: %s</button>
											  </div>
											  <div class="btn-group">
												<button type="button" class="btn btn-default">Подписан: %s</button>
											  </div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>',$minAva,$minAva,$name,$alias,
								$row['status'],$row['xp'],$row['lvl'],$my_like,$row['count_photo'],count($my_sub_s)-1,count($i_sub)-1);
				}
				$count = 0;
				printf('<div class="container content">
							<div class="row addImg">');
				$stmt = $this->pdo->prepare('SELECT photo,description,idPhoto FROM usersphoto WHERE keyId = :id ORDER BY dateTime DESC LIMIT 12');
				$stmt->execute(array(':id' => $id));
				while($row = $stmt->fetch(PDO::FETCH_LAZY)){
					if($count % 3 == 0){
								printf('<div class="row">');
							}
								printf('<div class="col-xs-4 col-sm-4">
											<div class="thumbnail">
												<img src="img/loader.gif" class="loading">
												<div class="hoverPageUsers" value="%s">
													<img src="img/hoverBackground.png" value="%s" class="hoverComentsUs">
													<div class="svetlyi" value="%s">
														<span class="hoverComentsText">Просмотр <i class="glyphicon glyphicon-comment"></i></span>
													</div>
												</div>
												<img src="%s" alt="%s" id="%s" class="imU" value="%s" onLoad="loadImg(this)">
											</div>
										</div>',$name,$minAva,$idUs,$row['photo'],$row['description'],$row['idPhoto'],$alias);
					if($count % 3 == 2){
							printf('</div>');
						}
					$count++;
				}
				printf('</div>	
						<br />
						<div class="moreLoading">Загрузка<br /><i class="glyphicon glyphicon-refresh"></i></div>
						<div class="moreView">ещё</div><br /><br />
					</div>
				</div>');
		
		}
	}
?>