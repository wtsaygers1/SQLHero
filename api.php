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

switch ($route) {
  case "getAllHeroes":
    $myData = getAllHeroes($conn);
    break;
  case "getHeroById":
    $heroId = $_GET['hero_id'];
    $myData = getHeroById($conn, $heroId);
    break;
  case "addHeroToTable":
    $name = $_GET['name'];
    $about_me = $_GET['about_me'];
    $biography = $_GET['biography'];
    $myData = addHeroToTable($conn, $name, $about_me, $biography, '');
    break;
  case "deleteHeroFromTable":
    $id = $_GET['id'];
    $name = $_GET['name'];
    $about_me = $_GET['about_me'];
    $biography = $_GET['biography'];
    $myData = deleteHeroFromTable($conn, $id, $name, $about_me, $biography, '');
    break;
  case "updateHeroAbility":
    $id = $_GET['id'];
    $ability = $_GET['ability'];
    $myData = updateHeroAbility($conn, $id, $ability);
    break;
  default:
    $myData = json_encode([]);   
}

echo $myData;

$conn->close();

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

function getHeroById($conn, $heroId){
   $data=array();

    $sql = "SELECT * FROM heroes WHERE id = " . $heroId;
    $result = $conn->query($sql);
    
    if($result->num_rows > 0){
      while($row = $result->fetch_assoc()){
        array_push($data,$row);
      }
    }
      return json_encode($data);
 }

function addHeroToTable($conn, $name, $about_me, $biography, $img){
  
  $sql = "INSERT INTO heroes (name, about_me, biography, image_url)
  VALUES ('$name', '$about_me', '$biography', '$img')";
  
  if ($conn->query($sql) === TRUE){
    $newHero = "('success':'created new hero')";
  } else {
    echo "{'error': '" . $sql . " - " . $conn->error . "'}";
  }
  
  return json_encode([$name]);
}

function deleteHeroFromTable($conn, $id, $name, $about_me, $biography, $img){
  
  $sql = "DELETE FROM heroes WHERE id=$id";
    
    if ($conn->query($sql) === TRUE){
    echo "Record deleted successfully";
  } else {
    echo "Error deleting record: " . $conn->error;
  }
  
  return json_encode([$name]);
}

function updateHeroAbility($conn, $id, $ability){
  
  $sql = "UPDATE abilities SET ability=$ability WHERE id=$id";

  if($conn->query($sql) === TRUE){
    echo "Record updated successfully";
  } else {
    echo "Error updating record: " . $conn->error;
  }

    return json_encode([$ability]);
}
?>