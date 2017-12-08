<!DOCTYPE HTML>
<html>
   <?php
      include 'DB.php';

      /* PURPOSE: Setup the drop down menu variables
         INPUT:   $data          - An array of the drop down menu value names(eg. Console Names)
                  $dataName      - The name of the key in the associative array in the $data
                  $dataIn        - An array setup for the values to check for in database query
                  $dataDisplay   - An array setup for the values to display the checked boxes   
         OUTPUT:  NONE
      */
      function setUpDDVar($data, $dataName, &$dataIn, &$dataDisplay){
         foreach($data as $row){
            $key = str_replace(' ', '', $row[$dataName]);
            $dataDisplay[$key] = "checked";
            if(isset($_POST[$key])){
               array_push($dataIn,$row[$dataName]);
            }else if(!isset($_POST[$key])){
               $dataDisplay[$key] = "";
            }
         }
         if(empty($dataIn)){
           $dataDisplay = array_fill_keys(array_keys($dataDisplay),'checked');
         }
      }

      /* PURPOSE: Setup the drop down menu to be display on the page
         INPUT:   $data          - An array of the drop down menu value names(Eg. Console Name)
                  $dataName      - The name of the key in the associative array in the $data
                  $dataDisplay   - Holds an array with the values to be checked
         OUTPUT:  NONE
      */
      function setUpDDDisplay($data, $dataName, $dataDisplay){
         foreach($data as $row){
            $tempRowData = $row[$dataName];
            $key = str_replace(' ', '', $row[$dataName]);
            echo $tempRowData; 
            echo "<input name=\"" . $key .  "\" type=checkbox value=\"" . $key . "\"" . $dataDisplay[$key] . " onchange=\"this.form.submit()\">";
         }
      }

      $orderBy = "Title";
      $orderDir = "ASC";
      $gameTBText = "Game Title v";
      $releaseDateTBText = "Release Date";
      $editSet = false;
      $consoleCheckDisplay = array();
      $consoleIn = array();
      $genreCheckDisplay = array();
      $genreIn = array();
      $ratingCheckDisplay = array();
      $ratingIn = array();
      $myObj = new myDB();

      
      setUpDDVar($myObj->retrieveAllConsole(), 'console', $consoleIn, $consoleCheckDisplay);
      setUpDDVar($myObj->retrieveAllGenre(), 'genre', $genreIn, $genreCheckDisplay);
      setUpDDVar($myObj->retrieveAllRating(), 'rating', $ratingIn, $ratingCheckDisplay);

      if(isset($_POST['addGame'])){
         header("location:addGame.php");
      }
      if(isset($_POST['updateGame'])){
         $editSet = true;
      }
      if(isset($_POST['editGame'])){
         session_start();
         $_SESSION['games'] = $_POST['modifyGame'];
         if($_POST['modifyGame'] != ""){
            header("location:editGame.php");
         }else{
            $editSet = true;
         }
      }
      if(isset($_POST['deleteGame'])){
         $tempArr = $_POST['modifyGame'];
         for($i = 0; $i < count($tempArr); $i++){
            $myObj->deleteData($tempArr[$i]);
         }
      }

      if(isset($_POST["gameTitle"])){
         if($_POST["gameTitle"] == "Game Title v"){
            $orderDir = "DESC";
            $gameTBText = "Game Title ^"; 
         }else{
            $orderDir = "ASC";
            $gameTBText = "Game Title v"; 
         }
         $releaseDateTBText = "Release Date";
         $orderBy = "Title";
      }else if(isset($_POST["releaseDate"])){
         if($_POST["releaseDate"] == "Release Date v"){
            $orderDir = "DESC";
            $releaseDateTBText = "Release Date ^";
         }else{
            $orderDir = "ASC";
            $releaseDateTBText = "Release Date v";
         }
         $gameTBText = "Game Title";
         $orderBy = "releaseDate";
      }
      
      $result = $myObj->retrieveAllGames($orderBy, $orderDir, $consoleIn, $genreIn, $ratingIn);
   ?>
   <head>
      <link rel="stylesheet" type="text/css" href="pageStyle.css">
      <h1> My Video Game </h1>
   </head>
   <body>
      <form name="form1" method="post" action="gameList.php" target="_self">
         <?php
            if($editSet == false){
               echo "<input type=submit name=addGame value=\"Add Game\">";
               echo "<input type=submit name=updateGame value=\"Update Game\">";
            }else{
               echo "<input type=submit name=editGame value=\"Edit Game\">";
               echo "<input type=submit name=deleteGame value=\"Delete Game\">";
            }
         ?>
         <table>
            <tr>
               <?php
                  if($editSet == true)echo "<td></td>";
                  echo "<td><input type=submit name=gameTitle value=\"" . $gameTBText . "\"></td>";
                  
                  echo "<td><div class=\"dropDown\">Console";
                  echo "<div class=\"dDContent\">";
                  setUpDDDisplay($myObj->retrieveAllConsole(),'console',$consoleCheckDisplay);
                  echo "</div></div>"; 


                  echo "<td><div class=\"dropDown\">Genre";
                  echo "<div class=\"dDContent\">";
                  setUpDDDisplay($myObj->retrieveAllGenre(),'genre',$genreCheckDisplay);
                  echo "</div></div>"; 

                  echo "<td><input type=submit name=releaseDate value=\"" . $releaseDateTBText . "\"></td>";

                  echo "<td><div class=\"dropDown\">Rating";
                  echo "<div class=\"dDContent\">";
                  setUpDDDisplay($myObj->retrieveAllRating(),'rating',$ratingCheckDisplay);
                  echo "</div></div>"; 
               ?>
            </tr>
         <?php
            
            for($i = 0; $i < count($result); $i++){
               $row = $result[$i];
               echo "<tr>";
               if($editSet == true){
                  echo "<td>";
                  echo "<input type=checkbox name=modifyGame[] value=" . $row['Title'] . ">";
                  echo "</td>";
               }
               echo "<td>" . $row['Title'] . "</td>";
               echo "<td>" . $row['Console'] . "</td>";
               echo "<td>" . $row['Genre'] . "</td>";
               echo "<td>" . $row['ReleaseDate'] . "</td>";
               echo "<td>" . $row['Rating'] . "</td>";
               echo "</tr>";

            }
         ?>
         </table>
      </form>
   </body>
</html>
