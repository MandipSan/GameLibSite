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
         }
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
               <td>Playstation </td>
               <td><input name="consolename" type="radio" value="Playstation"></td>
               <td>Playstation 2</td>
               <td><input name="consolename" type="radio" value="Playstation2"></td>
               <td>Playstation 3</td>
               <td><input name="consolename" type="radio" value="Playstation3"></td>
               <td>Playstation 4</td>
               <td><input name="consolename" type="radio" value="Playstation4" checked></td>
               <td>XBox </td>
               <td><input name="consolename" type="radio" value="XBox"></td>
               <td>XBox360 </td>
               <td><input name="consolename" type="radio" value="XBox360"></td>
               <td>XBoxOne </td>
               <td><input name="consolename" type="radio" value="XBoxOne"></td>
            </tr>
            <tr>
               <td>Genre Type</td>
               <td>:</td>
               <?php         
                  $myObj->displayGenreTypeinInputTag("<td>","</td>","checkbox");
               ?>
            </tr>
            <tr>
               <td>Rating</td>
               <td>:</td>
               <td>Teen</td>
               <td><input name="rating" type="radio" value="Teen" checked></td>
            </tr>
            <tr>
               <td>Release Date</td>
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
