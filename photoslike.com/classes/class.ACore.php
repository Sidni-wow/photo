<?php 
	abstract class ACore{
		
		protected $pdo;
		protected $dsn = "mysql:host=localhost;dbname=likephoto;charset=utf8";
		protected $option = array(
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
		);
		public function __construct(){
			$this->pdo = new PDO($this->dsn, USER, PASS, $this->option);
			if(!$this->setTrueCookies()){
				header("Location:?option=login");
				exit;
			}
		}
		
		protected function get_header(){
			$fl = false;
			include_once("header.php");
			if(isset($_COOKIE['id'])){
				$id = $this->clear_StringData(base64_decode($_COOKIE['id']));
				$stmt = $this->pdo->prepare('SELECT xp,my_like,lvl FROM users WHERE id = :id');
				$stmt->execute(array(':id' => $id));
				foreach($stmt as $item){
					$fl = true;
					$likeCount = $item['lvl'] *100 + $item['xp'];
						printf('<div class="del">Подписка оформлена</div>
						<div class="likeResponse navbar-header">
									<i class="glyphicon glyphicon-heart navbar-brand"></i>
									<span class="navbar-brand myCountLike allLick">'.$likeCount.' |</span>
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
			if(empty($fl)){
				echo '<a href="?option=login"><div class="noUsers"><i class="glyphicon glyphicon-user"></i> Войти</div></a>
					<div class="likeResponse navbar-header">
								<i class="glyphicon glyphicon-heart navbar-brand"></i>
								<span class="navbar-brand myCountLike allLick"> Нет лайков |</span>
								<span class="navbar-brand myCountLike lvl">Нет уровня</span>
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
									<li><a href="?option=login"><i class="glyphicon glyphicon-user"></i> Войти</a></li>
									<li class="dropdown" >
										<a href="#" class="dropdown-toggle"  data-toggle="dropdown"><i class="glyphicon glyphicon-align-justify"><span class="sizeText" style="font-size:15px;"> Категории</span></i></a>
										<ul class="dropdown-menu dropdown-menu-right widthCatUl">';
											include_once ("categoryMenu.php");
										echo '</ul>
									</li>
									
								</ul>
							</div>
						</div>
					</div>
				</div>';
			}			
		}
		public function get_body(){
			
			if(isset($_GET['category'])){
				$this->get_header();
				$this->get_content();
				$this->get_footer();
			}else if(isset($_POST['email']) AND isset($_POST['pass']) AND isset($_POST['name']) AND isset($_POST['alias'])){
				$this->obrReg();
			}else if(isset($_POST['emailLogin']) AND isset($_POST['passLogin'])){
				$this->obrLogin();
			}else if(isset($_POST['nameRefresh']) AND isset($_POST['aliasRefresh']) AND isset($_POST['webSiteRefresh']) AND isset($_POST['statusRefresh'])){
				$this->updata();
			}else if(isset($_FILES['image_file'])){
				$this->uploadImageFile();
			}else if(isset($_FILES['image_fileAva'])){
				$this->uploadImageFileAva();
			}else{
				$this->get_header();
				$this->get_content();
				$this->get_footer();
			}
		}
		
		abstract function get_content();
		public function get_footer(){
			printf("<script>
					  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
					  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
					  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
					  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

					  ga('create', 'UA-81417837-1', 'auto');
					  ga('send', 'pageview');

					</script>
					</body>
				</html>");
		}
		//Функция очистки строковых переменных
		//Дублирование кода
		public function clear_StringData($text){
			$quotes = array("\x27","\x22","\x60","\t","\n","\r","*","%","<",">","?","!");
			//$goodquotes = array("-","+","#");
			//$repquotes = array("\-","\+","\#");
	
			$text = trim($text);
			$text = str_replace($quotes , '', $text);
			//$text = str_replace($goodquotes , $repquotes, $text);
			//$text = preg_replace_callback("+", " ", $text);
			
			$text = htmlspecialchars($text);
			//$text = mysql_escape_string($text);//PDO делает это автоматически
			return $text;
		}
		public function addCookies($id,$email){
			setrawcookie("id", base64_encode($id), time()+(60*60*24*30));
			setrawcookie("idСheck", password_hash($email,PASSWORD_BCRYPT), time()+(60*60*24*30));
		}
		public function setTrueCookies(){
			if(isset($_COOKIE['id']) AND isset($_COOKIE['idСheck'])){
				$id = $this->clear_StringData((int)base64_decode($_COOKIE['id']));
				//quoted_printable_encode(base64_encode
				$email = $this->clear_StringData($_COOKIE['idСheck']);
				$stmt = $this->pdo->prepare('SELECT email FROM users WHERE id = :id');
				$stmt->execute(array(':id' => $id));
				$res = false;
				while($row = $stmt->fetch(PDO::FETCH_LAZY)){
					if(password_verify($row['email'],$email)){
						$res = true;
					}
				}
			}else{
				$res = false;
			}
			return $res;
		}
		public function deltCookies(){
			setrawcookie("id", '', time()-(3600));
			setrawcookie("idСheck", '', time()-(3600));
		
		}
	}
?>