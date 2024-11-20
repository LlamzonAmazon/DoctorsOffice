<?php
    include 'connectDB.php';
    
    # Check if the form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        # Check if the form fields are set
        if (isset($_POST['ohip']) && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['height']) && isset($_POST['weight']) && isset($_POST['docid'])) {
            # Assign form data to variables
            $ohip = $_POST['ohip'];
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $height = $_POST['height'];
            $weight = $_POST['weight'];
            $docid = $_POST['docid'];

            # Check if the form fields are empty
            if (empty($ohip) || empty($firstname) || empty($lastname) || empty($height) || empty($weight) || empty($docid)) {
                echo "Error: All fields must be filled!";
            } else {
                # Query to check if OHIP already exists
                $query = "SELECT * FROM patient WHERE ohip='$ohip'";
                $result = mysqli_query($connection, $query);
                
                if (mysqli_num_rows($result) > 0) {
                    echo "Error: OHIP already exists!";
                } else {
                    # Query to insert a new patient
                    $query = "INSERT INTO patient (ohip, firstname, lastname, height, weight, treatsdocid) VALUES ('$ohip', '$firstname', '$lastname', '$height', '$weight', '$docid')";
                    # Use query to insert new patient into the database
                    $result = mysqli_query($connection, $query);

                    # Show if query succeeded or failed
                    if ($result) {
                        echo "New patient added successfully!";
                    } else {
                        echo "Error: " . $query . "<br>" . mysqli_error($connection);
                    }
                }
            }
        }
    }
?>
