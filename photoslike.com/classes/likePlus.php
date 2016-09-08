<?php
	header("Content-Type: text/html; charset='utf-8'");
	require_once("../config.php");
class like{
	protected $pdo;
	protected $dsn = "mysql:host=localhost;dbname=likephoto;charset=utf8";
	protected $option = array(
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
	);
	public function __construct(){
		$this->pdo = new PDO($this->dsn, USER, PASS, $this->option);
	}
	public function likeP(){
		$res = "true";
	if(isset($_POST['idU']) AND isset($_POST['idC'])){
		if($this->setTrueCookies()){
			$idUser = $this->clear_StringData((int)base64_decode($_POST['idU']));
			$idClick = $this->clear_StringData((int)($_POST['idC']));
			
			$stmt = $this->pdo->prepare('SELECT up.likePhotoAllUsers,up.likePhoto,u.xp,u.lvl
										FROM users u JOIN usersphoto up 
										WHERE up.idPhoto = :idClick AND u.id = :idUser');
			$stmt->execute(array(
							':idClick' => $idClick,
							':idUser' => $idUser
							));
			while($row = $stmt->fetch(PDO::FETCH_LAZY)){
				$likeAllUsers =	json_decode($row['likePhotoAllUsers']);
				$likeCount = $row['likePhoto'];
				$xp = $row['xp'];
				$lvl = $row['lvl'];
			}
			/*
			$stmtR = $this->pdo->prepare('SELECT my_like FROM users WHERE id = :idClick');
			$stmtR->execute(array(
							':idClick' => $idClick
							));				
			while($row = $stmtR->fetch(PDO::FETCH_LAZY)){
				$my_like =	$row['my_like'];
			}
			*/
			$xp += 1;
			if($xp == 100){
				$lvl += 1;
				$xp = 0;
			}
			if(!in_array($idUser,$likeAllUsers)){
				array_push($likeAllUsers,$idUser);
				$likeCount+=1; //ТАк как само быстро работает //http://develstudio.org/php-orion/articles/testiruem-php-na-skorost-vipolneniya
				$likeAllUsers = json_encode($likeAllUsers);
				$stmt = $this->pdo->prepare("UPDATE usersphoto  SET `likePhotoAllUsers` = :likeAllUsers, `likePhoto` = :likeCount
											WHERE `usersPhoto`.`idPhoto` = :idClick");
				$stmt->execute(array(
					':likeAllUsers' => $likeAllUsers,
					':likeCount' => $likeCount,
					':idClick' => $idClick
				));
				$stmts = $this->pdo->prepare("UPDATE `users` SET `xp` = :xp,`lvl` = :lvl WHERE `users`.`id` = :idUser");
				$stmts->execute(array(
					':xp' => $xp,
					':lvl' => $lvl,
					':idUser' => $idUser
				));
				/*$stmtMy = $this->pdo->prepare("UPDATE `users` SET `my_like` = :my_like WHERE `users`.`id` = :idClick");
				$stmtMy->execute(array(
					':my_like' => $my_like,
					':idClick' => $idClick
				));*/
				$res = array($xp,$lvl,$likeCount);
			}else{
				$res = "false2";
			}
			
			
			}else{
				$res = "false1";
			}
		}
			return $res;	
	}
	public function clear_StringData($text){
		$quotes = array("\x27","\x22","\x60","\t","\n","\r","*","%","<",">","?","!");
		$goodquotes = array("-","+","#");
		$repquotes = array("\-","\+","\#");

		$text = trim($text);
		$text = str_replace($quotes , '', $text);
		$text = str_replace($goodquotes , $repquotes, $text);
		//$text = preg_replace_callback("+", " ", $text);
		
		$text = htmlspecialchars($text);
		//$text = mysql_escape_string($text);//PDO делает это автоматически
		return $text;
	}
	public function setTrueCookies(){
		$res = false;
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
}
	$lik = new like();
	$result = $lik->likeP();
	echo json_encode($result);
?>