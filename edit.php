<?php
    $servername = "localhost"; //localhost
    $username = "root";
    $password = "1234";
    $database = "mydb";

    //Create conn
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo "Connected successfully";

    $id = "";
    $firstname = "";
    $lastname = "";
    $email = "";

    $errorMessage = "";
    $successMessage = "";

    if ($_SERVER['REQUEST_METHOD'] == 'GET') { //reads the id of the client

        if (!isset($_GET["id"]) ) { //if id does not exist, redirects user to index.php
            header("location: index.php");
            exit;
        }

        $id = $_GET["id"];

        $sql = "SELECT * FROM myguests WHERE id=$id";  //reads data of the client having id=$id
        $result = $conn->query($sql);                       //executes sql query
        $row = $result->fetch_assoc();                      //reads the data from the client from the database

        if (!$row) { //if no data from database, redirects user to index.php
            header("location: index.php");
            exit;
        }

        $firstname = $row["firstname"]; //stores the data from the database into these 4 variables. already displayed into the form
        $lastname = $row["lastname"];
        $email = $row["email"];

    } else {
        //POST method updates the data
        $id = $_POST["id"];
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $email = $_POST["email"];

        do {    //repeats the block of code once, checks the conditions again if true
            if ( empty($id) || empty($firstname) || empty($lastname) || empty($email)) {   //må skrive firstname, lastname og email for at forsætte
                $errorMessage = "All fields are required";
                break;
            }
            $sql = "UPDATE mydb.myguests /*updates the data of the guest */ 
            SET firstname='$firstname', lastname='$lastname', email='$email' 
            WHERE id = $id";   //updates the specific guest

            $result = $conn->query($sql);   //executes query

            if (!$result) { //checks if query has been executed correctly
                $errorMessage = "Invalid query: " . $conn->error; //prints error
                break;  //breaks out of the loop
            }

            $successMessage = "Client added"; //displays if query is executed correctly

            header("location: index.php");  //redirects user to index.php
            exit;   //exits execution of this file

        } while (false);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container my-5">
        <h2>Edit guest</h2>

        <?php
        if (!empty($errorMessage)) {    //if $errorMessage is not empty, display message
            echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>$errorMessage</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            ";
        }
        ?>

        <?php
        if (!empty($successMessage)) {  //if $successMessage is not empty, display message
            echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>$successMessage</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            ";
        }
        ?>
        
        <form method="post"> <?php //http post sends data to the server?>
            <input type="hidden" name="id" value="<?php echo $id; ?>">

            <div class="row mb-3">  <?php //firstname input?>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="firstname" value="<?php echo $firstname; ?>" placeholder="Firstname"> 
                </div>
            </div>

            <div class="row mb-3">  <?php //lastname input?>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="lastname" value="<?php echo $lastname; ?>" placeholder="Lastname">   
                </div>
            </div>

            <div class="row mb-3">  <?php //email input?>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="email" value="<?php echo $email; ?>" placeholder="Email"> 
                </div>
            </div>

            <div class="row mb-1">  <?php //submit button?>
                <div class="col-sm-1 d-grid">
                    <button type="submit" class="btn btn-primary">submit</button>
                </div>
                <div class="col-sm-1 d-grid">
                    <a class="btn btn-outline-primary" href="index.php" role="button">cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>