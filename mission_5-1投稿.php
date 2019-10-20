<?php
//データベースへの接続
$dsn='mysql:dbname=tb210445db;host=localhost';
$user='tb-210445';
$password='uT7bk7b37r';
$pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));

//送信ホーム
	if((!empty($_POST["name"])) && (!empty($_POST["comment"]))){
		//新規投稿
		if(empty($_POST["hedit"]) && $_POST["password"]=="tech"){

			//テーブルを作成
			$sql="CREATE TABLE IF NOT EXISTS form"
						."("
						."id INT AUTO_INCREMENT PRIMARY KEY,"
						."name char(32),"
						."comment TEXT,"
						."date VARCHAR(32),"
						.");";
			$stmt=$pdo->query($sql);

			//データを入力
			$sql = $pdo -> prepare("INSERT INTO form (name, comment,date) VALUES (:name, :comment,:date)");
			$sql -> bindParam(':name', $name, PDO::PARAM_STR);
			$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
			$sql -> bindParam(':date', $date, PDO::PARAM_STR);
			$name = $_POST["name"];
			$comment = $_POST["comment"]; 
			$date=date("Y/m/d H:i:s");
			$sql -> execute();

		}
		//編集
		else if(!empty($_POST["hedit"]) && empty($_POST["password"])){
			$id = $_POST["hedit"]; 
			$name = $_POST["name"];
			$comment = $_POST["comment"]; 
			$date=date("Y/m/d H:i:s");
			$sql = 'update form set name=:name,comment=:comment,date=:date where id=:id';
			$stmt = $pdo->prepare($sql);
			$stmt->bindParam(':name', $name, PDO::PARAM_STR);
			$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
			$stmt->bindParam(':id', $id, PDO::PARAM_INT);
			$stmt-> bindParam(':date', $date, PDO::PARAM_STR);
			$stmt->execute();
		}
	}

//削除ホーム
	if(!empty($_POST["number"]) && $_POST["password"]=="tech"){

		//削除番号取得して実行
		$id = $_POST["number"];
		$sql = 'delete from form where id=:id';
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
	}

	//編集ホーム
	if(!empty($_POST["num"]) && $_POST["password"]=="tech"){
		$id=$_POST['num'];
		$sql="select * from form where id=:id";
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$results = $stmt->fetch();

		$name2=$results['name'];
		$comment2=$results['comment'];
	  
	}
?>


<html>

	<head>

		<title>mission_5-1-2.html</title>
		<meta charset="utf-8">

	</head>

<body>

<!-入力用フォーム作成と初期値設定->
<form action="mission_5-1-2.php" method="post">
	<?php if(!empty($_POST["num"]) && $_POST["password"]=="tech") :?>
		<input type="text" name="name" value="<?php echo $name2 ?>"
		><br>
	<?php else :?>
		<input type="text" name="name" value="名前"><br>
	<?php endif; ?>
	<?php if(!empty($_POST["num"]) && $_POST["password"]=="tech") :?>
		<input type="text" name="comment" value="<?php echo $comment2 ?>"><br>
	<?php else :?>
		<input type="text" name="comment" value="コメント"><br>
	<?php endif ; ?>
	<?php if(!empty($_POST["num"]) && $_POST["password"]=="tech") :?>
		<input type="hidden" name="hedit" value="<?php echo $id;?>"><br>
	<?php else :?>
	<?php endif; ?>
	<?php if(!empty($_POST["num"]) && $_POST["password"]=="tech" ) :?>
	<?php else :?>
	 <input type="text" name="password" value=""><br>
	<?php endif ; ?>
	<input type="submit" name="btn" value="送信"><br>
</form>

<!-削除番号指定用フォーム->
<form action="mission_5-1-2.php" method="post">
	<input type="text" name="number"><br>
	<input type="text" name="password" value=""><br>
	<input type="submit" name="delete" value="削除"><br>
</form>

<!-編集番号指定用フォーム->
<form action="mission_5-1-2.php" method="post">
	<input type="text" name="num"><br>
	<input type="text" name="password" value=""><br>
	<input type="submit" name="edit" value="編集"><br>
</form>

</body>

</html>

<?php
//送信ホーム
	if((!empty($_POST["name"])) || (!empty($_POST["comment"])) || (!empty($_POST["delete"])) || (!empty($_POST["edit"]))){
		//データベースへの接続
		$dsn='mysql:dbname=tb210445db;host=localhost';
		$user='tb-210445';
		$password='uT7bk7b37r';
		$pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));

		$sql = 'SELECT * FROM form';
		$stmt = $pdo->query($sql);
		$results = $stmt->fetchAll();

		foreach ($results as $row){
			//$rowの中にはテーブルのカラム名が入る
			echo $row['id'].',';
			echo $row['name'].',';
			echo $row['comment'].',';
			echo $row['date'].'</br>';
			echo "<hr>";
		}


	}
?>
