<html>
 <head><title>DJ queue control</title></head>
  <body bgcolor="#FF69B4">
    <h1> <b> DJ Song Queues</b> </h1>
    <?php

    //set to whatever username/password
          $username = 'z1836033';
    	  $password = '**********';


    //Attempt to connect to the database
	  try
	   {
	     $dsn = "mysql:host=courses;dbname=z1836033";
	     $pdo = new PDO($dsn, $username, $password);
           }
	  catch(PDOexception $e)
           {
	     echo "Connection to the database failed: " . $e->getMessage();
	   }

	  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);



//code to mark as played -Alex Smith

echo "Enter the Order Number for the played song here and click submit to remove from queue.";
echo "<form method=\"POST\" action=\"\">";
echo "<input type=\"text\" name=\"QNUM\" />";
echo "<input type=\"submit\" name=\"formSubmit\" value=\"Submit\" />";
echo "</form>";

if( isset($_POST['QNUM']) )
{
$preparedDJ = $pdo->prepare("UPDATE QUEUE SET played=1 WHERE queueid=?;");
$preparedDJ->execute(array($_POST['QNUM']));
}


//below is the code to display the queue -Alex Smith

$preparedDJ = $pdo->prepare("SELECT QUEUE.queueid, USERS.contact_details, KARAOKE_FILE.artist, KARAOKE_FILE.title, ADDS.moneyspent FROM QUEUE LEFT JOIN (USERS, KARAOKE_FILE, ADDS) ON (ADDS.userid=USERS.userid AND ADDS.queueid=QUEUE.queueid AND ADDS.fileid=KARAOKE_FILE.fileid) WHERE QUEUE.played IS NULL OR QUEUE.played=0 ORDER BY moneyspent DESC;");
$preparedDJ->execute();

echo "<table border = 1 bgcolor=\"FFFFFF\">";

echo "<tr><th>Order</th><th>Singer</th><th>Artist</th><th>Title</th><th>Money Spent</th></tr>";


while($rows = $preparedDJ->fetch(PDO::FETCH_BOTH) )
   {
        echo "<tr><td>".$rows["queueid"]."</td><td>".$rows["contact_details"]."</td><td>".$rows["artist"]."</td><td>".$rows["title"]."</td><td>".$rows["moneyspent"]."</td></tr>";

   }

echo "</table>";





 echo "<br/><br/><br/> <a href=\"http:\/\/students.cs.niu.edu/~z1836033/group_Project_Pg1.php\">";
 echo "<< Back to Search Page </a>";




    ?>
  </body>
</html>
