<!DOCTYPE HTML>
<html>	
   <?php
      include 'DB.php';

      $myObj = new myDB();

      if(isset($_POST['Submit'])){
         $arr = $_POST['genre'];
         $myObj->enterData($_POST['gamename'], $_POST['consolename'], $arr, $_POST['date'], $_POST['rating']);
         header("location:gameList.php");
      }
      if(isset($_POST['Cancel'])){
         header("location:gameList.php");
      }
   ?>
   <script type="text/javascript" src="formValidator.js"></script>
   <head>
      <link rel="stylesheet" type="text/css" href="pageStyle.css">
      <h1> Add Video Game </h1>
   </head>
   <body>
      <form name="form1" method="post" action="addGame.php" target="_self" >
         <table>
            <tr>
               <td>Game Name</td>
               <td>:</td>
               <td><input name="gamename" type="text"></td>
            </tr>
            <tr class="addPageOption">
               <td>Console Name</td>
               <td>:</td>
               <?php
                  $result = $myObj->retrieveAllConsole();
                  foreach($result as $row){
                     $tempRowData = $row['console'];
                     echo "<td>" . $tempRowData . "<input name=consolename type=radio value=\"" . $tempRowData . "\" checked></td>";
                  }
               ?> 
            </tr>
            <tr class="addPageOption">
               <td>Genre Type</td>
               <td>:</td>
               <?php         
                  $result = $myObj->retrieveAllGenre();
                  foreach($result as $row){
                     $tempRowData = $row['genre'];
                     echo "<td>" . $tempRowData . "<input name=genre[] type=checkbox value=\"" . $tempRowData . "\"></td>";
                  }
               ?>
            </tr>
            <tr class="addPageOption">
               <td>Rating</td>
               <td>:</td>
               <?php         
                  $result = $myObj->retrieveAllRating();
                  foreach($result as $row){
                     $tempRowData = $row['rating'];
                     echo "<td>" . $tempRowData . "<input name=rating type=radio value=\"" . $tempRowData . "\" checked></td>";
                  }
               ?>
            </tr>
            <tr>
               <td>Release Date(Year-Month-Day)</td>
               <td>:</td>
               <td><input name="date" type="date"></td>
            </tr>
            <tr>
               <td><input type="submit" name="Submit" value="Submit" onclick="return singleValidator('form1','');" ></td>
               <td><input type="submit" name="Cancel" value="Cancel"></td>
            </tr>
         </table>
      </form>
   </body>
</html>
