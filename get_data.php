<?php


// Create connection
require_once ("./includes/config.php");
$conn = new mysqli($host, $user, $pass, $database);

$APIid = $_GET["APIid"];
header("Access-Control-Allow-Origin: *");

mysqli_set_charset( $conn, 'utf8');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//  get all post 
if($APIid == 1){
    $last_data= $_GET["last_date"];
    $sql ="";
    if ($last_data==0){ //if its first page load
        $sql = "SELECT * FROM `tbl_news`  ORDER BY news_date DESC LIMIT 3";
    }else{ // if someone scroll to end of page
        
        $sql = "SELECT * FROM `tbl_news` WHERE news_date<'$last_data' ORDER BY news_date DESC LIMIT 3";
    }
    $result = $conn->query($sql);
    $data = array();
    while($row = $result->fetch_assoc()) {
        array_push($data,$row);
    }
    print_r(json_encode($data));    
}


//  get category
if($APIid == 2){
    $sql = "SELECT * FROM `tbl_category`";
    $result = $conn->query($sql);
    $data = array();
    while($row = $result->fetch_assoc()) {
        array_push($data,$row);
    }
    print_r(json_encode($data));    
}

//  get post by category
if($APIid == 3){
    $last_data= $_GET["last_date"];
    $catId = $_GET["catId"];
   
    $sql ="";
    
    if ($last_data==0){ //if its first page load
        $sql = "SELECT * FROM `tbl_news` WHERE cat_id= $catId  ORDER BY news_date DESC LIMIT 3";
    }else{ // if someone scroll to end of page
       $sql = "SELECT * FROM `tbl_news` WHERE cat_id= $catId and news_date<'$last_data' ORDER BY news_date DESC LIMIT 3";
    }
    $result = $conn->query($sql);
    $data = array();
    while($row = $result->fetch_assoc()) {
        array_push($data,$row);
    }
    print_r(json_encode($data));    
}



//  get post by id
if($APIid == 4){
    $nid = $_GET["nid"]  ;
    $sql = "SELECT * FROM `tbl_news` WHERE nid= $nid";
    $result = $conn->query($sql);
    $data = array();
    while($row = $result->fetch_assoc()) {
        array_push($data,$row);
    }
    print_r(json_encode($data));    
}



$conn->close();
?>