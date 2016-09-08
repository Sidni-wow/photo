<?php
	header("Content-Type: text/html; charset='utf-8'");
	require_once("../config.php");
class subscribe{
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
		$res = "";
		if(isset($_POST['idU']) AND isset($_POST['idS'])){
			if($this->setTrueCookies()){
				$idU = $this->clear_StringData((int)base64_decode($_POST['idU']));
				$idS = $this->clear_StringData((int)($_POST['idS']));
				
				$stmt = $this->pdo->prepare('SELECT i_subscriber FROM users WHERE id = :idU');
				$stmt->execute(array(
								':idU' => $idU
								));
								
				while($row = $stmt->fetch(PDO::FETCH_LAZY)){
						$U_i_subscriber = json_decode($row['i_subscriber']);
				}
				
				$stmt = $this->pdo->prepare('SELECT my_subscribers FROM users WHERE id = :idS');
				$stmt->execute(array(
								':idS' => $idS
								));
								
				while($row = $stmt->fetch(PDO::FETCH_LAZY)){
						$U_my_subscribers = json_decode($row['my_subscribers']);
				}
				if(!(in_array($idS,$U_i_subscriber) AND in_array($idU,$U_my_subscribers))){
					array_push($U_i_subscriber,$idS);
					array_push($U_my_subscribers,$idU);
					$U_my_subscribers = json_encode($U_my_subscribers);
					$U_i_subscriber = json_encode($U_i_subscriber);
					$stmt = $this->pdo->prepare("UPDATE users  SET `i_subscriber` = :U_i_subscriber
												WHERE `users`.`id` = :idU");
					$stmt->execute(array(
						':U_i_subscriber' => $U_i_subscriber,
						':idU' => $idU
					));
					$stmtS = $this->pdo->prepare("UPDATE users  SET `my_subscribers` = :U_my_subscribers
												WHERE `users`.`id` = :idS");
					$stmtS->execute(array(
						':U_my_subscribers' => $U_my_subscribers,
						':idS' => $idS
					));
					$res = true;
				}
				
			}else{
				$res = "false0";
			}
			return $res;	
		}
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
		$resRT = false;
		if(isset($_COOKIE['id']) AND isset($_COOKIE['idСheck'])){
			$id = $this->clear_StringData((int)base64_decode($_COOKIE['id']));
			//quoted_printable_encode(base64_encode
			$email = $this->clear_StringData($_COOKIE['idСheck']);
			$stmt = $this->pdo->prepare('SELECT email FROM users WHERE id = :id');
			$stmt->execute(array(':id' => $id));
			$resRT = false;
			while($row = $stmt->fetch(PDO::FETCH_LAZY)){
				if(password_verify($row['email'],$email)){
					$resRT = true;
				}
			}
		}else{
			$resRT = false;
		}
		return $resRT;
	}
}
	$list = new subscribe();
	$result = $list->add();
	echo json_encode($result);
?>