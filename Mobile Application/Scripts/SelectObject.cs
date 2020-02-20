using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.EventSystems;

public class SelectObject : MonoBehaviour , IPointerClickHandler {
    public int taskNumber;
    private CreateRoom createRoom;
    void Start(){
        createRoom = GameObject.Find("Player").GetComponent<CreateRoom>();
    }
    public void OnPointerClick(PointerEventData pointerEventData)
    {
        //Output to console the clicked GameObject's name and the following message. You can replace this with your own actions for when clicking the GameObject.
        if (taskNumber == createRoom.currentTask){
            gameObject.SetActive(false);
            createRoom.currentTask++;
            GameObject.Find("Task").transform.GetChild(taskNumber).GetComponent<UnityEngine.UI.Text>().text += " ✓";
        }
    }
}
