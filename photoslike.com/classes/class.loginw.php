<?php
	class loginw extends ACore{
		public function __construct(){
			$this->pdo = new PDO($this->dsn, USER, PASS, $this->option);
			if($this->setTrueCookies()){
				header("Location:?option=main");
				exit;
			}
		}
		public function get_header(){
			
			include_once("content/headLogin.php");
			
		}
		protected function obrReg(){
			$email = $this->clear_StringData($_POST['email']);
			$pass = $this->clear_StringData($_POST['pass']);
			$name = $this->clear_StringData($_POST['name']);
			$alias = $this->clear_StringData($_POST['alias']);
			
			if(!empty($email) AND !empty($pass) AND !empty($name) AND !empty($alias)){
				if((strlen($email) <= 40) AND (strlen($pass) <= 40) AND (strlen($name) <= 40) AND (strlen($alias) <= 40)){
					$soletionPass = "pSKDdkdinf04";
					$pass .= $soletionPass;
					$pasHash = password_hash($pass, PASSWORD_DEFAULT);
					
					$stmt = $this->pdo->prepare('SELECT count(*) FROM users WHERE email = :email');
					$stmt->execute(array(':email' => $email));
					$verifyEmail = $stmt->fetchColumn();
					if($verifyEmail == 1){
						$text = "E-mail занят";
					}else{
						$defaultAVA = "img/defaultAva.jpg";
						$defoult = array("0");
						$defoult = json_encode($defoult);
						//По умолчанию сделать какую небуть аватарку а переадресовывать на страницу Установки аватарки
						$stmt = $this->pdo->prepare("INSERT INTO `users` (`id`, `email`, `pass`, `xp`, `my_like`, `lvl`, `name`, `alias`, `my_subscribers`, `i_subscriber`, `web_site`, `count_photo`, `status`, `minAva`,`active`)
													VALUES (NULL, :email, :pass, '0', '0', '0', :name, :alias, :defoult, :defoult, '', '0', '', :defaultAva,'0')");
						$stmt->execute(array(
							':email' => $email,
							':pass' => $pasHash,
							':name' => $name,
							':alias' => $alias,
							':defoult' => $defoult,
							':defaultAva' => $defaultAVA
						));
						
						$stmt = $this->pdo->prepare('SELECT id FROM users WHERE email = :email');
						$stmt->execute(array(':email' => $email));
						while($row = $stmt->fetch(PDO::FETCH_LAZY)){
							$cookieID = $row['id'];
						}
						/*
							$stmt = $this->pdo->prepare("INSERT INTO `usersphoto` (`id`, `photo`, `coments`, `likePhoto`, `keyId`)
														VALUES (NULL, :default, '', '0', :id)");
							$stmt->execute(array(
								':default' => $defaultAVA,
								':id' => $cookieID
							));
						*/
						$structure = 'cacheImg/'. $cookieID;
						mkdir($structure, 0777, true);
						$this->deltCookies();
						$this->addCookies($cookieID,$email);
						
						$to      = 'civilian@mail.ua';
						$subject = 'the subject';
						$message = 'hello';
						$headers = 'From: support@photoslike.com' . "\r\n" .
							'Reply-To: support@photoslike.com' . "\r\n" .
							'X-Mailer: PHP/' . phpversion();

						mail($to, $subject, $message, $headers);
						header("Location:?option=main");
						exit;
					}
				}else{
					$text = "Неправильная длинна";
				}
			}else{
				$text = "Заполните все поля";
			}
			echo '<br />'.$text;
			//header("Location:?option=login");
			//exit;
		}
		protected function obrLogin(){
			$email = $this->clear_StringData($_POST['emailLogin']);
			$pass = $this->clear_StringData($_POST['passLogin']);
			if(!empty($email) AND !empty($pass)){
				if((strlen($email) <= 40) AND (strlen($pass) <= 40)){
						$stmt = $this->pdo->prepare('SELECT pass,id FROM users WHERE email = :email');
						$stmt->execute(array(':email' => $email));
						while($row = $stmt->fetch(PDO::FETCH_LAZY)){
							$soletionPass = "pSKDdkdinf04";
							$pass .= $soletionPass;
							if(password_verify($pass,$row['pass'])){
								$this->deltCookies();
								$this->addCookies($row['id'],$email);
								header("Location:?option=main");
								exit;
							}else{
								//$text = "Неправельные данные";
							}
						}
						//$text = "Неправельные данные";
						
				}else{
					//$text = "Неправильная длинна";
				}
			}else{
				//$text = "Заполните все поля";
			}
			//echo '<br />'.$text;
			header("Location:?option=login");
			exit;
		}
		function get_content(){
			include_once('content/conLogin.php');
		}
	}
?>