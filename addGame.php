<!DOCTYPE HTML>
<html>	
   <?php
      include 'DB.php';

      $myObj = new myDB();

      if(isset($_POST['Submit'])){
         $arr = $_POST['genre'];
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
         }
      }
      if(isset($_POST['Cancel'])){
         header("location:gameList.php");
      }
   ?>
   <head>
      <h1> Add Video Game </h1>
   </head>
   <body>
      <form name="form1" method="post" action="addGame.php" target="_self">
         <table>
            <tr>
               <td>Game Name</td>
               <td>:</td>
               <td><input name="gamename" type="text"></td>
            </tr>
            <tr>
               <td>Console Name</td>
               <td>:</td>
               <?php
                  $result = $myObj->retrieveAllConsole();
                  foreach($result as $row){
                     $tempRowData = $row['console'];
                     echo "<td>" . $tempRowData . "</td>";
                     echo "<td><input name=consolename type=radio value=\"" . $tempRowData . "\"></td>";
                  }
               ?> 
            </tr>
            <tr>
               <td>Genre Type</td>
               <td>:</td>
               <?php         
                  $result = $myObj->retrieveAllGenre();
                  foreach($result as $row){
                     $tempRowData = $row['genre'];
                     echo "<td>" . $tempRowData . "</td>";
                     echo "<td><input name=genre[] type=checkbox value=" . $tempRowData . "></td>";
                  }
               ?>
            </tr>
            <tr>
               <td>Rating</td>
               <td>:</td>
               <?php         
                  $result = $myObj->retrieveAllRating();
                  foreach($result as $row){
                     $tempRowData = $row['rating'];
                     echo "<td>" . $tempRowData . "</td>";
                     echo "<td><input name=rating type=radio value=" . $tempRowData . "></td>";
                  }
               ?>
            </tr>
            <tr>
               <td>Release Date(Year-Month-Day)</td>
               <td>:</td>
               <td><input name="date" type="date"></td>
            </tr>
            <tr>
               <td><input type="submit" name="Submit" value="Submit"></td>
               <td><input type="submit" name="Cancel" value="Cancel"></td>
            </tr>
         </table>
      </form>
   </body>
</html>
