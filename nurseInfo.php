<?php
// Code to display nurse information given the nurseID chosen by the user.
include 'connectDB.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['nurseID'])) {
    $nurseID = $_POST['nurseID'];

    $query = "SELECT n.firstname AS nurse_firstname, n.lastname AS nurse_lastname, 
                    d.firstname AS doctor_firstname, d.lastname AS doctor_lastname, w.hours
            FROM nurse n
            JOIN workingfor w ON n.nurseid = w.nurseid
            JOIN doctor d ON w.docid = d.docid
            WHERE n.nurseid = '$nurseID'";

    $result = mysqli_query($connection, $query);

    if ($result) {
        echo "<table border='1'>";
        echo "<thead><tr>
                <th>Nurse First Name</th>
                <th>Nurse Last Name</th>
                <th>Doctor First Name</th>
                <th>Doctor Last Name</th>
                <th>Hours</th>
            </tr></thead>";
        echo "<tbody>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['nurse_firstname'] . "</td>";
            echo "<td>" . $row['nurse_lastname'] . "</td>";
            echo "<td>" . $row['doctor_firstname'] . "</td>";
            echo "<td>" . $row['doctor_lastname'] . "</td>";
            echo "<td>" . $row['hours'] . "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($connection);
    }

    exit;
}
?>
