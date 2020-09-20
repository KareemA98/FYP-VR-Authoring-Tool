# FYP-VR-Authoring-Tool
This is a repo of the code used for my Final Year Project, the goal of this project was to make a website which allowed users to create a VR environment that they can see on their phone.

* A website was created using HTML, CSS and JavaScript.
* The website was interactive and allowed the user the freedom to place objects, change the size of rooms, have multiple rooms, load previous creations, make tasks to be completed and add sounds
* A database was set up using MySQL
* The website connects to the database using PHP to send and receive data.
* Using the Unity Game Engine a mobile application was made which using C# scripts receives data from the database using PHP on what the user-designed on the website and then recreates it at runtime.
# Process
1. The website was created from scratch using HTML and CSS to style.
2. JavaScript was added to the website to make it interactive with panels which change and move according to the users' choices.
3. PHP was finally added to the website in working with JavaScripts to allow data to be received from the database when the website loads to enable changes in the database to reflect over the entire website. PHP also allows the user to save their creation to the database as well as retrieve their design to make changes.
4. The Unity Engine was used with Google VR libraries to allow for simple VR to be produced on the phone.
5. C# scripts connected to PHP scripts downloaded the room data that the user-designed.
6. C# is used to take this data and recreate the room that the user-designed.

# Languages and Tools

Languages:
C#
HTML
JavaScript
PHP
CSS
SQL

Tools used:
Unity Game Engine
MySQL
Google VR
