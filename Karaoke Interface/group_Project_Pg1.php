<html>
 <head><title>Sing Your Damn Heart Out Inc.</title></head>
  <body bgcolor="#f9e49f">
    <h1> <b> &emsp; &nbsp; KARAOKE MCP </b> </h1>
    <h5> BOW DOWN BEFORE MY INFINITE KNOWLEDGE OF KARAOKE</h5>
    <?php

    	 //set to whatever username/password
    		$username = 'z1836033';
       	        $password = '1992Sep16';


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


    echo "<b><br/> &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&ensp;&nbsp; Search by  </b>";
    echo "<form method=\"POST\" action=\"http:\/\/students.cs.niu.edu/~z1836033/group_Project_Pg2.php\">";
    echo " &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; Artist <input type=\"radio\" name=\"ASC\" value=\"A\"> <br />";
    echo " &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp; Song   <input type=\"radio\" name=\"ASC\" value=\"S\"> <br />";
    echo " &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp; Contributor <input type=\"radio\" name=\"ASC\" value=\"C\"> <br /> <br />";
    echo "Enter name: <input type=\"text\" name=\"ascName\"> <br/>";

    echo "<br/>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; <input type=\"submit\" value=\"Submit\">  <input type=\"reset\" value=\"Reset\">";

    echo "<br/><br/><br/> <a href=\"http:\/\/students.cs.niu.edu/~z1836033/group_Project_Pg3.php\">";
    echo "To DJ Page >> </a>";

    $preparedA = $pdo->prepare("SELECT * FROM KARAOKE_FILE WHERE artist = ?;");
    $preparedS = $pdo->prepare("SELECT * FROM KARAOKE_FILE WHERE title = ?;");
    $preparedC = $pdo->prepare("SELECT CONTRIBUTOR.name, CONTRIBUTES.contributorid, CONTRIBUTES.artist, CONTRIBUTES.title, CONTRIBUTES.type FROM CONTRIBUTES, CONTRIBUTOR WHERE CONTRIBUTOR.contributorid = CONTRIBUTES.contributorid AND CONTRIBUTOR.name = ?;");


    if( isset($_POST['ASC']) && isset($_POST['ascName']) )
    {

      if( $_POST['ASC'] == 'A')
        $preparedA->execute(array($_POST['ascName'] ));
      else if( $_POST['ASC'] == 'S')
        $preparedS->execute(array($_POST['ascName'] ));
      else if( $_POST['ASC'] == 'C')
        $preparedC->execute(array($_POST['ascName'] ));
    }


    if(isset( $_POST['ASC']) && isset($_POST['ascName'])  )
     {

        echo "<table border = 1 bgcolor=\"#FFFFFF\">";


       if( $_POST['ASC'] == 'A')
       {
         while($row = $preparedA->fetch(PDO::FETCH_BOTH) )
            {
                echo "<tr><th>Artist</th><th>Song Title</th><th>Song ID</th></tr>";
                echo"<tr><td>" . $row["artist"] . "</td><td>" . $row["title"].  "</td><td>" . $row["fileid"] . "</td></tr>";
            }


       }
      else if( $_POST['ASC'] == 'S')
         {
           while($row = $preparedS->fetch(PDO::FETCH_BOTH) )
            {
                echo "<tr><th>Artist</th><th>Song Title</th><th>Karaoke ID</th></tr>";
                echo"<tr><td>" . $row["artist"] . "</td><td>" . $row["title"].  "</td><td>" . $row["fileid"] . "</td></tr>";
            }

         }
      else if( $_POST['ASC'] == 'C')
         {
          while($row = $preparedC->fetch(PDO::FETCH_BOTH) )
          {
              echo "<tr><th>Contributor ID</th><th>Contributor Name</th><th>Song Title</th><th>Artist</th></tr>";
              echo"<tr><td>" . $row["contributorid"] . "</td><td>" . $row["name"].  "</td><td>" . $row["title"] . "</td><td>" . $row["artist"] . "</td></tr>";
          }

         }
    }



     echo "</form>";
    ?>
  </body>
</html>
