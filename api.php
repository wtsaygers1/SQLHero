<?php
$servername = "localhost";
$username = "root";
$password = "CApassWurd_dunE";
$dbname = "Hero";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$route = $_GET['route'];

if ($route === 'getAllHeroes'){
  $myData = getAllHeroes($conn);
  echo $myData;
} 

function getAllHeroes($conn){
  $data=array();
  
  $sql = "SELECT * FROM heroes";
  $result = $conn->query($sql);
  
  if($result->num_rows > 0){
    while($row = $result->fetch_assoc()) {
      array_push($data,$row);
    }
  }
  return json_encode($data);
}
    
$conn->close(); 
   
?>