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
			$stmt->execute([':id' => $id]);
			$count = 0;
				foreach($stmt as $row){
					if($count == 0){
						printf('<div class="row widthContent">                
									<div class="col-xs-3 col-sm-3">
										<div class="thumbnail">
											<img src="%s" alt="">
										</div>
									</div>
									
									<div class="col-xs-9 col-sm-9">
										<div class="thumbnail lineHigDataUsers">
										<ul class="nav navbar-nav usersMenuT">
												<li class="dropdown">
													<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-align-justify"></i></a>
													<ul class="dropdown-menu dropdown-menu-right">
														<li><a href="#">Сменить пароль</a></li>
														<li><a href="?option=EditInfo">Редактировать информацию</a></li>
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
											<div class="caption">
											<div >
											  <div class="dataLvl"><b>xp:</b> %s%%</div>
											  <div class="dataLvl"><b>lvl:</b> %s</div>
											  <div class="dataLvl"><b>All like:</b> %s</div>
											</div><br />
												<p class="webSity"><b>Web site:</b> <a href="%s">%s</a></p>
												<br />
												<div class="alert alert-info">%s</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row widthContent">
									<div class="col-xs-12 col-sm-12">
										<div class="thumbnail">
											<div class="btn-group btn-group-justified">
											  <div class="btn-group">
												<button type="button" class="btn btn-default">Фотографий: %s</button>
											  </div>
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
						</div>',$row['minAva'],$row['minAva'],$row['name'],$row['alias'],
								$row['xp'],$row['lvl'],$row['my_like'],$row['web_site'],$row['web_site'],
								$row['status'],$row['count_photo'],$row['my_subscribers'],$row['i_subscriber']);
						
						printf('<div class="container content">
								<div class="row">');
					}
					if($count % 3 == 0){
								printf('<div class="row">');
							}
								printf('<div class="col-xs-4 col-sm-4">
											<div class="thumbnail">
												<img src="%s" alt="">
											</div>
										</div>',$row['photo']);
							if($count % 3 == 2){
									printf('</div>');
								}
							$count++;
				}
				printf('</div>
					</div>
				</div>');
		
		}
	}
?>