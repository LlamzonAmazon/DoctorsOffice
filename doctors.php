<!DOCTYPE html>
<html>
<!-- Code file for the structure of the doctors page accessible from the main menu. -->
<head>
    <title>Doctors</title>
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
        // Query to fetch doctors with no patients
        $query = "SELECT d.docid, d.firstname, d.lastname
                  FROM doctor d
                  LEFT JOIN patient p ON d.docid=p.treatsdocid
                  WHERE p.treatsdocid IS NULL";
        $result = mysqli_query($connection, $query);

        // Display doctors with no patients
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
        // Query to fetch doctors and their patients
        $query = "SELECT d.firstname AS df, d.lastname AS dl, p.firstname AS pf, p.lastname AS pl
                  FROM doctor d
                  JOIN patient p ON d.docid=p.treatsdocid";
        $result = mysqli_query($connection, $query);

        // Display doctors with no patients
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

    <!-- Create a dropdown menu to show nurses and their nurseid's -->
    <form id="searchForm">
        <label for="nurseID">Nurse ID:</label>
        <select id="nurseID" name="nurseID">
            <?php
		// PHP to get nurse names and ID's to display to the user
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
        <input type="button" value="Search" id="searchButton">
    </form>

    <div id="nurseInfo"></div>

    <script>
	// JavaScript to get the data once the user presses the search button
        document.getElementById('searchButton').addEventListener('click', function () {
            const formData = new FormData(document.getElementById('searchForm'));

            fetch('nurseInfo.php', { method: 'POST', body: formData })
                .then(response => response.text())
                .then(data => { document.getElementById('nurseInfo').innerHTML = data; })
                .catch(error => console.error('Error:', error));
        });
    </script>


    <?php
	// FREE RESULT SET
        mysqli_free_result($result);
        // DISCONNECT FROM DATABASE
        mysqli_close($connection);
    ?>
<footer><div style="height: 150px;"></div></footer>
</body>
</html>
