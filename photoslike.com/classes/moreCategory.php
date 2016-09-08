<?php
	header("Content-Type: text/html; charset='utf-8'");
	require_once("../config.php");
class moreCategory{
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
			if(isset($_POST['idC']) AND isset($_POST['countImg'])){
				$catId = $this->clear_StringData((int)$_POST['idC']);
				$countImg = $this->clear_StringData((int)$_POST['countImg']);
			}else{
				exit;
			}
			if(!$catId){
					$stmt = $this->pdo->prepare('SELECT u.id,u.name,u.alias,u.minAVA,
												up.photo,up.likePhoto,up.idPhoto,up.description
												FROM users u JOIN usersphoto up WHERE u.id = up.keyId
												ORDER BY up.dateTime DESC LIMIT '. $countImg .',12');//Хз почему не работает когда вставляешь как обычно
				$stmt->execute();
			}else{
					$stmt = $this->pdo->prepare('SELECT u.id,u.name,u.alias,u.minAVA,
												up.photo,up.likePhoto,up.idPhotoup.description
												FROM users u JOIN usersphoto up WHERE up.category = :catId AND u.id = up.keyId
												ORDER BY up.dateTime DESC LIMIT '. $countImg .',12');//Хз почему не работает когда вставляешь как обычно
				$stmt->execute([
					':catId' => $catId
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
			$resDescription= array();
			$count = 0;
			foreach($stmt as $row){
				$resId[$count] = $row['id'];
				$resMinAva[$count] = $row['minAVA'];
				$resName[$count] = $row['name'];
				$resAlias[$count] = $row['alias'];
				$resPhoto[$count] = $row['photo'];
				$resIdPhoto[$count] = $row['idPhoto'];
				$resLikePhoto[$count] = $row['likePhoto'];
				$resDescription[$count] = $row['description'];
				$count +=1;
			}
			$res = array($resId,$resMinAva,$resName,$resAlias,$resPhoto,$resIdPhoto,$resLikePhoto,$resDescription);
			
		return $res;	
	}
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
}
	$list = new moreCategory();
	$result = $list->add();
	echo json_encode($result);
?>