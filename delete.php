<?php                       //_GET is used to collect form data after submitting an HTML form with method="get"
if ( isset($_GET["id"]) ) { //_GET is a super global variables are always available in all scopes
    $id = $_GET["id"];      //_GET can also collect data sent in the URL

    $servername = "localhost";
    $username = "root";
    $password = "1234";
    $database = "mydb";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    $sql = "DELETE FROM mydb.myguests WHERE id=$id";    //vælger id og sletter then valgte id
    $conn->query($sql);
}

header("location: index.php");  //sender brugeren til index.php 
exit;   //terminates script
?>