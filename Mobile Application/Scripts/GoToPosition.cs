using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class GoToPosition : MonoBehaviour
{
    private CreateRoom createRoom;
    public int taskNumber;
    private AudioSource audio;
    // Start is called before the first frame update
    void Start()
    {
        createRoom = GameObject.Find("Player").GetComponent<CreateRoom>();
        audio = gameObject.GetComponent<AudioSource>();
        Debug.Log("Collision");
    }
    void OnCollisionEnter(Collision col){
        Debug.Log("Collision");
        if(col.gameObject.name == "Player") {
            if(taskNumber == createRoom.currentTask) {
                Debug.Log("works");
                audio.Play(0);
                createRoom.currentTask++;
                GameObject.Find("Task").transform.GetChild(taskNumber).GetComponent<UnityEngine.UI.Text>().text += " ✓";

            }
        }
    }

    // Update is called once per frame
    void Update()
    {
        
    }
}
