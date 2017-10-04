<?php
   class myDB {
      private $conn;
      public function __construct(){
         include ('connectionCred.php');
        	try {
    			$this->conn = new PDO("mysql:host=$serverName;dbname=$database", $userName, $password);
    			// set the PDO error mode to exception
    			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    		}
			catch(PDOException $e) {
    			echo "Connection failed: " . $e->getMessage();
    		}
      }
		public function displayGenreTypeinInputTag($outerBeginTag, $outerEndTag, $inputType){
         $stmt = $this->conn->prepare("SELECT genre FROM Genres");
         $stmt->execute();
         $result = $stmt->fetchAll();

         foreach($result as $row){
            //echo $row['genre'];
            $tempRowData = $row['genre'];
            echo "$outerBeginTag$tempRowData$outerEndTag";
            echo "$outerBeginTag<input name=genre[] type=$inputType value=$tempRowData>$outerEndTag";  
         }

      }

      public function enterData($gameName, $consoleName, $genre, $releaseDate, $rating){
         $stmt = $this->conn->prepare("INSERT INTO Games (Title, Console, ReleaseDate, Rating) 
            VALUES (:Title, :Console, :ReleaseDate, :Rating)");
         $stmt->bindParam(':Title', $gameName);
         $stmt->bindParam(':Console', $consoleName);
         $test = '1999-01-01';
         $stmt->bindParam(':ReleaseDate', $test);
         $stmt->bindParam(':Rating', $rating);
         $stmt->execute();
         $stmt = $this->conn->prepare("INSERT INTO GameGenre (Title, Genre) 
            VALUES (:Title, :Genre)");
         $stmt->bindParam(':Title', $gameName);
         for($i=0; $i < count($genre); $i++){
            $stmt->bindParam(':Genre', $genre[$i]);
            $stmt->execute();
         }
      }
      
      public function displayAllGames($direction){
         /*$stmt = $this->conn->prepare("SELECT Title, Console, ReleaseDate, Rating From Games ORDER BY Title :Direction");
         $stmt->bindParam(':Direction', $direction);
         $stmt->execute();
         $result = $stmt->fetchAll();

         foreach($result as $row){
            $stmt = $this->conn->prepare("SELECT Genre From GameGenre WHERE Title=:Title");
            $stmt->bindParam(':Title', $row['Title']);
            $stmt->execute();
            $newResult = $stmt->fetchAll();
            $allGenre = "";
            for($newResult as $newRow){
               $allGenre = $allGenre + ', ' + $newRow['genre']; 
            }
         }*/
      }
   }
?>
