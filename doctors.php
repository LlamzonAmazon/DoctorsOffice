<!DOCTYPE html>
<html>
<head>
    <title>Patients</title>
    <style> <?php include 'style.css'; ?> </style>
</head>
<body>
    <h1>DOCTOR & NURSE DATA</h1>
    <form action="mainmenu.php" method="post">
        <input type="submit" value="Back to Main Menu">
    </form><br>

    <?php include 'connectDB.php'; ?>

    <!-- LIST DOCTORS WITH NO PATIENTS -->
    <h2>DOCTORS WITH NO PATIENTS</h2>

    <?php
        # Query to fetch doctors with no patients
        $query = "SELECT d.docid, d.firstname, d.lastname
                  FROM doctor d
                  LEFT JOIN patient p ON d.docid=p.treatsdocid
                  WHERE p.treatsdocid IS NULL";
        $result = mysqli_query($connection, $query);

        # Display doctors with no patients
        if ($result) {
            echo "<table border='1'>";
            echo "<thead><tr><th>Doctor ID</th><th>First Name</th><th>Last Name</th></tr></thead>";
            echo "<tbody>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['docid'] . "</td>";
                echo "<td>" . $row['firstname'] . "</td>";
                echo "<td>" . $row['lastname'] . "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($connection);
        }
    ?>

    <!-- LISTS DOCTORS AND THEIR PATIENTS -->
    <h2>DOCTORS AND THEIR PATIENTS</h2>

    <?php
        # Query to fetch doctors and their patients
        $query = "SELECT d.firstname AS df, d.lastname AS dl, p.firstname AS pf, p.lastname AS pl
                  FROM doctor d
                  JOIN patient p ON d.docid=p.treatsdocid";
        $result = mysqli_query($connection, $query);

        # Display doctors with no patients
        if ($result) {
            echo "<table border='1'>";
            echo "<thead><tr>
                <th>Doctor First Name</th>
                <th>Doctor Last Name</th>
                <th>Patient First Name</th>
                <th>Patient Last Name</th>
            </tr></thead>";
            echo "<tbody>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['df'] . "</td>";
                echo "<td>" . $row['dl'] . "</td>";
                echo "<td>" . $row['pf'] . "</td>";
                echo "<td>" . $row['pl'] . "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($connection);
        }
    ?>

    <!-- NURSE INFO -->
    <h2>NURSE INFO</h2>

    <form id="searchForm" method="POST">
        <label for="nurseID">Nurse ID:</label>
        <select id="nurseID" name="nurseID">
            <?php
            # Query to fetch nurse IDs and names
            $query = "SELECT nurseid, firstname FROM nurse";
            $result = mysqli_query($connection, $query);
            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<option value="' . $row['nurseid'] . '">' . $row['nurseid'] . ' ' . $row['firstname'] . '</option>';
                }
            } else {
                echo "Error: " . $query . "<br>" . mysqli_error($connection);
            }
            ?>
        </select><br>
        <input type="submit" value="Search">
    </form>

    <?php
    if (isset($_POST['nurseID'])) {
        // Retrieve the selected nurse ID from the form
        $nurseID = $_POST['nurseID'];

        // Query to fetch nurse, doctor, and hours data
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
    }
    ?>


<footer><div style="height: 150px;"></div></footer>


</body>
</html>
