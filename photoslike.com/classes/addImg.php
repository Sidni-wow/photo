<?php
	header("Content-Type: text/html; charset='utf-8'");
	require_once("../config.php");
class addImg{
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
		$res = '';
		$idU = $this->clear_StringData($_POST["idU"]);
		$countImg = $this->clear_StringData((int)$_POST["countImg"]);
		if(!is_numeric($idU)){
			$idU = (int)base64_decode($idU);
		}
		$stmt = $this->pdo->prepare('SELECT up.photo,up.description,up.idPhoto
											,u.id,u.name,u.alias,u.minAva
											FROM users u JOIN usersphoto up WHERE (u.id = :id AND up.keyId = :id) ORDER BY dateTime DESC LIMIT '.$countImg.',12 ');//Пришлось вставить потомучто по другому не работало
		$stmt->execute([
						':id' => $idU
					]);
		$resPhoto = Array();
		$resDescript = Array();
		$count = 0;
		foreach($stmt as $row){
			$resPhoto[$count] = $row['photo'];
			$resDescript[$count] = $row['description'];
			$resKeyId[$count] = $row['idPhoto'];
			$resId[$count] = $row['id'];
			$resName[$count] = $row['name'];
			$resAlias[$count] = $row['alias'];
			$resMinAva[$count] = $row['minAva'];
			$count +=1;
		}
		$res = array($resPhoto,$resDescript,$resKeyId,$resId,$resName,$resAlias,$resMinAva);
			
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
}
	$list = new addImg();
	$result = $list->add();
	echo json_encode($result);
?>