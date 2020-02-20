﻿using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;
using UnityEngine.SceneManagement;
using System;

public class RetrieveFromDatabase : MonoBehaviour {
private string secretKey = "mySecretKey"; // Edit this value and make sure it's the same as the one stored on the server
public string [] databaseData;
public GameObject scrollableList; 
public GameObject prefabLevelButton;
public Transform canvas;
public string retrievePositionWebsite = "http://coka.sci-project.lboro.ac.uk/FYP/RetrieveData.php"; //be sure to add a ? to your url
//Text to display the result on

void Start()
{
    StartCoroutine(GetScores());
}

// remember to use StartCoroutine when calling this function!
IEnumerator PostScores(string name, int score)
{
    //This connects to a server side php script that will add the name and score to a MySQL DB.
    // Supply it with a string representing the players name and the players score.
    string hash = Md5Sum(name + score + secretKey);

    string post_url = retrievePositionWebsite + "levelNumber=" + StaticVariableScript.LevelNumber;

    // Post the URL to the site and create a download object to get the result.
    WWW hs_post = new WWW(post_url);
    yield return hs_post; // Wait until the download is done

    if (hs_post.error != null)
    {
        print("There was an error posting the high score: " + hs_post.error);
    }
}

// Get the scores from the MySQL DB to display in a GUIText.
// remember to use StartCoroutine when calling this function!
IEnumerator GetScores()
{
    WWW hs_get = new WWW(retrievePositionWebsite);
    yield return hs_get;

    if (hs_get.error != null)
    {
        print("There was an error getting the high score: " + hs_get.error);
    }
    else
    {
		databaseData = hs_get.text.Split('~');
		for(int i = 0 ; i < databaseData.Length; i++) {
            string[] roomData = databaseData[i].Split(',');
            GameObject levelButton = Instantiate(prefabLevelButton , scrollableList.transform );
            levelButton.GetComponentInChildren<Text>().text = roomData[0];
            levelButton.GetComponent<ButtonScript>().sceneID = Int32.Parse(roomData[2]);
		}
    }
}

public string Md5Sum(string strToEncrypt)
{
    System.Text.UTF8Encoding ue = new System.Text.UTF8Encoding();
    byte[] bytes = ue.GetBytes(strToEncrypt);

    // encrypt bytes
    System.Security.Cryptography.MD5CryptoServiceProvider md5 = new System.Security.Cryptography.MD5CryptoServiceProvider();
    byte[] hashBytes = md5.ComputeHash(bytes);

    // Convert the encrypted bytes back to a string (base 16)
    string hashString = "";

    for (int i = 0; i < hashBytes.Length; i++)
    {
        hashString += System.Convert.ToString(hashBytes[i], 16).PadLeft(2, '0');
    }

    return hashString.PadLeft(32, '0');
}

private void CreateRoom(string entry) {
	string [] variables = entry.Split(',');
}
}