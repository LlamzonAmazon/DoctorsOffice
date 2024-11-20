<?php
    include 'connectDB.php';

    // Check if a POST request was made
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['ohip']) && !empty($_POST['ohip'])) {
            // Used to filter bad strings in a query that can be used in a vulnerable query.
	    // A DELETE FROM query can be exploited for malicious purposes and this function prevents that.
	    $ohip = mysqli_real_escape_string($connection, $_POST['ohip']);

            // Query to delete the patient with the given OHIP
            $query = "DELETE FROM patient WHERE ohip='$ohip'";
            $result = mysqli_query($connection, $query);

            if ($result) {
                // Check if any row was deleted
                if (mysqli_affected_rows($connection) > 0) {
                    echo "Patient with OHIP $ohip has been successfully deleted.";
                } else {
                    echo "No patient found with OHIP $ohip.";
                }
            } else {
                echo "Error: " . mysqli_error($connection);
            }
        } else {
            echo "Error: OHIP field is required.";
        }
    } else {
        echo "Invalid request.";
    }
?>
