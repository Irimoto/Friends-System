<?php

    if(isset($_POST['area_id'],$_POST['name'],$_POST['gender'],$_POST['age']))
	{
	$area_id=$_POST['area_id'];
	$name=$_POST['name'];
	$gender=$_POST['gender'];
	$age=$_POST['age'];
	
	$dsn = 'mysql:dbname=FileSystem;host=localhost';
	$user = 'root';
	$password ='mysql'; //vagrantの時はmysqlを入力
	$dbh = new PDO($dsn,$user,$password);
	$dbh->query('SET NAMES utf8');

	$sql ='INSERT INTO `friends_table` (`from_id`,`name`,`gender`,`age`)VALUES("'.$area_id.'","'.$name.'","'.$gender.'","'.$age.'")';
	$stmt = $dbh->prepare($sql);
	$stmt->execute();

	$dbh = null ;

	$url='friends.php?area_id='.$area_id.'';
	header('Location: '.$url);
	}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>都道府県友達リスト</title>
</head>
	<link rel="stylesheet" href="area.css" type="text/css">
<body>
	<?php
	$area_id=$_GET['area_id'];
	//var_dump($area_id);

	//echo '<form method="POST" action="friends.php">';
	echo '<form method="POST" action="#">';
	echo '名前を入力してくだい';
	echo '<br/>';
	echo '<input name="name" type="text" style="width:100px">';
	echo '<br/>';
	echo '性別';
	echo '<br/>';
	echo '<select name="gender">';
	echo '<option>';
	echo '男';
	echo '</option>';
	echo '<option>';
	echo '女';
	echo '</option>';
	echo '</select>';
	echo '<br>';
	echo '年齢';
	echo '<br>';
	echo '<input name="age" type="text" style="width:100px">';
	echo '<br/>';
	echo '<input name=area_id type="hidden" value="'.$area_id.'">';
	echo '<input type="submit" value="保存">';
	echo '</form>';

	?>
</body>
</html>
