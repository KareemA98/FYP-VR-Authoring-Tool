<?php
    // Configuration
    $hostname = 'localhost';
    $username = 'coka';
    $password = 'h1cYy2Uju8';
    $database = 'coka';

    try {
        $dbh = new PDO('mysql:host='. $hostname .';dbname='. $database, $username, $password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sth = $dbh->prepare('SELECT * FROM SceneData');
		$sth->execute();
		$result = $sth-> fetchAll();
		foreach($result as $row) { 
			echo $row['SceneName'] . "," . $row['SceneID'] . "," . $row['FirstRoom'] . "~";
		}
	}
	catch(PDOException $e) {
		echo '<h1>An error has occurred.</h1><pre>', $e->getMessage() ,'</pre>';
	}
	$conn = null;
?>