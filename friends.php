<?php
	$dsn = 'mysql:dbname=FileSystem;host=localhost';
	$user = 'root';
	$password ='mysql'; //vagrantの時はmysqlを入力
	$dbh = new PDO($dsn,$user,$password);
	$dbh->query('SET NAMES utf8');

	$area_id=$_GET['area_id'];


	if(isset($_POST['del_id']))
	{
	
	$del_sql = 'DELETE FROM `friends_table` WHERE `id`='.$_POST['del_id'];
	$del_stmt = $dbh->prepare($del_sql);
	$del_stmt->execute();

	$url='/friends.php?area_id='.$_POST['area_id'].'';
	header('Location: http://'.$_SERVER['HTTP_HOST'].$url);
	//header('Location: http://'.$_SERVER['HTTP_HOST'].'/friends.php');
	}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>都道府県友達リスト</title>
</head>
	
<body>

	<?php

	$sql = 'SELECT*FROM area_table WHERE id='.$area_id;
	$stmt = $dbh->prepare($sql);
	$stmt->execute();

	$rec = $stmt->fetch(PDO::FETCH_ASSOC);
	//var_dump($_GET['area_id']);
	echo '<br/>';
	echo  $rec['name'];
	echo 'の友達';
	echo '<br/>';

	$sql = 'SELECT*FROM friends_table WHERE from_id='.$area_id;
	$stmt = $dbh->prepare($sql);
	$stmt->execute();

	while(1)
	{    
		$rec = $stmt->fetch(PDO::FETCH_ASSOC);
		if($rec==false)
		{
			break;
		}
			echo $rec['id'];
			echo $rec['name'];
			echo ' ';
			echo $rec['gender'];
			echo ' ';
			echo $rec['age'];

			//編集
			echo '<form method="POST" action="edit.php">';
			//echo '<input name=area_id type="hidden" value="'.$area_id.'">';
			echo '<input name=id type="hidden" value="'.$rec['id'].'">'; 
			//var_dump($rec['id']);
			echo '<input type="submit" value="編集">';
			echo '</form>';
			echo ' ';

			//削除
			echo '<form method="POST" action="">';
			echo '<input name=area_id type="hidden" value="'.$area_id.'">'; 
			echo '<input name=del_id type="hidden" value="'.$rec['id'].'">';
			echo '<input type="submit" value="削除">';
			echo '</form>';
			echo '<br/>';
	}
		//追加
		echo '<a href="area.php">';
		echo '戻る';
		echo '</a>';
		echo ' ';
		echo '<a href="tuika.php?area_id='.$area_id.'">';
		echo '追加';
		echo '</a>';
		echo '<br/>';

	$dbh = null;

	?>

</body>
</html>
	