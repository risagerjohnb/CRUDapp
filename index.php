<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <h2>List of Guests</h2>
        <a class="btn btn-primary" href="create.php" role="button">Login guest</a>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>firstname</th>
                    <th>lastname</th>
                    <th>email</th>
                    <th>registration date</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $servername = "localhost";
                $username = "root";
                $password = "1234";
                $database = "mydb";

                // Create connection
                $conn = new mysqli($servername, $username, $password, $database);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                echo "Connected successfully";

                $sql = "SELECT * FROM mydb.myguests";
                $result = $conn->query($sql);

                if (!$result) {
                    die("Invalid query: " . $conn->error);
                }

                while($row = $result->fetch_assoc()) {  //$row[] selects array of id
                    echo "
                    <tr>
                        <td>$row[id]</td>
                        <td>$row[firstname]</td>
                        <td>$row[lastname]</td>
                        <td>$row[email]</td>
                        <td>$row[reg_date]</td>
                        <td>
                            <a class='btn btn-primary btn-sm' href='edit.php?id=$row[id]'>Edit</a> 
                            <a class='btn btn-danger btn-sm' href='delete.php?id=$row[id]'>Delete</a>
                        </td>
                    </tr>
                    ";
                }

            ?>
            </tbody>
        </table>
    </div>
</body>
</html>