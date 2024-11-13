<!DOCTYPE html>
<html>
<head>
<title>TL A3 Webpage</title>
</head>
<body>
<?php # Connect to the database
    $dbhost = "localhost";
    $dbuser= "root";
    $dbpass = "cs3319";
    $dbname = "assign2db";
    $connection = mysqli_connect($dbhost, $dbuser,$dbpass,$dbname);
    if (mysqli_connect_errno()) {
        die("database connection failed :" .
        mysqli_connect_error() .
        "(" . mysqli_connect_errno() . ")"
        );
    }
?>
    <h1>Manage Doctor's Office Database</h1>
    <form action="redirect.php" method="post">
        <input type="submit" name="access" value="ACCESS PATIENT DATA">
        <input type="submit" name="access" value="ACCESS DOCTOR DATA">
    </form>

<?php
    // Check if the form was submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if ($_POST['access'] == 'ACCESS PATIENT DATA') {
            // Redirect to patient.php
            header("Location: patients.php");
            exit;
        } elseif ($_POST['access'] == 'ACCESS DOCTOR DATA') {
            // Redirect to doctor.php
            header("Location: doctors.php");
            exit;
        }
    }
?>
</body>
</html>