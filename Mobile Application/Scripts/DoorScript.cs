using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.SceneManagement; 

public class DoorScript : MonoBehaviour {

	// Use this for initialization
	void Start () {
		
	}
	
	// Update is called once per frame
	void Update () {
		
	}

	public void DoorPressed() {
		if(gameObject.GetComponent<ExitScene>() != null){
			SceneManager.LoadScene("SampleScene");
		}
		else {
			StaticVariableScript.LevelNumber = StaticVariableScript.NextLevel;
			SceneManager.LoadScene("CreationScene");
		}
	}
}
