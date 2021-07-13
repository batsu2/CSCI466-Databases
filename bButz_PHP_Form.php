<html>
 <head><title>Bryan Butz - Assignment 8 - PHP Sript</title></head>
   <body bgcolor="#0AF41E">
     <h1>B.Butz - CSCI 466 Assignment 8</h1>

    <?php
		$username='z1836033';
		$password='***********';

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


	//queries needed for checks in #1 & 2
	$Sresult = $pdo->query("SELECT * FROM S;");
        $Presult = $pdo->query("SELECT * FROM P;");


	//queries needed for checks in #3 & 4
	$Sresult2 = $pdo->query("SELECT DISTINCT SName FROM S;");
	$Presult2 = $pdo->query("SELECT DISTINCT PName FROM P;");




	//FORM FOR SHOWING ALL PARTS AND SUPPLIERS
	 echo "<b>#1/2) <br/> Choose to view all suppliers/parts?</b>";
	 echo "<form method=\"POST\" action=\"\">";
	 echo "All Suppliers: <input type=\"radio\" name=\"allSP\" value=\"S\"> <br />";
	 echo "All Parts:     <input type=\"radio\" name=\"allSP\" value=\"P\"> <br /> <br />";
         echo "<input type=\"submit\" value=\"Submit\">";


	//if a value was submitted using radio buttons
        if(isset( $_POST['allSP']) )
	{
	 if($_POST['allSP'] != "P")
         {
	   echo "<br/> <br /> All Suppliers <br />";
	   echo "<table border = 1 bgcolor=\"#FFFFFF\">";
           echo "<tr><th>SNum</th><th>Supplier Name</th><th>Status</th><th>Location</th></tr>";


	   while($row = $Sresult->fetch(PDO::FETCH_BOTH) )
	    {
		echo"<tr><td>" . $row["SNum"]. "</td><td>" . $row["SName"]. "</td><td>" . $row["Status"].  "</td><td>" . $row["City"]. "</td></tr>";
	    }

	   echo"</table>";

 	 }
	 else if($_POST['allSP'] = "S")
	 {
	  echo "<br/> <br /> All Parts <br />";
	  echo "<table border = 1 bgcolor=\"#FFFFFF\">";
          echo "<tr><th>PNum</th><th>Part Name</th><th>Color</th><th>Weight</th></tr>";


	  while($row = $Presult->fetch(PDO::FETCH_BOTH) )
            {
                echo"<tr><td>" . $row["PNum"].  "</td><td>" . $row["PName"]. "</td><td>" . $row["Color"]. "</td><td>" . $row["Weight"]. "</td></tr>";
            }

          echo"</table>";
	 }

	}
      echo"</form>";



   echo "-------------------------------------------------------------------------------------------------------- ";

	//FORM FOR PART'S LOCATION AND QUANTITY
      echo "<form method=\"POST\" action=\"\">";
      echo "<br/> <b>#3) <br/>For a list of all available locations and quantities, select a part: </b> <br/>";

       echo "<select name =\"partz\">";

       while( $row = $Presult2->fetch(PDO::FETCH_BOTH) )
       {
	 $nameVar = $row["PName"];

	 echo "<option value=\"$nameVar\">$nameVar</option>";
       }


       echo "</select>";

       echo "<br/> <br/> <input type=\"submit\" value=\"Submit\">";

      echo "</form>";


     //IF PART IS CHOSEN, DISPLAY TABLE
      if(isset( $_POST['partz']) )
	{

	  $pInfo = $pdo->prepare("SELECT P.PName, S.SName, P.Color, SP.Qty FROM S, P, SP WHERE S.SNum=SP.SNum AND P.PNum=SP.PNum AND P.PName = ?;");
	  $pInfo->execute(array($_POST['partz']) );

	  echo "<table border = 1 bgcolor=\"#FFFFFF\">";
          echo "<tr><th>Part</th><th>Supplier</th><th>Color</th><th>Quantity</th></tr>";

           while($row = $pInfo->fetch(PDO::FETCH_BOTH) )
            {
                echo"<tr><td>" . $row["PName"] . "</td><td>" . $row["SName"].  "</td><td>" . $row["Color"] . "</td><td>" . $row["Qty"]. "</td></tr>";
            }
           echo"</table>";

	}//end display Part Table



   echo "-------------------------------------------------------------------------------------------------------- ";


     //FORM FOR SUPPLIER'S INVENTORY AND QUANTITY
      echo "<form method=\"POST\" action=\"\">";
      echo "<br/> <b>#4) <br/>For a list of available inventory and quantities, select a supplier: </b> <br/>";


       echo "<select name =\"supplier\">";

	while( $row = $Sresult2->fetch(PDO::FETCH_BOTH) )
       {
         $nameVar = $row["SName"];

         echo "<option value=\"$nameVar\">$nameVar</option>";
       }

       echo "</select>";


       echo "<br/> <br/> <input type=\"submit\" value=\"Submit\">";

      echo "</form>";



     //IF SUPPLIER IS CHOSEN, DISPLAY TABLE
      if(isset( $_POST['supplier']) )
        {

	  $pInfo = $pdo->prepare("SELECT S.SName, P.PName, P.Color, SP.Qty FROM S, P, SP WHERE S.SNum=SP.SNum AND P.PNum=SP.PNum AND S.SName = ?;");
          $pInfo->execute(array($_POST['supplier']) );


          echo "<table border = 1 bgcolor=\"#FFFFFF\">";
          echo "<tr><th>Supplier</th><th>Part</th><th>Color</th><th>Quantity</th></tr>";

           while($row = $pInfo->fetch(PDO::FETCH_BOTH) )
            {
                echo"<tr><td>" . $row["SName"] . "</td><td>" . $row["PName"].  "</td><td>" . $row["Color"] . "</td><td>" . $row["Qty"]. "</td></tr>";
            }
           echo"</table>";

        }//end display Supplier table



   echo "-------------------------------------------------------------------------------------------------------- ";


	//FORM FOR ADDING PARTS TO THE DATABASE
	 echo "<br/> <b>#5) <br/>Enter a part to add: </b> <br/>";
	 echo "<form method=\"POST\" action=\"\">";
	 echo "Part Number: (P#) <input type=\"text\" name=\"pNum\"> <br/>";
         echo "Part Name: <input type=\"text\" name=\"newPart\"> <br />";
	 echo "Part Color: <input type=\"text\" name=\"pColor\"> <br/>";
	 echo "Part Weight: <input type=\"text\" name=\"pWeight\"> <br/>";
	 echo "<br/><b>OPTIONAL: Enter supplier to add part to their inventory </b> <br/>";
	 echo "Supplier Number: <input type\"text\" name=\"supNum\"> <br/>";
	 echo "Quantity: <input type\"text\" name=\"qty\"> <br/>";

	 $prepared = $pdo->prepare("INSERT INTO P VALUES (?, ?, ?, ?);");
	 $preparedSP = $pdo->prepare("INSERT INTO SP VALUES ( ?, ?, ?);");
	 $keyCheck = $pdo->query("SELECT PNum FROM P;");
	 $keyConfirm = true;

	if( isset($_POST['pNum']) && isset($_POST['newPart'])  && isset($_POST['pColor'])  && isset($_POST['pWeight']) )
	{

	 //Check for duplicate primary key
	  while($row = $keyCheck->fetch(PDO::FETCH_BOTH) )
	   {
	     if( $row["PNum"] == $_POST['pNum'] )
		$keyConfirm = false;
	   }

	   if( $keyConfirm == true  )
	    {
	     $prepared->execute(array($_POST['pNum'], $_POST['newPart'], $_POST['pColor'], $_POST['pWeight'] ));

		//if entered, enter values into SP
	      if( isset($_POST['supNum']) && isset($_POST['qty']) && $_POST['supNum'] != "" && $_POST['qty'] != "" )
		$preparedSP->execute(array($_POST['supNum'], $_POST['pNum'], $_POST['qty'] ));
	    }
           else
	     echo "<br/><font color=\"red\">DUPLICATE PART NUMBER - PLEASE CHOOSE ANOTHER NUMBER</font><br/>";
	}


	echo "<br/> <input type=\"submit\" value=\"Submit\">  <input type=\"reset\" value=\"Reset\">";
	echo "</form>";
        //end add Part form


   echo "-------------------------------------------------------------------------------------------------------- ";


	//FORM FOR ADDING SUPPLIERS TO THE DATABASE

	echo "<br/> <b>#6) <br/>Enter a supplier to add: </b> <br/>";
         echo "<form method=\"POST\" action=\"\">";
         echo "Supplier number: (S#) <input type=\"text\" name=\"sNum\"> <br/>";
         echo "Supplier's Name: <input type=\"text\" name=\"newSupplier\"> <br />";
         echo "Supplier's Status: <input type=\"text\" name=\"sStatus\"> <br/>";
         echo "Supplier's City: <input type=\"text\" name=\"sCity\"> <br/>";

         $prepared = $pdo->prepare("INSERT INTO S VALUES (?, ?, ?, ?);");
	 $keyCheck = $pdo->query("SELECT SNum FROM S;");
         $keyConfirm = true;


        if( isset($_POST['sNum']) && isset($_POST['newSupplier'])  && isset($_POST['sStatus'])  && isset($_POST['sCity']) )
        {

         //Check for duplicate primary key
          while($row = $keyCheck->fetch(PDO::FETCH_BOTH) )
           {
             if( $row["SNum"] == $_POST['sNum'] )
                $keyConfirm = false;
           }

           if( $keyConfirm == true  )
             $prepared->execute(array($_POST['sNum'], $_POST['newSupplier'], $_POST['sStatus'], $_POST['sCity'] ));
           else
             echo "<br/><font color=\"red\">DUPLICATE SUPPLIER NUMBER - PLEASE CHOOSE ANOTHER NUMBER</font><br/>";

        }


        echo "<br/> <input type=\"submit\" value=\"Submit\">  <input type=\"reset\" value=\"Reset\">";
        echo "</form>";
	//end add Supplier form


     ?>
   </body>
</html>
