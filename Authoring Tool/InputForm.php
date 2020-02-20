<!DOCTYPE html>
<?php
// Configuration
    $hostname = 'localhost';
    $username = 'coka';
    $password = 'h1cYy2Uju8';
    $database = 'coka';
	$prefabs;

    try {
        $dbh = new PDO('mysql:host='. $hostname .';dbname='. $database, $username, $password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sth = $dbh->prepare('SELECT * FROM Prefabs');
		$sth->execute();
		$result = $sth-> fetchAll();
		foreach($result as $row) { 
			$prefabs[] =($row['Prefab Name']);
		}
	}
	catch(PDOException $e) {
		echo '<h1>An error has occurred.</h1><pre>', $e->getMessage() ,'</pre>';
	}
	$conn = null;
	try {
        $dbh = new PDO('mysql:host='. $hostname .';dbname='. $database, $username, $password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sth = $dbh->prepare('SELECT * FROM Tasks');
		$sth->execute();
		$result = $sth-> fetchAll();
		foreach($result as $row) { 
			$tasks[] = array($row['TaskID'] , $row['Name'] , $row['Type']);
		}
	}
	catch(PDOException $e) {
		echo '<h1>An error has occurred.</h1><pre>', $e->getMessage() ,'</pre>';
	}
	$conn = null;
	try {
        $dbh = new PDO('mysql:host='. $hostname .';dbname='. $database, $username, $password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sth = $dbh->prepare('SELECT * FROM Sounds');
		$sth->execute();
		$result = $sth-> fetchAll();
		foreach($result as $row) { 
			$sounds[] = array($row['SoundID'] , $row['Name']);
		}
	}
	catch(PDOException $e) {
		echo '<h1>An error has occurred.</h1><pre>', $e->getMessage() ,'</pre>';
	}
	$conn = null;
		try {
        $dbh = new PDO('mysql:host='. $hostname .';dbname='. $database, $username, $password);
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sth = $dbh->prepare('SELECT * FROM Locations');
		$sth->execute();
		$result = $sth-> fetchAll();
		foreach($result as $row) { 
			$locations[] = array($row['LocationID'] , $row['Name'] , $row['XSize'] , $row['YSize']);
		}
	}
	catch(PDOException $e) {
		echo '<h1>An error has occurred.</h1><pre>', $e->getMessage() ,'</pre>';
	}
	$conn = null;
		
?>
<script> var taskArray = <?php echo json_encode($tasks); ?>;</script>
<script> var soundArray = <?php echo json_encode($sounds); ?>;</script>
<script> var locationArray = <?php echo json_encode($locations); ?>;</script>
<html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link type="text/css" rel="stylesheet" href="style.css" /> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script src="WebsiteFunctions.js"></script>
</head>
<body>
Title:
<input type="text" name="Title" id="title">
Room Location:
<select name="cars" id="locations" onchange="deleteTheBoard()">
</select>
<script>
var currentRoom = "FirstRoom";
var code = ""
for(var i = 0;i < locationArray.length ; i++){
	code += "<option selected value='" + locationArray[i][0] + "' data-X='" + locationArray[i][2] +"' data-Y='" + locationArray[i][3] + "'>" + locationArray[i][1] + "</option>" ;
}
$('#locations').append(code);
</script>	
<div id="myModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
		<span class="close">&times;</span>
		<h2>Add Tasks</h2>
	</div>
	<div class="row">
		<div class="column side" style="background-color:#aaa;">
			<h2>Pick Task</h2>
			<select id="taskList" size="1" onchange="secondColumn(this)" style="overflow:auto;"></select>
			<script>
				var code = ""
				for(var i = 0;i < taskArray.length ; i++){
					code += "<option value='" + taskArray[i][2] + "'>" + taskArray[i][1] + "</option>" ;
				}
				$('#taskList').append(code);
				$('#taskList').attr('size' , taskArray.length);
			</script>
		</div>
		<div class="column middle" style="background-color:#bbb;">
			<h2>Options</h2>
			<div id="2ndTaskColumn"></div>
		</div>
		<div class="column side" style="background-color:#ccc;">
			<h2>Confirm</h2>
			<div><button onclick="addTask()"> Add Task </button></div>
		</div>
	</div>
  </div>
</div>
<div id="soundModal" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
		<span class="close">&times;</span>
		<h2>Add Sounds</h2>
	</div>
	<div class="row">
		<div class="column side" style="background-color:#aaa;">
			<h2>Pick Sound</h2>
			<select id="soundList" size="1" style="overflow:auto;"></select>
			<script>
				var code = ""
				for(var i = 0;i < soundArray.length ; i++){
					code += "<option>" + soundArray[i][1] + "</option>" ;
				}
				$('#soundList').append(code);
				$('#soundList').attr('size' , soundArray.length);
			</script>
		</div>
		<div class="column middle" style="background-color:#bbb;">
			<h2>Options</h2>
			<div id="2ndSoundColumn">
				<script>
				document.getElementById("2ndSoundColumn").innerHTML = "<table class='smallchessboard' id='soundchessboard'></table>";
				//var space = 1;
				//for (var r=0; r<10; r++) {
				//	var col = "";
				//	for (var c=0; c<10; c++) { col += "<td id='div1' onclick='clickOnMap(this)' data-pos='"+space+"'></td>"; space++; }
				//	$("#soundchessboard").append("<tr>"+col+"</tr>");
				//}
				</script>	
				Start on awake<input type="checkbox" id="startOnAwake"/><br>
				Loop<input type="checkbox" id="loop"/><br>
				<h3> Range of sound</h3>
				<div class="slidecontainer">
					<input type="range" min="1" max="10" value="5" class="slider" id="myRange"/>
					<p>Value: <span id="slideValue"></span></p>
				</div>
				<script>
					var slider = document.getElementById("myRange");
					var output = document.getElementById("slideValue");
					output.innerHTML = slider.value;
					slider.oninput = function() {
						output.innerHTML = this.value;
					}
				</script>
			</div>
		</div>
		<div class="column side" style="background-color:#ccc;">
			<h2>Confirm</h2>
			<div><button onclick="addSounds()"> Add Sounds </button></div>
		</div>
	</div>
  </div>
</div>
<div class="row">
	<div class="column side" style="background-color:#aaa;">
		<div class="btn-group">
			<button onclick="openCity(event, 'Rooms')" class="btn btn-primary">Rooms</button>
			<button class="btn btn-primary" onclick="previousCreatedRooms()">Previously Created Rooms</button>
		</div>
		<div id="Rooms" class="tabcontent">
			<h3>Rooms</h3>
			<div id="RoomButtons">
				<button type="button" id="FirstRoom" onclick="changeRoom(this.id)" class="btn btn-primary"> First Room </button>
				<button type="button" id="SecondRoom" onclick="changeRoom(this.id)" class="btn btn-primary"> Second Room </button>
				<button type="button" id="ThirdRoom" onclick="changeRoom(this.id)" class="btn btn-primary"> Third Room </button>
			</div>
		</div>
		<div id="PreviouslyCreatedRooms" class="tabcontent">
			<div id="previousTable">
				<ul class="list-group" id="previousList">
			</div>
		</div>
	</div>
	<div class="column middle" id="board" >
		<table id='chessboard'></table>
		<div>
			<img src='/FYP/OtherImages/Trash.jpg' width='100' height='100' id ='trash' ondrop='dropTrash(event)' ondragover='allowDrop(event)'/>
			<button type="button" onclick ="createRoom()" value="Submit" class="btn btn-success">
				Submit
			</button>
			<button type="button" onclick ="clearBoardAndCookies()" value="Clear All" class="btn btn-danger">
				Clear All
			</button>
			<button type="button" onclick ="updateRoom()" value="Update" class="btn btn-warning">
				Update
			</button>
		</div>
	</div>
	<div class="column side" style="background-color:#ccc;">
		<div class="btn-group">
			<button class="btn btn-outline-primary" onclick="openCity(event, 'Objects')">Objects</button>
			<button class="btn btn-outline-primary" onclick="openCity(event, 'Sounds')">Sounds</button>
			<button class="btn btn-outline-primary" onclick="openCity(event, 'Tasks')">Tasks</button>
			<button class="btn btn-outline-primary" onclick="openCity(event, 'Properties')">Properties</button>
		</div>
		<div id="Objects" class="tabcontent">
			<h3>Objects</h3>
			<div id="prefablist"></div>
		</div>
		<div id="Sounds" class="tabcontent">
			<h3>Sounds</h3>
			<div> 
				<ul id="currentSounds"></ul>
				<button type="button" value="Update" onclick="openSoundPanel()" id="addSounds">
					Add
				</button>
				<script> 
					var el = document.getElementById('currentSounds');
					var sortable = Sortable.create(el)
				</script>
			</div>
		</div>
		<div id="Tasks" class="tabcontent">
			<h3>Tasks</h3>
			<div> 
				<ul id="items"></ul>
				<button type="button" value="Update" onclick="openTaskPanel()" id="addTasks">
					Add
				</button>
				<script> 
					var el = document.getElementById('items');
					var sortable = Sortable.create(el)
				</script>
			</div>
		</div>
		<div id="Properties" class="tabcontent">
			<h3>Properties</h3>
			<div id="properties">
			<p>Please select an object to see its properties</p>
			</div>
		</div>
	</div>
	<script>
		// Get the modal
		var taskModal = document.getElementById('myModal');
		var soundModal = document.getElementById('soundModal');
		// Get the <span> element that closes the modal
		var span = document.getElementsByClassName("close")[0];
		// When the user clicks on <span> (x), close the modal
		span.onclick = function() {
			taskModal.style.display = "none";
		}
		window.onclick = function(event) {
			if (event.target == taskModal || event.target == soundModal) {
				taskModal.style.display = "none";
				soundModal.style.display = "none";
			}
		}
		var span = document.getElementsByClassName("close")[1];
			span.onclick = function() {
			soundModal.style.display = "none";
		}
		// When the user clicks anywhere outside of the modal, close it
	</script>
</div>
<p id="demo"></p>
<script>
	createTheBoard();
	$.ajax({
		type: "GET",
		url: "/FYP/GetPreviousRooms.php",
		success: function(result){$("#previousList").html(result)}
	});	
	$(document).ready(function(){
		var counter = 0;
		<?php foreach ($prefabs as $prefab) { ?>
			$("#prefablist").append("<img src='/FYP/PrefabImages/" + "<?=$prefab?>" + ".png'width='60' height='60' draggable='true' ondragstart='drag(event)' data-object='" + counter + 
			"' id='drag" + counter + "' value='" + "<?=$prefab?>" + "' data-rotation='0' data-onclick='0' data-yposition='0'" + "'>");
			counter++;
		<?php
			}
			echo 'help();';
		?>
		});
</script>
</body>
</html>
	
