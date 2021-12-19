----< The Amazing Little Poll >------------

1. About
2. Version History
3. Requirements
4. Setup

----< About >------------------------------

The Amazing Little Poll v1.3 is a very 
simple php Poll application. It uses a flat 
file to store voting scores. It's very easy 
to set up, and easy to customize.

Version 1.3 also stores all events in a log
file, lp_log.dat

The Amazing Little Poll can be freely 
distributed, manipulated, stolen, abused,
used for any kind of activities

In case of any problems with the original
code, I'll be glad to help out. Mail
to: littlepoll2@mr-corner.com

Any suggestions for improvement are also 
always very welcome!

I can not be held responsible or liable for 
anything.

Homepage of LittlePoll:
http://www.mr-corner.com/LittlePoll/index.html

----< Version history >--------------------

v1.3: Security is improved, events are 
      logged in lp_log.dat. Somewhat nicer
      programmed so it works better with 
      recent versions of PHP.

v1.2: The users can now vote again when the
      poll has changed.

v1.1: Added Number of votes
      All source in one include file
      Question can be added via admin 
      center

v1.0: First published version of The 
      Amazing Little Poll!
      
v0.1: First working version... some things
      need work.

----< Requirements >-----------------------

Besides the REALLY obvious:

A php-enabled webserver, and access to it
to set a file's attibutes.

----< Setup >------------------------------

***** Step 1: Files ***********************

Copy the following files to your home
directory on the webserver:
	- lp_settings.inc
	- lp_source.php
	- lp_admin.php
	- lp_test.php
	- lp_silly.php
	- lp_recookie.php
	- lplist.txt
	- lp_log.dat
	- lp_0.gif
	- lp_1.gif
	
***** Step 2: Attributes ******************	

Set the attributes of the file "lplist.txt"
and "lp_log.dat" to 666 - meaning read and 
write access for all parties.

***** Step 3: Set-up **********************

Open lp_admin.php in your browser, and set
up your poll. (Initial password = 
"elephant")

***** Step 4: Testing *********************

Test your poll using the Amazing Little Poll
Test Facility.

***** Step 5: Implementation 1 ************

Now that the poll itself is working, it's 
time to implement it into your site. Paste 
the following code above the <html> tag in 
your site (so really above everything else):

<?php include("lp_source.php"); ?>

(if you get an error message like "cannot 
add header information, headers already
sent by...", then please make sure that the 
<?php tag is really at the beginning of the
file)

***** Step 6: Implementation 2 ************

Where you want the poll to be in your page,
add the following lines of code:

<?php if($votingstep==1) { echo($step1str); } 
      if($votingstep==2) { echo($step2str); } 
      if($votingstep==3) { echo($step3str); }
?>

Where you want the question to be in the
page, add the following line of code:

<?php echo($question); ?>

If you want to show the total number
of votes, add the following line:

<?php echo($totalvotes); ?>

***** Step 7: Implementation 3 ************

You can add a 'dynamic' title for the Poll,
which reads something like "your votes 
please" or "thanks for your vote", 
according to the situation. Put the 
following code where you want the title to 
be:

<?php echo($mainstr); ?>

***** Step 8: Customizing 1 ***************

Open the file 'lp_settings.inc' in a text
editor and set it up according to your 
wishes.

IMPORTANT: make sure you set the filename
of your page (for example, index.php) 
correctly!

IMPORTANT: change the initial admincenter
password for better security!

***** Step 9: Customizing 2 ***************

The graph is drawn using two little .gif
files. They should be 1 pixel in width. You
can change them to change the appearance of
the graphs. 

***** Step 10: Customizing 3 **************

You can change the style of the vote button
to fit the style of your page. To do this, 
enter the CSS code in the $buttonstyle 
variable in lp_settings.inc. For
example, to get a black button with a white 
border and white text:

$buttonstyle="border:1px solid white; 
  background:black;color:white;";

For more information on CSS (cascading style
sheets), visit www.webmonkey.com

***** Step 11: Logging ********************

Open lp_log.dat to get an overview of 
events of the poll, when a new one was 
created, hack attempts, votings, etc.

*******************************************
