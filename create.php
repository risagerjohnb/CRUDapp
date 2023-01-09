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

    $firstname="";
    $lastname="";
    $email="";

    $errorMessage = "";
    $successMessage = "";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') { //if the data has been transmitted by the post method, then the data can initialize
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $email = $_POST["email"];

        do {    //repeats the block of code once, checks the conditions again if true
            if (empty($firstname) || empty($lastname) || empty($email)) {   //må skrive firstname, lastname og email for at forsætte
                $errorMessage = "All fields are required";
                break;
            }

            //add new client to database
            $sql = "INSERT INTO mydb.myguests (firstname, lastname, email) 
                    VALUES ('$firstname', '$lastname', '$email')";
            $result = $conn->query($sql); //executes query

            if (!$result) { //checks if query has been executed correctly
                $errorMessage = "Invalid query: " . $conn->error; //prints error
                break;  //breaks out of the loop
            }
            

            $firstname="";  
            $lastname="";
            $email="";

            $successMessage = "Client added";   //if client is successfully added

            header("location: index.php"); //forwards the user to the database
            exit;

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
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container my-5" id="register">
        <h2>Register your hotel guest</h2>

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

            <div class="row mb-3">  <?php //firstname input?>
                <div class="col-sm-5">
                    <input type="text" placeholder="Firstname" class="form-control" name="firstname" value="<?php echo $firstname; ?>"> 
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

            <div class="row mb-1" id="submit">  <?php //submit button?>
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