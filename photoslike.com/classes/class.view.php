<?php
	class view extends ACore{
		public function __construct(){
			$this->pdo = new PDO($this->dsn, USER, PASS, $this->option);
		}
		public function get_content(){
			printf('<div class="container content">
					<div class="row">');
			$id = $this->clear_StringData((int)($_GET['id']));
			if(empty($id)){
				echo 'Неправильные данные';/* Еще какую небуть картинку нужно вывести */
			}else{
				$stmt = $this->pdo->prepare("SELECT u.alias,u.id,u.xp,u.my_like,u.lvl,u.name,u.web_site,
											u.count_photo,u.my_subscribers,u.i_subscriber,u.minAva,
											u.status,up.photo,up.description,up.idPhoto FROM users u JOIN usersphoto up 
											WHERE (u.id = :id AND up.keyId = :id) ORDER BY up.dateTime DESC LIMIT 12");
				$stmt->execute([':id' => $id]);
				$count = 0;
				foreach($stmt as $row){
					if($count == 0){
						$i_sub = json_decode($row['i_subscriber']);
						$my_sub_s = json_decode($row['my_subscribers']);
						$my_like = $row['lvl'] * 100 + $row['xp'];
						printf('<div class="row widthContent">                
									<div class="col-xs-3 col-sm-3" style="padding:0;">
										<div class="thumbnail thumbnailAva">
											<img src="%s" alt="">
										</div>
									</div>
									
									<div class="col-xs-9 col-sm-9">
										<div class="thumbnail lineHigDataUsers">
											<div class="caption noBottomBorder">
												<img src="%s"class="minAva" alt="">
												<i class="textMinAva">
													<b>%s</b>
												</i><br />
												<i class="alias">%s</i>
											</div>
											<div class="caption">
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
						</div>',$row['minAva'],$row['minAva'],$row['name'],$row['alias'],$row['status'],
								$row['xp'],$row['lvl'],$my_like,
								count($my_sub_s)-1,count($i_sub)-1);
						
						printf('<div class="container content">
								<div class="row addImg">');
					}
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
										</div>',$row['name'],$row['minAva'],$row['id'],$row['photo'],$row['description'],$row['idPhoto'],$row['alias']);
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
	}
?>