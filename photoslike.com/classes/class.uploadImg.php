<?php
	class uploadImg extends ACore{
		protected function get_header(){
			$id = $this->clear_StringData(base64_decode($_COOKIE['id']));
			$stmt = $this->pdo->prepare('SELECT xp,my_like,lvl FROM users WHERE id = :id');
			$stmt->execute(array(':id' => $id));
			include_once("content/headUploadImg.php");
			foreach($stmt as $item){
				$likeCount = $item['lvl'] *100 + $item['xp'];
					printf('<div class="del">Подписка оформлена</div>
						<div class="likeResponse navbar-header">
									<i class="glyphicon glyphicon-heart navbar-brand"></i>
									<span class="navbar-brand myCountLike allLick">'.$likeCount.'|</span>
									<span class="navbar-brand myCountLike lvl">%s Уровень</span>
								</div>
								<!--<div class="navbar-form search navbar-header">
									<div class="form-group">
										<i class="glyphicon glyphicon-search"></i>
										<input type="text" class="form-control searchInput" placeholder="Поиск" value="">
									</div>
								</div>-->

								<div class="collapse navbar-collapse menu" id="responsive-menu">
									<ul class="nav navbar-nav">
									<li><a href="?option=main"><i class="glyphicon glyphicon-picture"></i> Лента</a></li>
										<li><a href="?option=MyPage"><i class="glyphicon glyphicon-user"></i> Моя страница</a></li>
										<li class="dropdown" >
											<a href="#" class="dropdown-toggle"  data-toggle="dropdown"><i class="glyphicon glyphicon-align-justify"><span class="sizeText" style="font-size:15px;"> Категории</span></i></a>
											<ul class="dropdown-menu dropdown-menu-right widthCatUl">',$item['lvl']);
													include_once ("categoryMenu.php");
									printf('</ul>
										</li>
									</ul>
								</div>
							</div>
							
							<div class="container">
								<div class="progress navbar-header progressBar">
									<div class="progress-bar progress-bar-info progress-bar-striped active progressBarOneDiv" style="width:%s%%;">

									</div>
								</div>
							</div>
							
						</div>
					</div>',$item['xp']);
			}						
		}
		function uploadImageFile() { // Note: GD library is required for this function
			//$iWidth = 400; // desired image result dimensions
			//$iHeight = 240; // desired image result dimensions
			$iJpgQuality = 90;
			if(!(isset($_POST['x1']) AND isset($_POST['y1']) AND isset($_POST['w']) AND isset($_POST['h']))){
				header('Location:?option=MyPage');
				exit;
			}
			if(strlen($_POST['description']) >= 400){
				header('Location:?option=MyPage');
				exit;
			}
			$x1 = $this->clear_StringData((int)$_POST['x1']);
			$y1 = $this->clear_StringData((int)$_POST['y1']);
			$w = $this->clear_StringData((int)$_POST['w']);
			$h = $this->clear_StringData((int)$_POST['h']);
			if(isset($_POST['category'])){		
				$category = $this->clear_StringData((int)$_POST['category']);
			}else{
				$category = 0;
			}
			
			$description = $this->clear_StringData($_POST['description']);
			
			
			
			
			if(!(($w >= 399) && ($h >= 239) && ((($w / $h) >= 1.66) && (($w / $h) <= 1.68)))){
				header('Location:?option=uploadImg');
				exit;
			}else{
				if(($w < 600) && ($h < 360) && ((($w / $h) >= 1.66) && (($w / $h) <= 1.68))){
					$iWidth = $w-1;
					$iHeight = $h-1;
				}else if(((($w / $h) >= 1.66) && (($w / $h) <= 1.68))){
					$iWidth = 600;
					$iHeight = 360;
				}else{
					exit;
				}
			}
			if ($_FILES) {
				// if no errors and size less than 250kb
				if (! $_FILES['image_file']['error'] && $_FILES['image_file']['size'] < 2000 * 1024) {
					if (is_uploaded_file($_FILES['image_file']['tmp_name'])) {
	 
						$id = $this->clear_StringData(base64_decode($_COOKIE['id']));
						// new unique filename
						$sTempFileName = 'cacheImg/'. $id .'/'. md5(time());
	 
						// move uploaded file into cache folder
						move_uploaded_file($_FILES['image_file']['tmp_name'], $sTempFileName);
	 
						// change file permission to 644
						@chmod($sTempFileName, 0644);
	 
						if (file_exists($sTempFileName) && filesize($sTempFileName) > 0) {
							$aSize = getimagesize($sTempFileName); // try to obtain image info
							if (!$aSize) {
								@unlink($sTempFileName);
								return;
							}
	 
							// check for image type
							switch($aSize[2]) {
								case IMAGETYPE_JPEG:
									$sExt = '.jpg';
	 
									// create a new image from file
									$vImg = @imagecreatefromjpeg($sTempFileName);
									break;
								/*case IMAGETYPE_GIF:
									$sExt = '.gif';
	 
									// create a new image from file
									$vImg = @imagecreatefromgif($sTempFileName);
									break;*/
								case IMAGETYPE_PNG:
									$sExt = '.png';
	 
									// create a new image from file
									$vImg = @imagecreatefrompng($sTempFileName);
									break;
								default:
									@unlink($sTempFileName);
									return;
							}
	 
							// create a new true color image
							$vDstImg = @imagecreatetruecolor( $iWidth, $iHeight );
	 
							// copy and resize part of an image with resampling
							imagecopyresampled($vDstImg, $vImg, 0, 0, $x1, $y1 , $iWidth, $iHeight, $w, $h);
	 
							// define a result image filename
							$sResultFileName = $sTempFileName . $sExt;
	 
							// output image to file
							imagejpeg($vDstImg, $sResultFileName, $iJpgQuality);
							@unlink($sTempFileName);
							$stmt = $this->pdo->prepare('SELECT max(idPhoto) FROM usersphoto');
							$stmt->execute();
							while($row = $stmt->fetch(PDO::FETCH_LAZY)){
								$maxID = $row['max(idPhoto)'];
							}
							date_default_timezone_set('Europe/Moscow');
							$dat = time();
							$likeAllUsers = array("0");
							$likeAllUsers = json_encode($likeAllUsers);
							$defComents = "[]";
							$stmt = $this->pdo->prepare("INSERT INTO `usersphoto` (`idPhoto`,`dateTime` ,`photo`, `coments`, `likePhoto`,`likePhotoAllUsers`,`description`,`keyId`,`category`)
																	VALUES (NULL, :dat, :sResultFileName,:defComents,0,:likeAllUsers,:description,:id,:category)");
							$stmt->execute(array(
								':dat' => $dat,
								':sResultFileName' => $sResultFileName,
								':likeAllUsers' => $likeAllUsers,
								':description' => $description,
								':id' => $id,
								':category' => $category,
								':defComents' => $defComents
							));
							header('Location:?option=MyPage');
							exit;
						}
					}
				}
			}
		}
		function get_content(){
			include_once('content/conUploadImg.php');
		}
	}
?>