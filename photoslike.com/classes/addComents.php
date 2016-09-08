<?php
	header("Content-Type: text/html; charset='utf-8'");
	require_once("../config.php");
class addComents{
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
		if(isset($_POST['idPhoto']) AND isset($_POST['coment']) AND isset($_POST['count'])){
			if($this->setTrueCookies()){
				$idPhoto = $this->clear_StringData((int)($_POST['idPhoto']));
				$count = $this->clear_StringData((int)($_POST['count']));
				$coment = $this->clear_StringData(($_POST['coment']));
				//array (["id","Min ava","Alias","name","coment"]);
				$id = $this->clear_StringData((int)base64_decode($_COOKIE['id']));
				
				$stmt = $this->pdo->prepare('SELECT name,alias,minAva FROM users WHERE id = :id');
					
				$stmt->execute(array(
								':id' => $id
								));
				while($row = $stmt->fetch(PDO::FETCH_LAZY)){
					$name =	$row['name'];
					$alias = $row['alias'];
					$minAva = $row['minAva'];
				}
				
				$stmt = $this->pdo->prepare('SELECT coments FROM usersphoto WHERE idPhoto = :idPhoto');
					
				$stmt->execute(array(
								':idPhoto' => $idPhoto
								));
				while($row = $stmt->fetch(PDO::FETCH_LAZY)){
					$coments = json_decode($row['coments']);
				}
				$UPcoments = array($id,$minAva,$alias,$name,$coment);
				array_unshift($coments,$UPcoments);
				$coments = json_encode($coments);
				$stmt = $this->pdo->prepare("
				UPDATE usersphoto  SET `coments` = :coments
											WHERE `usersPhoto`.`idPhoto` = :idPhoto");
				$stmt->execute(array(
					':idPhoto' => $idPhoto,
					':coments' => $coments
				));
				//Нужно чтобы выдавало 50 коментов max
				$comen = array();
				$coments = json_decode($coments);
				$counComAQ = count($coments);
				$count = $counComAQ - $count;
				
				for($i = 0;$i < $count;$i+=1){
					array_unshift($comen, $coments[$i]);
				}
				//array_reverse($comen);
				array_unshift($comen, $count);
				//$coments = json_decode($coments);
				//$counCom = count($coments);
				//array_unshift($coments, $counCom);
				$res = $comen;
			}else{
				$res = "reg";
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
	$addC = new addComents();
	$result = $addC->add();
	echo json_encode($result);
?>