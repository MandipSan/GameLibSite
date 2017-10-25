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

		public function retrieveAllGenre(){
         $stmt = $this->conn->prepare("SELECT genre FROM Genres");
         $stmt->execute();
         $result = $stmt->fetchAll();

         return $result;
      }

      public function retrieveAllConsole(){
         $stmt = $this->conn->prepare("SELECT console FROM Console");
         $stmt->execute();
         $result = $stmt->fetchAll();

         return $result;
      }

      public function retrieveAllRating(){
         $stmt = $this->conn->prepare("SELECT rating FROM Rating");
         $stmt->execute();
         $result = $stmt->fetchAll();

         return $result;
      }

      public function enterData($gameName, $consoleName, $genre, $releaseDate, $rating){
         $stmt = $this->conn->prepare("INSERT INTO Games (Title, Console, ReleaseDate, Rating) 
            VALUES (:Title, :Console, :ReleaseDate, :Rating)");
         $stmt->bindParam(':Title', $gameName);
         $stmt->bindParam(':Console', $consoleName);
         $stmt->bindParam(':ReleaseDate', $releaseDate);
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
      
      public function retrieveAllGames($orderByCol, $orderByDir, $consoleIn, $genreIn, $ratingIn){
         $orderByStmt = "ORDER BY " . $orderByCol . " " . $orderByDir;
         $setAnd = "";
         if(!empty($consoleIn)){
            $consoleInStmt = "Console IN ( " . implode(",",$consoleIn) . ")";
            $setAnd = "AND";
         }else{
            $consoleInStmt = "";
         }
         if(!empty($genreIn)){
            $genreInStmt = $setAnd . " Genre IN ( " . implode(",",$genreIn) . ")";
            $setAnd = "AND";
         }else{
            $genreInStmt = "";
         }
         if(!empty($ratingIn)){
            $ratingInStmt = $setAnd . "Rating IN ( " . implode(",",$ratingIn) . ")";
         }else{
            $ratingInStmt = "";
         }
         if($consoleInStmt != "" || $genreInStmt != "" || $ratingInStmt != ""){
            $stmt = $this->conn->prepare("SELECT Title, Console, ReleaseDate, Rating FROM Games WHERE " . $consoleInStmt . $genreInStmt . $ratingIn . $orderByStmt);
         }else{
            $stmt = $this->conn->prepare("SELECT Title, Console, ReleaseDate, Rating FROM Games " . $orderByStmt);
         }

         $stmt->execute();
         $result = $stmt->fetchAll();
         $i = 0; 

         foreach($result as $row){
            $allGenre = $this->retrieveGameGenres($row['Title']);
            $returnData[$i] = array("Title" => $row['Title'], "Console" => $row['Console'], "Genre" => $allGenre, 
               "ReleaseDate" => $row['ReleaseDate'], "Rating" => $row['Rating']);
            $i++;
         }
         return $returnData;
      }

      public function retrieveGame($gameName){
         $stmt = $this->conn->prepare("SELECT Console, ReleaseDate, Rating FROM Games WHERE Title=:Title");
         $stmt->bindParam(':Title', $gameName);
         $stmt->execute();
         $result = $stmt->fetchAll();
         $row = $result[0];
         $genre = $this->retrieveGameGenres($gameName);
         $returnData = array("Console" => $row['Console'], "Genre" => $genre, 
            "ReleaseDate" => $row['ReleaseDate'], "Rating" => $row['Rating']);
         return $returnData;
      }

      public function deleteData($gameName){
         $stmt = $this->conn->prepare("DELETE FROM Games WHERE Title = :Title");
         $stmt->bindParam(':Title', $gameName);
         $stmt->execute();
      }

      public function editData($gameName, $consoleName, $genre, $releaseDate, $rating){
         $stmt = $this->conn->prepare("UPDATE Games SET Console = :Console, ReleaseDate = :ReleaseDate, Rating = :Rating
            WHERE Title = :Title");
         $stmt->bindParam(':Title', $gameName);
         $stmt->bindParam(':Console', $consoleName);
         $stmt->bindParam(':ReleaseDate', $releaseDate);
         $stmt->bindParam(':Rating', $rating);
         $stmt->execute();

         $stmt = $this->conn->prepare("SELECT Genre FROM GameGenre WHERE Title = :Title");
         $stmt->bindParam(':Title', $gameName);
         $stmt->execute();
         $result = $stmt->fetchAll();

         $stmt = $this->conn->prepare("DELETE FROM GameGenre WHERE Title = :Title AND Genre = :Genre");
         $stmt->bindParam(':Title', $gameName);
         foreach($result as $newRow) {
            if(!in_array($newRow['Genre'], $genre)){
               $stmt->bindParam(':Genre', $newRow['Genre']);
               $stmt->execute();
            }else{
               $key = array_search($newRow['Genre'],$genre);
               unset($genre[$key]);
            }
         }
         $genre = array_values($genre);
         
         $stmt = $this->conn->prepare("INSERT INTO GameGenre (Title, Genre) 
            VALUES (:Title, :Genre)");
         $stmt->bindParam(':Title', $gameName);
         for($i=0; $i < count($genre); $i++){
            $stmt->bindParam(':Genre', $genre[$i]);
            $stmt->execute();
         }
      }

      private function retrieveGameGenres($gameName){
         $stmt = $this->conn->prepare("SELECT Genre FROM GameGenre WHERE Title = :Title");
         $stmt->bindParam(':Title', $gameName);
         $stmt->execute();
         $newResult = $stmt->fetchAll();
         $allGenre = "";
         foreach($newResult as $newRow => $data){
            if($allGenre != ""){
               $allGenre = $allGenre . ", " . $data['Genre']; 
            }else{
               $allGenre = $data['Genre'];
            }
         }
         return $allGenre;
      }
   }
?>


