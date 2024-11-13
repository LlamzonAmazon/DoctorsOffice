<!DOCTYPE html>
<html>
<head>
    <title>Patients</title>
    <script src="pageFunctions.js"></script>
</head>
<body>
<?php
    # Connect to the database
    $dbhost = "localhost";
    $dbuser= "root";
    $dbpass = "cs3319";
    $dbname = "assign2db";
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    if (mysqli_connect_errno()) {
        die("Database connection failed: " . mysqli_connect_error() . " (" . mysqli_connect_errno() . ")");
    }

    # Determine the sorting order and direction
    $sortOrder = isset($_GET['sort']) && $_GET['sort'] == 'lastname' ? 'p.lastname' : 'p.firstname';
    $direction = isset($_GET['direction']) && $_GET['direction'] == 'DESC' ? 'DESC' : 'ASC';

    # Query to fetch patient data based on the selected sort order and direction
    $query = "SELECT SELECT p.firstname AS patient_firstname, 
                p.lastname AS patient_lastname, 
                p.height, 
                p.weight, 
                d.firstname AS doctor_firstname, 
                d.lastname AS doctor_lastname 
              FROM patient p 
              JOIN doctor d ON p.treatsdocid=d.docid 
              ORDER BY $sortOrder $direction";
    $result = mysqli_query($connection, $query);
?>
    <h1>PATIENT DATA</h1>
    
    <!-- Form for sorting by first name or last name -->
    <form id="sortForm">
        <input type="radio" name="sort" value="p.firstname" <?php if ($sortOrder == 'p.firstname') echo 'checked'; ?>> by first name<br>
        <input type="radio" name="sort" value="p.lastname" <?php if ($sortOrder == 'p.lastname') echo 'checked'; ?>> by last name<br>
    </form>
    
    <!-- Form for sorting direction: ascending or descending -->
    <form id="directionForm">
        <input type="radio" name="direction" value="ASC" <?php if ($direction == 'ASC') echo 'checked'; ?>> ascending<br>
        <input type="radio" name="direction" value="DESC" <?php if ($direction == 'DESC') echo 'checked'; ?>> descending<br>
    </form>
    
    <input type="button" value="List Patient Data" onclick="sortData()">
    

<table border="1" id="patientTable">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Height (m)</th>
                <th>Weight (kg)</th>
                <th>Doctor First Name</th>
                <th>Doctor Last Name</th>
            </tr>
        </thead>
        <tbody>
<?php
    # Display patient data
    if ($result) {
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>" . $row["p.firstname"] .
            "</td><td>" . $row["p.lastname"] .
            "</td><td>" . $row["height"] .
            "</td><td>" . $row["weight"] .
            "</td><td>" . $row["d.firstname"] .
            "</td><td>" . $row["d.lastname"] . "</td></tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($connection);
    }

    # Free result set
    mysqli_free_result($result);

    # Close database connection
    mysqli_close($connection);
?>
</body>
</html>
