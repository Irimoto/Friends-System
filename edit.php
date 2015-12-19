<?php
	$dsn = 'mysql:dbname=FileSystem;host=localhost';
	$user = 'root';
	$password ='mysql'; //vagrantの時はmysqlを入力
	$dbh = new PDO($dsn,$user,$password);
	$dbh->query('SET NAMES utf8');

    if(isset($_POST['name']))
	{
	//UPDETE文
	$sql = "UPDATE `friends_table` SET `name` = '".$_POST['name']."',`gender` = '".$_POST['gender']."',`age` = '".$_POST['age'];
	$sql .= "' WHERE `id` = ".$_POST['id'];
	$stmt = $dbh->prepare($sql);
	$stmt->execute();


	//var_dump($_POST['from_id']);
	$url='/friends.php?area_id='.$_POST['from_id'].'';
	header('Location: http://'.$_SERVER['HTTP_HOST'].$url);
	//header('Location: http://'.$_SERVER['HTTP_HOST'].'friends.php');
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
	//$dsn = 'mysql:dbname=FileSystem;host=localhost';
	//$user = 'root';
	//$password ='mysql'; //vagrantの時はmysqlを入力
	//$dbh = new PDO($dsn,$user,$password);
	//$dbh->query('SET NAMES utf8');

	$sql_friends= 'SELECT * FROM friends_table WHERE `id`='.$_POST['id'];
	$stmt_friends= $dbh->prepare($sql_friends);
	$stmt_friends->execute();

	$rec_friends= $stmt_friends->fetch(PDO::FETCH_ASSOC);

	$id = $rec_friends['id'];
	$area_from_id = $rec_friends['from_id'];
	//var_dump($rec_friends['from_id']);
	$name = $rec_friends['name'];		
	$gender = $rec_friends['gender'];
	$age = $rec_friends['age'];

	$sql = 'SELECT * FROM `area_table`';
	$stmt = $dbh->prepare($sql);
	$stmt->execute();

	?>
	<form method="POST" action="#">
		名前<br/>
		<input name="name" type="text" value="<?php echo $name; ?>" style="width:100px"><br/>
		<select name="from_id">
			<?php
				while(1){
					$rec = $stmt->fetch(PDO::FETCH_ASSOC);
					if ($rec == false){
						break;
					}
					if ($area_from_id == $rec['id']){
						echo '<option value="'.$rec['id'].'" selected>';
					}else{
						echo '<option value="'.$rec['id'].'">';						
					}
					echo $rec['name'];
					echo '</option>';
				}
			?>
		</select><br/>
		性別<br/>
		<select name="gender">
			<?php
				if($gender == '男')
				{
				echo '<option value="男" selected>男</option>';
				echo '<option value="女">女</option>';
				}else
				{
					echo '<option value="男">男</option>';
					echo '<option value="女" selected>女</option>';
				}
			?>
		</select><br>
		年齢<br>
		<input name="age" type="text" value="<?php echo $age; ?>" style="width:100px">
		<input name="id" type="hidden" value="<?php echo $id; ?>">
		<input name-"from_id" type="hidden" value="<?php echo $area_from_id; ?>">
		<br/>
		<input type="submit" value="保存">
	</form>
</body>
</html>
