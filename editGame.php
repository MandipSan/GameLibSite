<!DOCTYPE HTML>
<html>	
   <?php
      include 'DB.php';

      $myObj = new myDB();

      session_start();
      $gameArray = $_SESSION['games'];
      if(isset($_POST['Submit'])){
        /* $arr = $_POST['genre'];
         if(!isset($_POST['gamename'])){
            echo "Missing Game Title";
         }elseif(empty($arr)){
            echo "Missing Game Genre";
         }elseif(!isset($_POST['consolename'])){
            echo "Missing Console Type";
         }elseif(!isset($_POST['date'])){
            echo "Missing Release Date";
         }elseif(!isset($_POST['rating'])){
            echo "Missing Game Rating";
         }else{
            $myObj->enterData($_POST['gamename'], $_POST['consolename'], $arr, $_POST['date'], $_POST['rating']);
            header("location:gameList.php");
         }*/
         for($i = 0; $i < count($gameArray); $i++){
            $pConsole = $gameArray[$i] . "consolename";
            $pRating = $gameArray[$i] . "rating";
            $pReleaseDate = $gameArray[$i] . "date";
            $pGenre = $gameArray[$i] . "genre";
            $myObj->editData($gameArray[$i], $_POST[$pConsole], $_POST[$pGenre], $_POST[$pReleaseDate], $_POST[$pRating]);
            header("location:gameList.php");
         }
      }
      if(isset($_POST['Cancel'])){
         header("location:gameList.php");
      }
   ?>
   <head>
      <h1> Edit Video Games </h1>
   </head>
   <body>
      <form name="form1" method="post" action="editGame.php" target="_self">
         <?php
            for($i = 0; $i < count($gameArray); $i++){
               $result = $myObj->retrieveGame($gameArray[$i]);
               echo "<table>";
               
               echo "<tr><td>Game Name</td><td>:</td><td>" . $gameArray[$i] . "</td></tr>";

               echo "<tr><td>Console Name</td><td>:</td>";
               $consoles = $myObj->retrieveAllConsole();
               foreach($consoles as $row){
                  $tempRowData = $row['console'];
                  echo "<td>" . $tempRowData . "</td>";
                  if($tempRowData ==  $result['Console']){
                     echo "<td><input name=\"" . $gameArray[$i] . "consolename\" type=radio value=\"" . $tempRowData . "\" checked></td>";
                  }else{
                     echo "<td><input name=\"" . $gameArray[$i] . "consolename\" type=radio value=\"" . $tempRowData . "\"></td>";
                  }
               }
					echo "</tr>";
               
               echo "<tr><td>Genre</td><td>:</td>";
               $genres = $myObj->retrieveAllGenre(); 
               $gameGenres = explode(",",str_replace(" ","",$result['Genre'])); 
               foreach($genres as $row){
                  $tempRowData = $row['genre'];
                  echo "<td>" . $tempRowData . "</td>";
                  if(in_array($tempRowData, $gameGenres)){
                     echo "<td><input name=\"" . $gameArray[$i] . "genre[]\" type=checkbox value=\"" . $tempRowData . "\" checked></td>";
                  }else{
                     echo "<td><input name=\"" . $gameArray[$i] . "genre[]\" type=checkbox value=\"" . $tempRowData . "\"></td>";
                  }
               }
               echo "</tr>";

               echo "<tr><td>Rating</td><td>:</td>";
               $ratings = $myObj->retrieveAllRating();
               foreach($ratings as $row){
                  $tempRowData = $row['rating'];
                  echo "<td>" . $tempRowData . "</td>";
                  if($tempRowData ==  $result['Rating']){
                     echo "<td><input name=\"" . $gameArray[$i] . "rating\" type=radio value=\"" . $tempRowData . "\" checked></td>";
                  }else{
                     echo "<td><input name=\"" . $gameArray[$i] . "rating\" type=radio value=\"" . $tempRowData . "\"></td>";
                  }
               }
               echo "</tr>";

               echo "<tr><td>Release Date(Year-Month-Day)</td><td>:</td>";
               echo "<td><input name=\"" . $gameArray[$i] . "date\" type=date value=\"" . $result['ReleaseDate'] . "\"></td>"; 
               echo "</tr>";

               echo "</table>";
            }
         ?>
         <input type="submit" name="Submit" value="Submit">
         <input type="submit" name="Cancel" value="Cancel">
      </form>
   </body>
</html>
