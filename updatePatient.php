<?php
    // Code for updating the patient weight
    include 'connectDB.php';

    // Check if the request method is POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate and sanitize input
        if (isset($_POST['ohip'], $_POST['weight'], $_POST['units'])) {
            $ohip = mysqli_real_escape_string($connection, $_POST['ohip']);
            $weight = floatval($_POST['weight']);
            $units = $_POST['units'];

            // weight value must be positive
            if ($weight <= 0) {
                echo "Invalid weight value.";
                exit;
            }

            // If units are in lbs, convert to kg
            if ($units === "lbs") {
                $weight = $weight * 0.45; // 1lb = 0.45kg
            }

            // Update the patient's weight in the database
            $query = "UPDATE patient SET weight='$weight' WHERE ohip='$ohip'";
            $result = mysqli_query($connection, $query);

            if ($result) {
                // Check if any rows were updated
                if (mysqli_affected_rows($connection) > 0) {
                    echo "Patient's weight has been successfully updated to $weight kg.";
                } else {
                    echo "Patient (OHIP $ohip) weight not updated.";
                }
            } else {
                echo "Error: " . mysqli_error($connection);
            }
        } else {
            echo "Error: All fields are required.";
        }
    } else {
        echo "Invalid request method.";
    }
?>
