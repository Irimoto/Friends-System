<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>都道府県友達リスト</title>
</head>
	<link rel="stylesheet" href="area.css" type="text/css">
<body>
	<?php
	$dsn = 'mysql:dbname=FileSystem;host=localhost';
	$user = 'root';
	$password ='mysql';//vagrantの時はmysqlを入力
	$dbh = new PDO($dsn,$user,$password);
	$dbh->query('SET NAMES utf8');

	$sql = 'SELECT*FROM area_table WHERE 1';
	$stmt = $dbh->prepare($sql);
	$stmt->execute();

	while(1)
	{
		$rec = $stmt->fetch(PDO::FETCH_ASSOC);
		if($rec==false)
		{
			break;
		}
		echo '<a href="friends.php?area_id='.$rec['id'].'">';
		echo  $rec['id'];
		echo  $rec['name'];
		echo '</a>';
		echo '<br/>';
	}

	$dbh = null;
	?>
</body>
</html>
