<?php
	class EditInfo extends ACore{
		public function get_content(){
			$id = $this->clear_StringData(base64_decode($_COOKIE['id']));
			$email = $this->clear_StringData($_COOKIE['idСheck']);
			$stmt = $this->pdo->prepare("SELECT name,alias,web_site,status FROM users WHERE id = :id");
			$stmt->execute([':id' => $id]);
			foreach($stmt as $row){
				printf('<div class="container logo">
							<div class="row">
									<div class="col-xs-3 col-sm-3">
									
									</div>
									<div class="col-xs-6 col-sm-6">
										<div class="thumbnail">
											<div class="caption">
												<span class="text-info">	</span>
											</div>
											<form  method="post" name="avtForm" onsubmit="return formdataUpdata(avtForm)" action="?option=EditInfo">
												<div class="caption logoWidths">
												<div class="input-group">
													<span class="input-group-addon">Имя</span>
														<input type="text" class="form-control" name="nameRefresh" value="%s" id="nameRefresh" placeholder="Имя">
													</div>
												</div>
												<div class="caption logoWidths">
													<div class="input-group">
													<span class="input-group-addon">Псевдоним</span>
													  <input type="text" class="form-control" name="aliasRefresh" value="%s" id="aliasRefresh" placeholder="Псевдоним">
													  
													</div>
												</div>
												<div class="caption logoWidths">
													<div class="input-group">
													<span class="input-group-addon">Web Сайт</span>
													  <input type="text" class="form-control" name="webSiteRefresh" value="%s" id="webSiteRefresh" placeholder="Web Сайт">
													  
													</div>
												</div>
												<div class="caption logoWidths">
													<div class="input-group">
													<span class="input-group-addon">Статус</span>
													  <input type="text" class="form-control" name="statusRefresh" value="%s" id="statusRefresh" placeholder="Статус">
													  
													</div>
												</div>
												
												<div align="center">
													<input class="btn btn-default btn-sm" type="submit" value="Сохранить" />
												</div>
											</form>
											<div class="caption logoWidths">
												
											</div>
										</div>
									</div>
									<div class="col-xs-3 col-sm-3">
										
									</div>
									
							</div>
						</div>',$row['name'],$row['alias'],$row['web_site'],$row['status']);
			}
		}
		public function updata(){
			$name = $this->clear_StringData($_POST['nameRefresh']);
			$alias = $this->clear_StringData($_POST['aliasRefresh']);
			$webSite = $this->clear_StringData($_POST['webSiteRefresh']);
			$status = $this->clear_StringData($_POST['statusRefresh']);
			
			if(!empty($name) AND !empty($alias)){
				if((strlen($name) <= 40) AND (strlen($alias) <= 40)){
					if($this->setTrueCookies()){
						$id = $this->clear_StringData(base64_decode($_COOKIE['id']));
						$stmt = $this->pdo->prepare("UPDATE `users` SET `name` = :name,`alias` = :alias,
													`web_site` = :webSite,`status` = :status WHERE `users`.`id` = :id");
						$stmt->execute(array(
							':name' => $name,
							':alias' => $alias,
							':webSite' => $webSite,
							':status' => $status,
							':id' => $id
						));
						header("Location:?option=MyPage");
						exit;
					}
				}
			}
			header("Location:?option=EditInfo");
			exit;
		}
	}
?>