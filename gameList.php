<!DOCTYPE HTML>
<html>
   <?php
      include 'DB.php';

      $myObj = new myDB();

   ?>
   <head>
      <h1> My Video Game </h1>
   </head>
   <body>
      <table>
         <tr>
            <td>Game Title</td>
            <td>Console</td>
            <td>Genre</td>
            <td>Release Date</td>
            <td>Rating</td>
         </tr>
      <?php
         $result = $myObj->retrieveAllGames("DESC");
         
         for($i = 0; $i < count($result); $i++){
            $row = $result[$i];
            echo "<tr>";
            echo "<td>" . $row['Title'] . "</td>";
            echo "<td>" . $row['Console'] . "</td>";
            echo "<td>" . $row['Genre'] . "</td>";
            echo "<td>" . $row['ReleaseDate'] . "</td>";
            echo "<td>" . $row['Rating'] . "</td>";
            echo "</tr>";

         }
      ?>
      </table>
   </body>
</html>
