var counterNo2 = 1;
var selectedObject = null;
var mapSelectedObject = null;
var currentRoomSelectedOnList = null;
function allowDrop(ev) {
ev.preventDefault();
}
function drag(ev) {
ev.dataTransfer.setData("text/html" , ev.target.id);
}
function drop(ev) {
	ev.preventDefault();
	var data = ev.dataTransfer.getData("text/html");
	document.getElementById("demo").innerHTML = data;
	if (data.startsWith("drag")) {
		var nodeCopy = document.getElementById(data).cloneNode(true);
		nodeCopy.id = ("copy" + (new Date()).getMilliseconds());
		nodeCopy.onclick = function () { clickOnObject(this); };
		ev.target.appendChild(nodeCopy);
	}
	else if (ev.target.id == data) {
		// do nothing
	}
	else if (ev.target.id.startsWith("copy")) {
		var originalNodeCopy = document.getElementById(data).cloneNode(true);
		originalNodeCopy.onclick = function () { clickOnObject(this); };
		var parent = document.getElementById(data).parentNode;
		var targetNodeCopy = ev.target.cloneNode(true);
		targetNodeCopy.onclick = function () { clickOnObject(this); };
		var target = ev.target.parentNode;
		parent.removeChild(document.getElementById(data));
		ev.target.parentNode.removeChild(ev.target);
		parent.appendChild(targetNodeCopy);
		target.appendChild(originalNodeCopy);
	}
	else {
		ev.target.appendChild(document.getElementById(data));
	}
}
function dropTrash(ev) {
	ev.preventDefault();
	var data = ev.dataTransfer.getData("text/html");
	if (data.startsWith("copy")) {
		var img = document.getElementById(data)
		img.parentNode.removeChild(img);
	}
}
function openTaskPanel(){
	secondColumn(document.getElementById("taskList"));
	var modal = document.getElementById('myModal');
	modal.style.display = "block";
}
function openSoundPanel(){
	var modal = document.getElementById('soundModal');
	modal.style.display = "block";
	if (mapSelectedObject != null) {
		mapSelectedObject.style.border ="none";
		mapSelectedObject = null;
	}
}
function secondColumn(passedType) {
	type = passedType.value;
	var div = document.getElementById("2ndTaskColumn");
	if (type== "Objects"){
		var objectArray = putBoardIntoArray();
		var data = "<select id='objectSelect' size='" + objectArray["objects"].length + "'>";
		for(var i = 0 ; i <objectArray["objects"].length ; i++) {
			data += "<option>" + objectArray["objects"][i][5] + "</option>";
		}
		div.innerHTML = data;
	}
	else if (type == "Chessboard") {
		div.innerHTML = "<table class='smallchessboard' id='taskchessboard'></table>";
		var space = 1;
		for (var r=0; r< parseInt($('#locations option:selected').attr("data-Y")); r++) {
			var col = "";
			for (var c=0; c< parseInt($('#locations option:selected').attr("data-X")); c++) { col += "<td id='div1' onclick='clickOnMap(this)' data-pos='"+space+"'></td>"; space++; }
			$("#taskchessboard").append("<tr>"+col+"</tr>");
		}
	}
	else if (type == "Sounds") {
		var soundArray = putBoardIntoArray();
		var data = "<select id='soundSelect' size='" + soundArray["sounds"].length + "'>";
		for(var i = 0 ; i < soundArray["sounds"].length ; i++) {
			data += "<option data-name='" + soundArray["sounds"][i][6] + "'>" + document.getElementById("soundList").childNodes[soundArray["sounds"][i][0]].text + " X : " + soundArray["sounds"][i][1] + " Y : " + soundArray["sounds"][i][2] +  "</option>";
		}
		div.innerHTML = data;
	}
	else if (type == "None") {
		div.innerHTML = "";
	}
}
function addTask() {
	//var type = $("#taskList option:selected").text();
	document.getElementById("demo").innerHTML = type;
	if (type == "Objects") {
		var taskConsistsOfArray = [];
		taskConsistsOfArray[0] = $("#objectSelect option:selected").text();
		taskConsistsOfArray[1] = $("#taskList option:selected").text();
		taskConsistsOfArray[2] = $("#taskList option:selected").index();
		data = "<li data-index='" + taskConsistsOfArray[2]  + "' data-paramater1='" + taskConsistsOfArray[0] + "'>" +  taskConsistsOfArray[1]+ " : " + taskConsistsOfArray[0] + "<span onclick='{$(this).parent().remove();}' class='closeButton'>&times;</span></li>"; 
		$("#items").append(data);
	}
	else if (type == "Chessboard") {
		var taskConsistsOfArray = [];
		taskConsistsOfArray[0] = mapSelectedObject.getAttribute("data-pos");
		taskConsistsOfArray[1] = $("#taskList option:selected").text();
		taskConsistsOfArray[2] = $("#taskList option:selected").index();
		var x = taskConsistsOfArray[0] % parseInt($('#locations option:selected').attr("data-X"));
		var y = taskConsistsOfArray[0] / parseInt($('#locations option:selected').attr("data-Y"));
		data = "<li data-index='" + taskConsistsOfArray[2]  + "' data-paramater1='" + x + "' data-paramater2='" + parseInt(y) + "'>" +  taskConsistsOfArray[1]+ " : X= " + x  + " Y= " + parseInt(y) + "<span onclick='{$(this).parent().remove();}' class='closeButton'>&times;</span></li>";
		$("#items").append(data);
	}
	else if (type == "Sounds"){
		var taskConsistsOfArray = [];
		taskConsistsOfArray[0] = $("#soundSelect option:selected").text();
		taskConsistsOfArray[1] = $("#soundSelect option:selected").attr("data-name");
		taskConsistsOfArray[2] = $("#taskList option:selected").text();
		taskConsistsOfArray[3] = $("#taskList option:selected").index();
		data = "<li data-index='" + taskConsistsOfArray[3]  + "' data-paramater1='" + taskConsistsOfArray[1] + "'>" +  taskConsistsOfArray[2]+ " : " + taskConsistsOfArray[0] + "<span onclick='{$(this).parent().remove();}' class='closeButton'>&times;</span></li>"; 
		$("#items").append(data);
	}
	else if (type == "None") {
		var taskConsistsOfArray = [];
		taskConsistsOfArray[0] = $("#taskList option:selected").text();
		taskConsistsOfArray[1] = $("#taskList option:selected").index();
		data = "<li data-index='" + taskConsistsOfArray[1]  + "'>" +  taskConsistsOfArray[0] + "<span onclick='{$(this).parent().remove();}' class='closeButton'>&times;</span></li>";
		$("#items").append(data);
	}
}
function addSounds() {
	var soundConsistsOfArray = [];
	soundConsistsOfArray[0] = $("#soundList option:selected").index();
	var position = mapSelectedObject.getAttribute("data-pos");
	soundConsistsOfArray[1] = parseInt(position % parseInt($('#locations option:selected').attr("data-X")));
	soundConsistsOfArray[2] = parseInt(position / parseInt($('#locations option:selected').attr("data-Y")));
	document.getElementById("demo").innerHTML = $("#startOnAwake").is(":checked");
	soundConsistsOfArray[3] = $("#startOnAwake").is(":checked");
	soundConsistsOfArray[4] = $("#loop").is(":checked");
	soundConsistsOfArray[5] = $("#myRange").val();
	var data = "<li data-index='" + soundConsistsOfArray[0]  + "' data-X='" + soundConsistsOfArray[1] + "' data-Y='" + soundConsistsOfArray[2] + "' data-startOnAwake='" + soundConsistsOfArray[3]
	+ "' data-loop='" + soundConsistsOfArray[4] + "' data-range='" + soundConsistsOfArray[5] + "' data-name='" + (new Date()).getMilliseconds() + "'>" +
	$("#soundList option:selected").val() + " - X: " + soundConsistsOfArray[1] + " Y: " + soundConsistsOfArray[2] +  "<span onclick='{$(this).parent().remove();}' class='closeButton'>&times;</span></li>";
	$("#currentSounds").append(data);
}
function createRoom() {
	Cookies.set(currentRoom , putBoardIntoArray());
	var dataArray = [];
	dataArray[0] = Cookies.getJSON("FirstRoom");
	if(Cookies.getJSON("SecondRoom") != "undefined") {
		dataArray[1] = Cookies.getJSON("SecondRoom");
		if(Cookies.getJSON("ThirdRoom") != "undefined") {
			dataArray[2] = Cookies.getJSON("ThirdRoom");
		}
	}
	document.getElementById("demo").innerHTML = JSON.stringify(dataArray);
	var title = document.getElementById('title').value;
	var size = jQuery("#select option:selected").val();
	var sceneArray = [title];
	$.ajax({
		type: "POST",
		url: "/FYP/EditData.php",
		data: { dataArray: dataArray , sceneArray : sceneArray},
		success: function() { alert("success! You've created a room"); }
	});	
}
function updateRoom() {
	if (currentRoomSelectedOnList == null){
		alert("You need to select a previously made room to update");
	} else {
		var checking = confirm("Are you sure you want to update " + currentRoomSelectedOnList.getAttribute("data-scenename"))
		if (checking) {
			Cookies.set(currentRoom , putBoardIntoArray());
			var dataArray = [];
			dataArray[0] = Cookies.getJSON("FirstRoom");
			if(Cookies.getJSON("SecondRoom") != "undefined") {
				dataArray[1] = Cookies.getJSON("SecondRoom");
				if(Cookies.getJSON("ThirdRoom") != "undefined") {
					dataArray[2] = Cookies.getJSON("ThirdRoom");
				}
			}
			document.getElementById("demo").innerHTML = JSON.stringify(dataArray);
			sceneNumber = currentRoomSelectedOnList.getAttribute("data-sceneNumber");
			$.ajax({
				type: "POST",
				url: "/FYP/UpdateRoom.php",
				data: { dataArray: dataArray , sceneID : sceneNumber},
				success: function() { alert("success! You've updated a room"); }
			});	
		}
	}
}
	
function openCity(evt, cityName) {
    // Declare all variables
    var i, tabcontent, tablinks;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(cityName).style.display = "block";
    //evt.currentTarget.className += " active";
}

function previousCreatedRooms() {
	openCity(event,"PreviouslyCreatedRooms");
}
function previousRoomsObjects(sceneNumber , sceneName , element) {
	if(currentRoomSelectedOnList == null){
		currentRoomSelectedOnList = element;
		element.className += " active";
	}
	else {
		currentRoomSelectedOnList.className = "list-group-item";
		currentRoomSelectedOnList = element;
		currentRoomSelectedOnList.className += " active";
	}
	
	$.ajax({
		type: "GET",
		url: "/FYP/GetPreviousObjects.php?sceneNumber=" + sceneNumber,
		success: function(data){
			populateCookiesWithArray(data);
		},
		dataType:"json"
	});	
}
function changeRoom(newRoomName) {
	if (currentRoom != newRoomName) {
		Cookies.remove(currentRoom);
		Cookies.set(currentRoom , putBoardIntoArray());
		currentRoom = newRoomName;
		var newRoomArray = Cookies.getJSON(currentRoom);
		document.getElementById("demo").innerHTML = "new room array = " + newRoomArray;
		if(newRoomArray != undefined) {
			$("#locations").val(newRoomArray["locations"]);
		}
		deleteTheBoard();
		populateBoardWithArray(newRoomArray);
	}
}
function populateBoardWithArray(roomArray) {
	var chessboard = document.getElementById('chessboard');
	if(roomArray != undefined) {
		var objectArray = roomArray["objects"];
		if(objectArray != undefined) {
			for(var i = 0;i < objectArray.length ; i++) {
				var nodeCopy = document.getElementById("prefablist").childNodes[objectArray[i][0]].cloneNode(true);
				nodeCopy.id = ("copy" + (Math.floor((Math.random() * 1000) + 1)));
				nodeCopy.onclick = function () { clickOnObject(this); };
				nodeCopy.value = objectArray[i][4];
				nodeCopy.setAttribute("data-rotation" , objectArray[i][5]);
				nodeCopy.setAttribute("data-yposition" , objectArray[i][2]);
				nodeCopy.setAttribute("data-onclick" , objectArray[i][6]);
				nodeCopy.style = 'transform: rotate(' + objectArray[i][5] + 'deg)';
				chessboard.childNodes[parseInt(objectArray[i][3])].childNodes[parseInt(objectArray[i][1])].appendChild(nodeCopy);
			}
		}
		var taskArray = roomArray["tasks"];
		var tasks = document.getElementById('items');
		if (taskArray != null) {
			for(var i = 0 ; i < taskArray.length ; i++) {
				var taskType = document.getElementById("taskList").childNodes[taskArray[i][0]].value;
				if (taskType == "Objects") {
					data = "<li data-index='" + taskArray[i][0]  + "' data-paramater1='" + taskArray[i][1] + "'>" +  document.getElementById("taskList").childNodes[taskArray[i][0]].text + " : " + taskArray[i][1] + "<span onclick='{$(this).parent().remove();}' class='closeButton'>&times;</span></li>"; 
					$("#items").append(data);
				}
				else if (taskType == "Chessboard") {
					var x = taskArray[i][1]
					var y = taskArray[i][2]
					data = "<li data-index='" + taskArray[i][0]  + "' data-paramater1='" + x + "' data-paramater2='" + parseInt(y) + "'>" +  document.getElementById("taskList").childNodes[taskArray[i][0]].text + " : X= " + x  + " Y= " + parseInt(y) + "<span onclick='{$(this).parent().remove();}' class='closeButton'>&times;</span></li>";
					$("#items").append(data);
				}
				else if (type == "Sounds"){
					var taskConsistsOfArray = [];
					data = "<li data-index='" + taskArray[i][0]  + "' data-paramater1='" + taskArray[i][1] + "'>" +  document.getElementById("taskList").childNodes[taskArray[i][0]].text + " : " + taskArray[i][1] + "<span onclick='{$(this).parent().remove();}' class='closeButton'>&times;</span></li>"; 
					$("#items").append(data);
				}
				else if (type == "None") {
					var taskConsistsOfArray = [];
					taskConsistsOfArray[0] = $("#taskList option:selected").text();
					taskConsistsOfArray[1] = $("#taskList option:selected").index();
					data = "<li data-index='" + taskArray[i][0]  + "'>" + document.getElementById("taskList").childNodes[taskArray[i][0]].text  + "<span onclick='{$(this).parent().remove();}' class='closeButton'>&times;</span></li>";
					$("#items").append(data);
				}
			}
		}
		var soundArray = roomArray["sounds"];
		var sounds = document.getElementById('currentSounds');
		for (var i=0; i < soundArray.length ; i++) {
			var data = "<li data-index='" + soundArray[i][0]  + "' data-X='" + soundArray[i][1] + "' data-Y='" + soundArray[i][2] + "' data-startOnAwake='" + soundArray[i][3]
			+ "' data-loop='" + soundArray[i][4] + "' data-range='" + soundArray[i][5] + "' data-name='" + soundArray[i][6] + "'>" +
			document.getElementById("soundList").childNodes[soundArray[i][0]].text + " X: " + soundArray[i][1] + " Y: " + soundArray[i][2] +  "<span onclick='{$(this).parent().remove();}' class='closeButton'>&times;</span></li>";
			sounds.innerHTML += data;
		}
	}
}

function populateCookiesWithArray(sceneArray){
	document.getElementById("demo").innerHTML += "new room array = " + JSON.stringify(sceneArray);
	Cookies.set("FirstRoom" , sceneArray[0]);
	Cookies.set("SecondRoom" , sceneArray[1]);
	Cookies.set("ThirdRoom" , sceneArray[2]);
	currentRoom = "FirstRoom";
	$("#locations").val(sceneArray[0]["locations"]);
	deleteTheBoard()
	populateBoardWithArray(sceneArray[0]);
}
		
function deleteTheBoard() {
	var myNode = document.getElementById("chessboard");
	while (myNode.firstChild) {
		myNode.removeChild(myNode.firstChild);
	}
	var soundChess = document.getElementById("soundchessboard");
	while (soundChess.firstChild) {
		soundChess.removeChild(soundChess.firstChild);
	}
	var taskList = document.getElementById("items");
	while (taskList.firstChild) {
		taskList.removeChild(taskList.firstChild);
	}
	var soundList = document.getElementById("currentSounds");
	while (soundList.firstChild) {
		soundList.removeChild(soundList.firstChild);
	}
	createTheBoard();
}
function createTheBoard() {
	if ($('#locations option:selected').attr("data-Y") == undefined){
		$("#locations").val("0");
	}
	var space = 1;
	for (var r=0; r< parseInt($('#locations option:selected').attr("data-Y")); r++) {
		var col = "";
		for (var c=0; c< parseInt($('#locations option:selected').attr("data-X")) ; c++) { col += "<td id='div1' ondrop='drop(event)' ondragover='allowDrop(event)' data-pos='"+space+"'></td>"; space++; }
			$("#chessboard").append("<tr>"+col+"</tr>");
	}
	for (var r=0; r< parseInt($('#locations option:selected').attr("data-Y")); r++) {
		var col = "";
		for (var c=0; c < parseInt($('#locations option:selected').attr("data-X")) ; c++) { col += "<td id='div1' onclick='clickOnMap(this)' data-pos='"+space+"'></td>"; space++; }
			$("#soundchessboard").append("<tr>"+col+"</tr>");
	}
}
function putBoardIntoArray() {
	var chessboard = document.getElementById('chessboard');
	var objectArray = []; 
	var c = chessboard.childNodes;
	for( var i = 0 ; i < c.length  ; i++) {
		var row = c[i];
		for ( var j = 0 ; j < row.children.length ; j++) {
			var data = c[i].childNodes[j];
			if (data.children.length != 0) {
				var node = data.childNodes[0];
				objectArray.push([parseInt(node.getAttribute("data-object")) , j , parseInt(node.getAttribute("data-yposition")) , i ,,
				node.getAttribute("value") , node.getAttribute("data-rotation") , node.getAttribute("data-onclick")]);
			}
		}
	}
	var taskList = document.getElementById("items");
	var taskArray = []
	for (var i = 0 ; i < taskList.children.length ; i++) {
		var element = taskList.childNodes[i];
		taskArray.push([parseInt(element.getAttribute("data-index")) , element.getAttribute("data-paramater1") , element.getAttribute("data-paramater2")]);
	}
	var soundList = document.getElementById("currentSounds");
	var soundArray = []
	for (var i = 0 ; i < soundList.children.length ; i++) {
		var element = soundList.childNodes[i];
		soundArray.push([parseInt(element.getAttribute("data-index")) , element.getAttribute("data-X") , element.getAttribute("data-Y") , element.getAttribute("data-startOnAwake") , element.getAttribute("data-loop") ,
		element.getAttribute("data-range"), element.getAttribute("data-name")]);
	}	
	var array = {"objects" : objectArray , "tasks" : taskArray , "sounds" : soundArray , "locations" : $("#locations option:selected").val()};
	return array;
}
function clearBoardAndCookies() {
	Cookies.remove("FirstRoom");
	Cookies.remove("SecondRoom");
	Cookies.remove("ThirdRoom");
	deleteTheBoard();
}
function help() {
	if(Cookies.getJSON("FirstRoom") != undefined) {
		populateBoardWithArray(Cookies.getJSON("FirstRoom"));
	}
}
function clickOnObject(element) {
	if (element == selectedObject) {
		selectedObject.style.border = "none";
		selectedObject = null;
		openCity(event , 'Objects');
	} 
	else {
		openCity(event , 'Properties');
		element.style.border = "thick solid #0000FF";
		if (selectedObject != null) {
			selectedObject.style.border ="none";
		}
		selectedObject = element;
	}
	propertiesOfAnObject(selectedObject);
}
function clickOnMap(element) {
	if (element == mapSelectedObject) {
		mapSelectedObject.style.border = "none";
		mapSelectedObject = null;
	} 
	else {
		element.style.border = "thick solid #0000FF";
		if (mapSelectedObject != null) {
			mapSelectedObject.style.border ="none";
		}
		mapSelectedObject = element;
	}
}
function propertiesOfAnObject(element) {
	if (element != null) {
		var html = 	"Name: <input type='text' class='propOptions' name='name' value='"+ element.getAttribute("value") + "'><br>" +
					"Rotation: <input type='text' class='propOptions' name='rotation' value='" +  element.getAttribute("data-rotation") + "'><br>" +
					"Y Position: <input type='text' class='propOptions' name='yposition' value='" + element.getAttribute("data-yposition") + "'><br>" +
					"OnClick: <select id=onclickSelect class='propOptions'>" +
						" 	<option> Nothing </option>" +
						" 	<option> Play Animation </option>" +
						" 	<option> Destroy </option> </select><br>" +
					"<input type='button' value='Update Object' onclick='changeProperties(selectedObject)'>";
		document.getElementById("properties").innerHTML = html;
		document.getElementById("onclickSelect").options[parseInt(element.getAttribute("data-onclick"))].selected = true;
	}
	else {
		var html = "<p>Please select an object to see its properties</p>";
		document.getElementById("properties").innerHTML = html;
	}
}
function changeProperties(element) {
	var options = document.getElementsByClassName("propOptions");
	element.setAttribute("value" , options[0].value);
	element.setAttribute("data-rotation" , options[1].value);
	element.style = 'transform: rotate(' + options[1].value + 'deg)';
	element.setAttribute("data-yposition" , options[2].value);
	element.setAttribute("data-onclick" , options[3].selectedIndex);
}