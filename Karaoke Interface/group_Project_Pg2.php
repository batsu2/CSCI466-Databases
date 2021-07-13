<html>
   <head>
        <title> Add Song to Queue </title>
   </head>

   <?php

//tyler buoy, Alec, Alex Smith, Joe Zeko, Joshua Hass, Bryan Butz

   $username = "z1836033";
   $password = "1992Sep16";


   try
   {
        $dsn = "mysql:host=courses;dbname=z1836033";
        $pdo = new PDO($dsn, $username, $password);
   }
   catch(PDOexception $e) {
        echo "Connection to database failes: " . $e->getMessage();
   }

   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);


   $page1Bool = "true";

  if( isset($_POST['ASC']) == false )
  {
        echo "error:  There is an error please go to page 1 first and make a selection. <br/>";
        $page1Bool = "false";
  }




   if (isset($_POST['ASC']) && isset($_POST['ascName']))
     {

	      $title = $_POST['ASC'];
              $name = $_POST['ascName'];


      //Submit query based on selection -  sort by queries added for heading sort  -Bryan
        if ($title == 'A')
        {
              if( isset($_POST['sortBy']) == false )
	            {
                $preparedA = $pdo->prepare("SELECT * FROM KARAOKE_FILE WHERE artist = :artist ORDER BY artist;");
                $preparedA->bindParam(':artist', $name);
                $preparedA->execute();
              }
	           else
	            {
	              if( $_POST['sortBy'] == "Artist" )
	             {
	                if( $_POST['AscDesc'] == "ASCE"  || isset($_POST['AscDesc']) == false)
	                {
	                  $preparedA = $pdo->prepare("SELECT * FROM KARAOKE_FILE WHERE artist = :artist ORDER BY artist;");
                        }
 	               else if( $_POST['AscDesc'] == "DESC" )
	                {
	                 $preparedA = $pdo->prepare("SELECT * FROM KARAOKE_FILE WHERE artist = :artist ORDER BY artist DESC;");
	                }
	             }
	            else if( $_POST['sortBy'] == "Song Title" )
	             {
                        if( $_POST['AscDesc'] == "ASCE"  || isset($_POST['AscDesc']) == false)
                         {
	                   $preparedA = $pdo->prepare("SELECT * FROM KARAOKE_FILE WHERE artist = :artist ORDER BY title;");
                         }
                        else if( $_POST['AscDesc'] == "DESC" )
                         {
                          $preparedA = $pdo->prepare("SELECT * FROM KARAOKE_FILE WHERE artist = :artist ORDER BY title DESC;");
                         }

		    }
		   else if(  $_POST['sortBy'] == "SongID" )
		    {
		       if( $_POST['AscDesc'] == "ASCE"  || isset($_POST['AscDesc']) == false)
                        {
	                  $preparedA = $pdo->prepare("SELECT * FROM KARAOKE_FILE WHERE artist = :artist ORDER BY fileid;");
		        }
                       else if( $_POST['AscDesc'] == "DESC" )
                        {
                      $preparedA = $pdo->prepare("SELECT * FROM KARAOKE_FILE WHERE artist = :artist ORDER BY fileid DESC;");
                        }
	            }


             $preparedA->bindParam(':artist', $name);
             $preparedA->execute();

	        }
        }
        else if ($title == 'S')
        {
	        if( isset($_POST['sortBy']) == false )
	          {
                      $preparedS = $pdo->prepare("SELECT * FROM KARAOKE_FILE WHERE title = :title ORDER BY title;");
	              $preparedS->bindParam(':title', $name);
                      $preparedS->execute();
                 }
	        else
	         {
		    if( $_POST['sortBy'] == "Artist" )
                     {
                        if( $_POST['AscDesc'] == "ASCE"  || isset($_POST['AscDesc']) == false)
                         {
                         $preparedS = $pdo->prepare("SELECT * FROM KARAOKE_FILE WHERE title = :title ORDER BY artist;");
                         }
                        else if( $_POST['AscDesc'] == "DESC" )
                        {
                         $preparedS = $pdo->prepare("SELECT * FROM KARAOKE_FILE WHERE title = :title ORDER BY artist DESC;");
                         }
                     }
                    else if( $_POST['sortBy'] == "Song Title" )
                     {
                        if( $_POST['AscDesc'] == "ASCE"  || isset($_POST['AscDesc']) == false)
                         {
                          $preparedS= $pdo->prepare("SELECT * FROM KARAOKE_FILE WHERE title = :title ORDER BY title;");
                          }
                        else if( $_POST['AscDesc'] == "DESC" )
                         {
                         $preparedS = $pdo->prepare("SELECT * FROM KARAOKE_FILE WHERE title = :title ORDER BY title DESC;");
                         }

                    }
                   else if(  $_POST['sortBy'] == "SongID" )
                   {
                       if( $_POST['AscDesc'] == "ASCE"  || isset($_POST['AscDesc']) == false)
                       {
                        $preparedS = $pdo->prepare("SELECT * FROM KARAOKE_FILE WHERE title = :title ORDER BY fileid;");
                       }
                      else if( $_POST['AscDesc'] == "DESC" )
                      {
                       $preparedS = $pdo->prepare("SELECT * FROM KARAOKE_FILE WHERE title = :title ORDER BY fileid DESC;");
                      }
                   }




               $preparedS->bindParam(':title', $name);
               $preparedS->execute();
	          }
        }
        else if ($title == 'C')
        {
  		if( isset($_POST['sortBy']) == false )
                {
                  $preparedC = $pdo->prepare("SELECT CONTRIBUTOR.name, CONTRIBUTES.contributorid,
                   CONTRIBUTES.artist, CONTRIBUTES.title, CONTRIBUTES.type, KARAOKE_FILE.fileid
                   FROM CONTRIBUTES, KARAOKE_FILE,
                   CONTRIBUTOR WHERE CONTRIBUTES.title = KARAOKE_FILE.title AND
                   CONTRIBUTOR.contributorid = CONTRIBUTES.contributorid AND CONTRIBUTOR.name = :Cname;");
                  $preparedC->bindParam(':Cname', $name);
                  $preparedC->execute();
		}
	       else
	       {
		 if( $_POST['sortBy'] == "SongID" )
                 {
                  if( $_POST['AscDesc'] == "ASCE" || isset($_POST['AscDesc']) == false)
                   {
                    $preparedC = $pdo->prepare("SELECT CONTRIBUTOR.name, CONTRIBUTES.contributorid,
                   CONTRIBUTES.artist, CONTRIBUTES.title, CONTRIBUTES.type, KARAOKE_FILE.fileid
                   FROM CONTRIBUTES, KARAOKE_FILE,
                   CONTRIBUTOR WHERE CONTRIBUTES.title = KARAOKE_FILE.title AND
                   CONTRIBUTOR.contributorid = CONTRIBUTES.contributorid AND CONTRIBUTOR.name = :Cname ORDER BY fileid;");
                   }
                  else if( $_POST['AscDesc'] == "DESC" )
                   {
                    $preparedC = $pdo->prepare("SELECT CONTRIBUTOR.name, CONTRIBUTES.contributorid,
                   CONTRIBUTES.artist, CONTRIBUTES.title, CONTRIBUTES.type, KARAOKE_FILE.fileid
                   FROM CONTRIBUTES, KARAOKE_FILE,
                   CONTRIBUTOR WHERE CONTRIBUTES.title = KARAOKE_FILE.title AND
                   CONTRIBUTOR.contributorid = CONTRIBUTES.contributorid AND CONTRIBUTOR.name = :Cname ORDER BY fileid DESC;");
                   }
                 }
                else if( $_POST['sortBy'] == "Contributor Name" )
                 {
                   if( $_POST['AscDesc'] == "ASCE" || isset($_POST['AscDesc']) == false)
                   {
                    $preparedC = $pdo->prepare("SELECT CONTRIBUTOR.name, CONTRIBUTES.contributorid,
                   CONTRIBUTES.artist, CONTRIBUTES.title, CONTRIBUTES.type, KARAOKE_FILE.fileid
                   FROM CONTRIBUTES, KARAOKE_FILE,
                   CONTRIBUTOR WHERE CONTRIBUTES.title = KARAOKE_FILE.title AND
                   CONTRIBUTOR.contributorid = CONTRIBUTES.contributorid AND CONTRIBUTOR.name = :Cname ORDER BY name;");

                   }
                   else if( $_POST['AscDesc'] == "DESC" )
                   {
                    $preparedC = $pdo->prepare("SELECT CONTRIBUTOR.name, CONTRIBUTES.contributorid,
                   CONTRIBUTES.artist, CONTRIBUTES.title, CONTRIBUTES.type, KARAOKE_FILE.fileid
                   FROM CONTRIBUTES, KARAOKE_FILE,
                   CONTRIBUTOR WHERE CONTRIBUTES.title = KARAOKE_FILE.title AND
                   CONTRIBUTOR.contributorid = CONTRIBUTES.contributorid AND CONTRIBUTOR.name = :Cname ORDER BY name DESC;");
                   }
                 }
                 else if(  $_POST['sortBy'] == "Song Title" )
                 {
                   if( $_POST['AscDesc'] == "ASCE" || isset($_POST['AscDesc']) == false)
                   {
                    $preparedC = $pdo->prepare("SELECT CONTRIBUTOR.name, CONTRIBUTES.contributorid,
                   CONTRIBUTES.artist, CONTRIBUTES.title, CONTRIBUTES.type, KARAOKE_FILE.fileid
                   FROM CONTRIBUTES, KARAOKE_FILE,
                   CONTRIBUTOR WHERE CONTRIBUTES.title = KARAOKE_FILE.title AND
                   CONTRIBUTOR.contributorid = CONTRIBUTES.contributorid AND CONTRIBUTOR.name = :Cname ORDER BY title;");
                   }
                   else if( $_POST['AscDesc'] == "DESC" )
                   {
                    $preparedC = $pdo->prepare("SELECT CONTRIBUTOR.name, CONTRIBUTES.contributorid,
                   CONTRIBUTES.artist, CONTRIBUTES.title, CONTRIBUTES.type, KARAOKE_FILE.fileid
                   FROM CONTRIBUTES, KARAOKE_FILE,
                   CONTRIBUTOR WHERE CONTRIBUTES.title = KARAOKE_FILE.title AND
                   CONTRIBUTOR.contributorid = CONTRIBUTES.contributorid AND CONTRIBUTOR.name = :Cname ORDER BY title DESC;");
                   }
                 }
                 else if( $_POST['sortBy'] == "Artist" )
                 {
                   if( $_POST['AscDesc'] == "ASCE" || isset($_POST['AscDesc']) == false)
                   {
		    $preparedC = $pdo->prepare("SELECT CONTRIBUTOR.name, CONTRIBUTES.contributorid,
                   CONTRIBUTES.artist, CONTRIBUTES.title, CONTRIBUTES.type, KARAOKE_FILE.fileid
                   FROM CONTRIBUTES, KARAOKE_FILE,
                   CONTRIBUTOR WHERE CONTRIBUTES.title = KARAOKE_FILE.title AND
                   CONTRIBUTOR.contributorid = CONTRIBUTES.contributorid AND CONTRIBUTOR.name = :Cname ORDER BY artist;");
                   }
                   else if( $_POST['AscDesc'] == "DESC" )
                   {
		    $preparedC = $pdo->prepare("SELECT CONTRIBUTOR.name, CONTRIBUTES.contributorid,
                   CONTRIBUTES.artist, CONTRIBUTES.title, CONTRIBUTES.type, KARAOKE_FILE.fileid
                   FROM CONTRIBUTES, KARAOKE_FILE,
                   CONTRIBUTOR WHERE CONTRIBUTES.title = KARAOKE_FILE.title AND
                   CONTRIBUTOR.contributorid = CONTRIBUTES.contributorid AND CONTRIBUTOR.name = :Cname ORDER BY artist DESC;");
                   }
                 }

	       $preparedC->bindParam(':Cname', $name);
               $preparedC->execute();
           }
   }
}
   ?>


 <form action="" method="POST">


   <?php //Printing the Tables
       if ( isset($_POST['ASC']) && $_POST['ASC'] == 'A' && $page1Bool == "true"): ?>
           <body bgcolor="41f4f4">
                <h1> Artist Selection </h1>
               <br/>
                <table border=3 bgcolor="#FFFFFF">
                   <thread>
                   <tr>
                        <th><input type="submit" name="sortBy" value="Artist"> </th>
                        <th><input type="submit" name="sortBy" value="Song Title"> </th>
                        <th><input type="submit" name="sortBy" value="SongID"> </th>
                   </tr>
                   </thread>
           </body>
           <tbody>
                <?php while($row = $preparedA->fetch()): ?>
                <tr>
                        <td><?php echo htmlspecialchars($row['artist']); ?></td>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
		        <td><?php echo htmlspecialchars($row['fileid']); ?></td>

             		<td> <input type="radio" name="addid" value="<?php echo $row['fileid'] ?>"  > </td>

                </tr>
                <?php endwhile; ?>
           </tbody>
   <?php endif; ?>

   <?php if ( isset($_POST['ASC']) && $_POST['ASC'] == 'S' && $page1Bool = "true"): ?>
           <body bgcolor="71f442">
                <h1> Song Selection</h1>
                <br/>
                <table border=3 bgcolor="#FFFFFF">
                <thread>
                <tr>
                        <th><input type="submit" name="sortBy" value="Song Title"> </th>
                        <th><input type="submit" name="sortBy" value="Artist"> </th>
                        <th><input type="submit" name="sortBy" value="SongID">  </th>
                </tr>
                </thread>
           </body>
           <tbody>
                <?php while ($row = $preparedS->fetch()): ?>
                <tr>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><?php echo htmlspecialchars($row['artist']); ?></td>
                        <td><?php echo htmlspecialchars($row['fileid']); ?></td>

                        <td> <input type="radio" name="addid" value="<?php echo $row['fileid'] ?>"  > </td>

                </tr>
                <?php endwhile; ?>
           </tbody>
   <?php endif; ?>

   <?php if ( isset($_POST['ASC']) && $_POST['ASC'] == 'C' && $page1Bool = "true"): ?>
           <body bgcolor="f48f41">
                <h1> Contributor Selection </h1>
                <br/>
                <table border=3 bgcolor="#FFFFFF">
                <thread>
                <tr>
                        <th><input type="submit" name ="sortBy" value="SongID"></th>
	                <th><input type="submit" name ="sortBy" value="Contributor Name"></th>
                        <th><input type="submit" name ="sortBy" value="Song Title"></th>
                        <th><input type="submit" name ="sortBy" value="Artist"></th>
                </tr>
                </thread>
           </body>
           <tbody>
                <?php while ($row = $preparedC->fetch()): ?>
                <tr>
                        <td><?php echo htmlspecialchars($row['fileid']); ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><?php echo htmlspecialchars($row['artist']); ?></td>


                        <td> <input type="radio" name="addid" value="<?php echo $row['fileid'] ?>"  > </td>
                </tr>
                <?php endwhile; ?>
           </tbody>
   <?php endif; ?>





       <?php if (isset($_POST['ASC']) && isset($_POST['ascName']) ): ?>
        <body>
    <b> Select a song to add to the queue. <br/>
        If you'd like higher priority, enter a dollar amount.</b> <br/><br/>
    <b> Enter Queue Number: </b> <input type="text" name="queueNum"> <br/><br/>

   <b> Who is selecting? </b><br/>

<?php

      $Presult2 = $pdo->query("SELECT * FROM USERS;");

      echo "<select name =\"userID\">";

       while( $row = $Presult2->fetch(PDO::FETCH_BOTH) )
       {
	 $nameVar = $row["contact_details"];
	 $idVar = $row["userid"];

	 echo "<option value=\"$idVar\">$nameVar</option>";
       }
       echo "</select>";
    ?>

	<br/><br/>
        Willing to pay: <input type="text" name="PRICE" placeholder="Insert Price"> <br/>
        <br/>

	<?php //For retaining table after submission ?>
       <?php if (isset($_POST['ASC']) && $_POST['ASC'] == 'A'): ?>
	        <input type="hidden" name="ASC" value="A">
        <?php endif; ?>

        <?php if (isset($_POST['ASC']) && $_POST['ASC'] == 'S'): ?>
           <input type="hidden" name="ASC" value="S">
        <?php endif; ?>

        <?php if (isset($_POST['ASC']) && $_POST['ASC'] == 'C'): ?>
           <input type="hidden" name="ASC" value="C">
        <?php endif; ?>

        <?php $name = $_POST['ascName'];

          //Change ascending/descending flag
	  if( isset($_POST['AscDesc']) == false && isset($_POST['sortBy']) == false )
	   echo "<input type=\"hidden\" name=\"AscDesc\" value=\"ASCE\">";
	   if( isset($_POST['AscDesc']) && $_POST['AscDesc'] == "ASCE" )
	   echo "<input type=\"hidden\" name=\"AscDesc\" value=\"DESC\">";
	  else if( isset($_POST['AscDesc']) && $_POST['AscDesc'] == "DESC" )
	   echo "<input type=\"hidden\" name=\"AscDesc\" value=\"ASCE\">";
	?>
	<input type="hidden" name="ascName" value="<?php echo $name?>" >
        <input type="submit" name="hasSubmit" value="Submit">
        &emsp;
        <input type="reset" value="Reset">
	<br/>
        <?php endif; ?>



 <?php /*ADDING TO THE QUEUE CHECKING FOR DUPLICATE KEYS*/ ?>
    <?php

         $keyCheck = $pdo->query("SELECT * FROM QUEUE;");
         $keyConfirm = true;


        if( isset($_POST['PRICE']) && isset($_POST['addid'])  )
        {

         //Check for duplicate primary key
          while($row = $keyCheck->fetch(PDO::FETCH_BOTH) )
           {
             if( $row["queueid"] == $_POST['queueNum'] )
		{
                $keyConfirm = false;
           	echo "<input type=\"hidden\" name=\"hasFailed\" value=\"true\">";
		}
	   }

           if( $keyConfirm == true  )
	     {
	      $preparedFix = $pdo->prepare("INSERT INTO QUEUE (queueid) VALUES (?);");
              $preparedFix->execute(array($_POST['queueNum']));

              $preparedAdd = $pdo->prepare("INSERT INTO ADDS (userid, fileid, queueid, moneyspent)
                                                     VALUES ( ?, ?, ?, ?);");

              $preparedAdd->execute(array($_POST['userID'], $_POST['addid'], $_POST['queueNum'], $_POST['PRICE'] ));

             }
           else
             echo "<br/><font color=\"red\">DUPLICATE QUEUE NUMBER - PLEASE CHOOSE ANOTHER NUMBER</font><br/>";

       }




        if( isset($_POST['addid']) && (isset($_POST['PRICE']) == false)  )
        {

         //Check for duplicate primary key
          while($row = $keyCheck->fetch(PDO::FETCH_BOTH) )
           {
             if( $row["queueid"] == $_POST['queueNum'] )
		{
                $keyConfirm = false;
		echo "<input type=\"hidden\" name=\"hasFailed\" value=\"true\">";
		}
           }

           if( $keyConfirm == true  )
             {
                /*
                Dont ask me why but without this it won't work it think its because we also need to make a record of$
                */
              $preparedFix = $pdo->prepare("INSERT INTO QUEUE (queueid) VALUES (?);");
              $preparedFix->execute(array($_POST['queueNum']));

              $preparedAdd = $pdo->prepare("INSERT INTO ADDS (userid, fileid, queueNum, moneyspent)
                                                   VALUES ( ?, ?, ?, 0);");

              $preparedAdd->execute(array($_POST['userID'], $_POST['addid'], $_POST['queueNum'] ));
             }
           else
             echo "<br/><font color=\"red\">DUPLICATE QUEUE NUMBER - PLEASE CHOOSE ANOTHER NUMBER</font><br/>";

       }



if( isset($_POST['hasSubmit']) && $keyConfirm == true )
  echo "<br/> <b>SONG ADDED TO QUEUE </b> <br/>";


echo "<br/> <a href=\"http:\/\/students.cs.niu.edu/~z1836033/group_Project_Pg3.php\">";
echo " >> Go to QUEUE page </a>";

echo "<br/> <br/> <a href=\"http:\/\/students.cs.niu.edu/~z1836033/group_Project_Pg1.php\">";
echo " << Go Back to Selection Page </a>";
?>
 </body>
</html>
