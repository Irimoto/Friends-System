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

	$sql2 = 'SELECT a.name , COUNT(f.from_id) FROM area_table a LEFT JOIN friends_table f ON a.id=f.from_id AND delete_flag=0 GROUP BY a.id';
	$stmt2 = $dbh->prepare($sql2);
	$stmt2->execute();

	while(1)
	{
		$rec = $stmt->fetch(PDO::FETCH_ASSOC);
		$rec2 = $stmt2->fetch(PDO::FETCH_ASSOC);
		//var_dump($rec2);
		if($rec==false)
		{
			break;
		}
		//人数がいるかどうか判断する
			if($rec2['COUNT(f.from_id)'] > 0){
			echo '<a href="friends.php?area_id='.$rec['id'].'">';
			echo  $rec['id'];
			echo  $rec['name'];
			echo '</a>';
			echo '('.$rec2['COUNT(f.from_id)'].')';
			echo '<br/>';
			}
			else{
			echo  $rec['id'];
			echo  $rec['name'];
			echo '</a>';
			echo '('.$rec2['COUNT(f.from_id)'].')';
			echo '<br/>';
			}
	}

	$dbh = null;
	?>
</body>
</html>