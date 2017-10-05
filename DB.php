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
      
      public function retrieveAllGames($direction){
         if($direction == 'DESC'){
            $stmt = $this->conn->prepare("SELECT Title, Console, ReleaseDate, Rating From Games ORDER BY Title DESC");
         }else{
            $stmt = $this->conn->prepare("SELECT Title, Console, ReleaseDate, Rating From Games ORDER BY Title ASC");
         }
         $stmt->execute();
         $result = $stmt->fetchAll();
         $i = 0; 

         foreach($result as $row){
            $stmt = $this->conn->prepare("SELECT Genre From GameGenre WHERE Title=:Title");
            $stmt->bindParam(':Title', $row['Title']);
            $stmt->execute();
            $newResult = $stmt->fetchAll();
            $allGenre = "";
            foreach($newResult as $newRow){
               $data = $newRow['Genre'];
               if($allGenre != ""){
                  $allGenre = "$allGenre, $data"; 
               }else{
                  $allGenre = $data;
               }
            }
            $returnData[$i] = array("Title" => $row['Title'], "Console" => $row['Console'], "Genre" => $allGenre, 
               "ReleaseDate" => $row['ReleaseDate'], "Rating" => $row['Rating']);
         }
         return $returnData;
      }
   }
?>
