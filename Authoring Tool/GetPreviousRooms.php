   <?php
   // Configuration
    $hostname = 'localhost';
    $username = 'coka';
    $password = 'h1cYy2Uju8';
    $database = 'coka';
	$link = mysqli_connect($hostname,$username, $password, $database);
	if($link === false){
	die("ERROR: Could not connect. " . mysqli_connect_error());
	}
	$sql = "SELECT SceneName , Size , SceneID FROM SceneData";
	$result = mysqli_query($link ,$sql);
	while($row = mysqli_fetch_array($result)) {
		echo "<li class=\"list-group-item\"";
		echo " onclick=\"previousRoomsObjects(this.getAttribute('data-scenenumber') , this.getAttribute('data-sceneName') , this)\" data-scenenumber='" .$row['SceneID']."' data-sceneName='" . $row['SceneName'] ."'>";
		echo $row['SceneName'];
		echo "</li>";
	}
	echo "</table>";
	// Close connection
	mysqli_close($link);
	?>
	