<?php
	header("Content-Type: text/html; charset='utf-8'");
	require_once("../config.php");
class Coments{
	protected $pdo;
	protected $dsn = "mysql:host=localhost;dbname=likephoto;charset=utf8";
	protected $option = array(
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
	);
	public function __construct(){
		$this->pdo = new PDO($this->dsn, USER, PASS, $this->option);
	}
	public function add(){
		$res = "true";
		if(isset($_POST['idPhoto'])){
			//if($this->setTrueCookies()){
				$idPhoto = $this->clear_StringData((int)($_POST['idPhoto']));
				
				$stmt = $this->pdo->prepare('SELECT coments FROM usersphoto WHERE idPhoto = :idPhoto ORDER BY dateTime');
				$stmt->execute(array(
								':idPhoto' => $idPhoto
								));
				while($row = $stmt->fetch(PDO::FETCH_LAZY)){
					$coments =	json_decode($row['coments']);
				}
				if($coments == []){
					return $res;
				}
				$leng = count($coments);
				//if($leng > 50){
				//	$leng = 50;
				//	$come = array();
				//	for($i = 0; $i < $leng; $i+=1){
				//		$come = $coments[$i];
				//	}
				//	array_unshift($come, $leng);
				//	$res = $come;
				//}else{
					array_unshift($coments, $leng);
					$res = $coments;
				//}
				//Нужно передать длинну массива $coments чобы знать сколько коментов уже отображено
				
				
			//}
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
	$addC = new Coments();
	$result = $addC->add();
	echo json_encode($result);
?>