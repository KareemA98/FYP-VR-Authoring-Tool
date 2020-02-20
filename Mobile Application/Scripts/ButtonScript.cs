using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.SceneManagement;

public class ButtonScript : MonoBehaviour {
	public int sceneID;
	public void NextRoom() {
		StaticVariableScript.LevelNumber = sceneID;
		SceneManager.LoadScene("CreationScene");
	} 
}
