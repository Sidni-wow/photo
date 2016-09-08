<?php
	header("Content-Type: text/html; charset='utf-8'");
	require_once("../config.php");
class addList{
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
		if($this->setTrueCookies()){
			$minID = 1;
			$stmt = $this->pdo->prepare('SELECT max(idPhoto) FROM usersphoto');
			$stmt->execute();
			while($row = $stmt->fetch(PDO::FETCH_LAZY)){
				$maxID = $row['max(idPhoto)'];
			}
			if($_POST['idCateg'] != ""){
				$catId = $this->clear_StringData((int)$_POST['idCateg']);
				$countImg = $this->clear_StringData((int)$_POST['countImg']);
				if(!$catId){
					$stmt = $this->pdo->prepare('SELECT u.id,u.name,u.alias,u.minAVA,
												up.photo,up.likePhoto,up.idPhoto
												FROM users u JOIN usersphoto up WHERE u.id = up.keyId
												ORDER BY up.dateTime DESC LIMIT '. $countImg .',3');//Хз почему не работает когда вставляешь как обычно
					$stmt->execute();
				}else{
						$stmt = $this->pdo->prepare('SELECT u.id,u.name,u.alias,u.minAVA,
													up.photo,up.likePhoto,up.idPhoto
													FROM users u JOIN usersphoto up WHERE up.category = :catId AND u.id = up.keyId
													ORDER BY up.dateTime DESC LIMIT '. $countImg .',3');//Хз почему не работает когда вставляешь как обычно
					$stmt->execute([
						':catId' => $catId
					]);
				}
			}else{
				$number = array();
				$number = $this->noRepeat($maxID,$minID);
				
				$stmt = $this->pdo->prepare('SELECT u.id,u.name,u.alias,u.minAVA,
											up.photo,up.likePhoto,up.idPhoto
											FROM users u JOIN usersphoto up WHERE up.keyId = u.id AND  
											(up.idPhoto = :one OR up.idPhoto = :two OR up.idPhoto = :three) ORDER BY likePhoto');
				$stmt->execute([
					':one' => $number[0],
					':two' => $number[1],
					':three' => $number[2]
				]);
			}
			$resId = array();
			$resMinAva = array();
			$resName = array();
			$resName = array();
			$resAlias = array();
			$resPhoto = array();
			$resIdPhoto = array();
			$resLikePhoto = array();
			$count = 0;
			foreach($stmt as $row){
				$resId[$count] = $row['id'];
				$resMinAva[$count] = $row['minAVA'];
				$resName[$count] = $row['name'];
				$resAlias[$count] = $row['alias'];
				$resPhoto[$count] = $row['photo'];
				$resIdPhoto[$count] = $row['idPhoto'];
				$resLikePhoto[$count] = $row['likePhoto'];
				$count +=1;
			}
			$res = array($resId,$resMinAva,$resName,$resAlias,$resPhoto,$resIdPhoto,$resLikePhoto);
			}else{
				$res = "false2";
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
	public function noRepeat($maxIDFunc,$minIDFunc){			
		$limit = 3;
		$used_nums = array();
		while(1) { 
		  $random = rand($minIDFunc, $maxIDFunc); 
		  if(!in_array($random, $used_nums)) { 
			 $used_nums[] = $random; 
		  } 
		  if(count($used_nums) == $limit) { break; } 
		} 
		return $used_nums;
	}
}
	$list = new addList();
	$result = $list->add();
	echo json_encode($result);
?>