<?php
	header("Content-Type: text/html; charset='utf-8'");
	require_once("../config.php");
class more{
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
			$minID = 1;
			$stmt = $this->pdo->prepare('SELECT max(idPhoto) FROM usersphoto');
			$stmt->execute();
			while($row = $stmt->fetch(PDO::FETCH_LAZY)){
				$maxID = $row['max(idPhoto)'];
			}
			$number = array();
			$number = $this->noRepeat($maxID,$minID);
			
			$stmt = $this->pdo->prepare('SELECT u.id,u.name,u.alias,u.minAVA,
										up.photo,up.likePhoto,up.idPhoto,up.description
										FROM users u JOIN usersphoto up WHERE up.keyId = u.id AND  
										(up.idPhoto = :one OR up.idPhoto = :two OR up.idPhoto = :three OR
										up.idPhoto = :t4 OR up.idPhoto = :t5 OR up.idPhoto = :t6 OR
										up.idPhoto = :t7 OR up.idPhoto = :t8 OR up.idPhoto = :t9 OR
										up.idPhoto = :t10 OR up.idPhoto = :t11 OR up.idPhoto = :t12
										) ORDER BY likePhoto');
			$stmt->execute([
				':one' => $number[0],
				':two' => $number[1],
				':three' => $number[2],
				':t4' => $number[3],
				':t5' => $number[4],
				':t6' => $number[5],
				':t7' => $number[6],
				':t8' => $number[7],
				':t9' => $number[8],
				':t10' => $number[9],
				':t11' => $number[10],
				':t12' => $number[11]
			]);
			
			$resId = array(12);
			$resMinAva = array(12);
			$resName = array(12);
			$resName = array(12);
			$resAlias = array(12);
			$resPhoto = array(12);
			$resIdPhoto = array(12);
			$resLikePhoto = array(12);
			$resDescription= array(12);
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

	public function noRepeat($maxIDFunc,$minIDFunc){			
		$limit = 12;
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
	$list = new more();
	$result = $list->add();
	echo json_encode($result);
?>