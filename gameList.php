<!DOCTYPE HTML>
<html>
   <?php
      include 'DB.php';

      $editSet = false;
      $myObj = new myDB();


      if(isset($_POST['addGame'])){
         header("location:addGame.php");
      }
      if(isset($_POST['updateGame'])){
         $editSet = true;
      }
      if(isset($_POST['deleteGame'])){
         $tempArr = $_POST['modifyGame'];
         for($i = 0; $i < count($tempArr); $i++){
            $myObj->deleteData($tempArr[$i]);
         }
      }
      $result = $myObj->retrieveAllGames("DESC");
   ?>
   <head>
      <h1> My Video Game </h1>
   </head>
   <body>
      <form name="form1" method="post" action="gameList.php" target="_self">
         <?php
            if($editSet == false){
               echo "<input type=submit name=addGame value=Add Game>";
               echo "<input type=submit name=updateGame value=Update Game>";
            }else{
               echo "<input type=submit name=editGame value=Edit Game>";
               echo "<input type=submit name=deleteGame value=Delete Game>";
            }
         ?>
         <table>
            <tr>
               <?php
                  if($editSet == true)echo "<td></td>";
               ?>
               <td>Game Title</td>
               <td>Console</td>
               <td>Genre</td>
               <td>Release Date</td>
               <td>Rating</td>
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
