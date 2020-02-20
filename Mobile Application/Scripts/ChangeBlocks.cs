using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class ChangeBlocks : MonoBehaviour {
	public RetrieveFromDatabase canvasScript;
	private int child; 

	public void ButtonPressed () {
		string[] array =  canvasScript.databaseData[transform.GetSiblingIndex()].Split(',');
		GameObject.Find("Object 1").transform.localPosition = new Vector3(float.Parse(array[1]),float.Parse(array[2]),float.Parse(array[3]));
		GameObject.Find("Object 2").transform.localPosition = new Vector3(float.Parse(array[4]),float.Parse(array[5]),float.Parse(array[6]));
	}

}
