using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;

public class ShowPosition : MonoBehaviour {
	public string originalText;
	// Use this for initialization
	void Start () {
	}
	
	// Update is called once per frame
	void Update () {
		gameObject.GetComponentInChildren<Text>().text = originalText + transform.localPosition.ToString();
	}
}
