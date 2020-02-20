using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;
using System;
using System.Text;

public class CreateRoom : MonoBehaviour {
	public string [] databaseData;
	public GameObject[] prefabArray;
	public GameObject[] soundArray;
	public GameObject[] roomArray;
	public GameObject waypointMarker;
	public GameObject roomParent;
	VRTeleporter teleporter;
	public int currentTask;
	public string retrieveObjectsWebsite = "http://coka.sci-project.lboro.ac.uk/FYP/RetrieveRoomData.php?";

	// Use this for initialization
	void Start () {
		teleporter = gameObject.GetComponentInChildren<VRTeleporter>();
		teleporter.ToggleDisplay(true);
		StartCoroutine(PostScores());
	}
	IEnumerator PostScores() {
    	string objects_url = retrieveObjectsWebsite + "levelNumber=" + StaticVariableScript.LevelNumber;
    	// Post the URL to the site and create a download object to get the result.
    	WWW hs_post = new WWW(objects_url);
   	 	yield return hs_post; // Wait until the download is done

    	if (hs_post.error != null){
        	print("There was an error posting the high score: " + hs_post.error);
    	}
		else {
			Debug.Log(hs_post.text);
			databaseData = hs_post.text.Split(';');
			string[] roomData = databaseData[0].Split(',');
			Instantiate(roomArray[Int32.Parse(roomData[0])]);
			roomParent = GameObject.Find("0/0");
			gameObject.transform.position = GameObject.Find("Player Start").transform.position;
			if (roomData[1] == ""){
				StaticVariableScript.NextLevel = 0;
			}
			else {
				StaticVariableScript.NextLevel = Int32.Parse(roomData[1]);
			}
			string[] objectsData = databaseData[1].Split('~');
			for(int i = 0 ; i < objectsData.Length; i++) {
				string [] roomObject = objectsData[i].Split(',');
				int prefabNumber = Int32.Parse(roomObject[0]);
				float x = float.Parse(roomObject[1]);
				float y = float.Parse(roomObject[2]);
				float z = float.Parse(roomObject[3]);
				float rotation = float.Parse(roomObject[5]);
            	GameObject levelButton = Instantiate(prefabArray[prefabNumber] , roomParent.transform);
				levelButton.transform.Rotate(new Vector3(0,rotation,0));
				levelButton.transform.localPosition = new Vector3(x,y,-z);
				levelButton.name = roomObject[4];
			}
			string[] soundData = databaseData[2].Split('~');
			for(int i = 0; i < soundData.Length ; i++) {
				string[] sound = soundData[i].Split(',');
				if (sound[0] == ""){
					break;
				}
				int prefabNumber = Int32.Parse(sound[0]);
				float x = float.Parse(sound[1]);
				float y = float.Parse(sound[2]);
				bool startOnAwake = bool.Parse(sound[3]);
				bool Loop = bool.Parse(sound[4]);
				int Range = Int32.Parse(sound[5]);
				GameObject soundObject = Instantiate(soundArray[prefabNumber], roomParent.transform);
				soundObject.name = sound[6];
				soundObject.transform.localPosition = new Vector3(x , 0 , -y);
				soundObject.GetComponent<AudioSource>().playOnAwake = startOnAwake;
				soundObject.GetComponent<AudioSource>().loop = Loop;
				soundObject.GetComponent<AudioSource>().maxDistance = Range;
				if(startOnAwake){
					soundObject.GetComponent<AudioSource>().Play();
				}
			}
			string[] taskData = databaseData[3].Split('~');
			GameObject taskBoard = GameObject.Find("Task");
			for(int i = 0 ; i < taskData.Length ; i++){
				string [] task = taskData[i].Split(',');
				if(task[0] == "0"){
					//Select Object
					GameObject taskObject = GameObject.Find(task[1]);
					taskObject.AddComponent<SelectObject>();
					taskObject.GetComponent<SelectObject>().taskNumber = i;
					taskBoard.transform.GetChild(i).GetComponent<Text>().text = (i + 1) + ". " + "Select Object:" + task[1];
				} 
				else if(task[0] == "1"){
					//Go to position
					GameObject marker = Instantiate(waypointMarker , roomParent.transform);
					marker.GetComponent<GoToPosition>().taskNumber = i;
					marker.transform.localPosition = new Vector3(Int32.Parse(task[1]) , 0 , -Int32.Parse(task[2]));
					taskBoard.transform.GetChild(i).GetComponent<Text>().text = (i + 1) + ". " + "Go To Position: X " + task[1] + " Y " + task[2];
				}
				else if(task[0] == "2"){
					//Exit Room
					GameObject taskObject = GameObject.Find("door");
					taskObject.AddComponent<ExitRoom>();
					taskObject.GetComponent<ExitRoom>().taskNumber = i;
					taskBoard.transform.GetChild(i).GetComponent<Text>().text = (i + 1) + ". " + "Exit Room";
				}
				else if(task[0] == "3"){
					//Play Sound
					GameObject taskObject = GameObject.Find(task[1]);
					taskObject.AddComponent<PlaySound>();
					taskObject.GetComponent<PlaySound>().taskNumber = i;
					taskBoard.transform.GetChild(i).GetComponent<Text>().text = (i + 1) + ". " + "Play Sound:" + task[1];
				}
				else if(task[0] == "4"){
					//Stop Sound
					GameObject taskObject = GameObject.Find(task[1]);
					taskObject.AddComponent<StopSound>();
					taskObject.GetComponent<StopSound>().taskNumber = i;
					taskBoard.transform.GetChild(i).GetComponent<Text>().text = (i + 1) + ". " + "Stop Sound:" + task[1];
				}
				else if(task[0] == "5"){
					GameObject taskObject = GameObject.Find("door");
					taskObject.AddComponent<ExitScene>();
					taskObject.GetComponent<ExitScene>().taskNumber = i;
					taskBoard.transform.GetChild(i).GetComponent<Text>().text = (i + 1) + ". " + "Exit Scene";
				}
			}
		}
	}
}
