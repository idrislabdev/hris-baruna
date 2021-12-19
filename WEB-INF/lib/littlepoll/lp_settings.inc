<?php 

//settings for The Amazing Little Poll:


// IMPORTANT: change this one into the name of your homepage file, 
//           for example, index.php
$callingfile="lp_test.php"; 

// File in which voting scores are kept
$filename = "lplist.txt"; 

// Change this password so no one else can access the lp_admin.php via the web
$pwd="elephant"; 

//Time between votes in seconds
$time_between_votes = 36000; 

// Width of graph in pixels
$graph_width = 100; 

// Height of graph in pixels
$graph_height = 6; 

// Messages (Can easily be used as 'dynamic headers' for the poll)
$message1="Your votes please";  
$message2="Thanks for Voting!";
$message3="Poll Results";

// Text on vote button
$vote_str="Vote"; 

// Use CSS code to style the 'vote' button
$buttonstyle="";
?>