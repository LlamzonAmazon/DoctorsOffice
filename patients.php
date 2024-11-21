<!DOCTYPE html>
<html>
<head>
    <title>Patients</title>
    <style> <?php include 'style.css'; ?> </style>
</head>
<body>
    <h1>PATIENT DATA</h1>
    <p>Reload page to see changes.</p>
    <form action="mainmenu.php" method="post">
        <input type="submit" value="Back to Main Menu">
    </form><br>

    <?php include 'connectDB.php'; ?>

    <!-- LIST PATIENTS -->
    <h2>TABLE OF PATIENTS</h2>

    <form id="listArgs" method="GET">
        <input type="radio" name="sortOrder" value="p.firstname">First Name
        <input type="radio" name="sortOrder" value="p.lastname">Last Name
        <input type="radio" name="sortDir" value="ASC">Ascending
        <input type="radio" name="sortDir" value="DESC">Descending<br>
        <input type="submit" value="Sort">
    </form>

    <table border="1" id="patientTable">
        <thead>
            <tr>
                <th>OHIP</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Height (m)</th>
                <th>Weight (kg)</th>
                <th>Doctor ID</th>
                <th>Doctor First Name</th>
                <th>Doctor Last Name</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $sortOrder = 'patient_firstname';
                $sortDir = 'DESC';
                $sortOrder = isset($_GET['sortOrder']) ? $_GET['sortOrder'] : 'p.firstname'; // Default: sort by First Name
                $sortDir = isset($_GET['sortDir']) ? $_GET['sortDir'] : 'ASC'; // Default: Ascending

                $query = "SELECT p.ohip AS patient_ohip,
                            p.firstname AS patient_firstname,
                            p.lastname AS patient_lastname,
                            p.height,
                            p.weight,
                            d.docid AS doctor_docid,
                            d.firstname AS doctor_firstname,
                            d.lastname AS doctor_lastname
                        FROM patient p
                        JOIN doctor d ON p.treatsdocid=d.docid 
                        ORDER BY $sortOrder $sortDir";
                $result = mysqli_query($connection, $query);

                if ($result) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                                <td>" . $row["patient_ohip"] .
                                "</td><td>" . $row["patient_firstname"] .
                                "</td><td>" . $row["patient_lastname"] .
                                "</td><td>" . $row["height"] .
                                "</td><td>" . $row["weight"] .
                                "</td><td>" . $row["doctor_docid"] .
                                "</td><td>" . $row["doctor_firstname"] .
                                "</td><td>" . $row["doctor_lastname"] . "</td>
                            </tr>";
                    }
                } else {
                    echo "Error: " . $query . "<br>" . mysqli_error($connection);
                }
            ?>
        </tbody>
    </table>


    <!-- INSERT NEW PATIENT -->
    <h2>INSERT NEW PATIENT</h2>

    <form id="insertForm" method="post">
        <div><label for="ohip">OHIP:</label> <input type="text" name="ohip"></div>
        <div><label for="firstname">First Name:</label> <input type="text" name="firstname"></div>
        <div><label for="lastname">Last Name:</label> <input type="text" name="lastname"></div>
        <div><label for="height">Height (m):</label> <input type="text" name="height"></div>
        <div><label for="weight">Weight (kg):</label> <input type="text" name="weight"></div>
        <div><label for="docid">Doctor ID:</label> <input type="text" name="docid"></div>
        <input type="submit" id="submitBtn" value="Insert Patient">
    </form>

    <div id="response"></div>

    <script>
        document.getElementById('submitBtn').addEventListener('click', function () {
            const formData = new FormData(document.getElementById('insertForm'));

            fetch('insertPatient.php', {
                method: 'POST',
                body: formData,
            })
                .then(response => response.text())
                .then(data => {
                    document.getElementById('response').innerHTML = data;
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });

    </script>


    <!-- DELETE PATIENT -->
    <h2>DELETE PATIENT</h2>

    <form id="deleteForm" method="post">
        <div>
            <label for="ohip">OHIP:</label> 
            <input type="text" name="ohip">
        </div>
        <input type="button" id="deleteBtn" value="Delete Patient">
    </form>

    <div id="deleteResponse"></div>

    <script>
        document.getElementById('deleteBtn').addEventListener('click', function () {

            const confirmDelete = confirm("Are you sure you want to delete this patient?");
            
            if (confirmDelete) {
                const formData = new FormData(document.getElementById('deleteForm'));

                fetch('deletePatient.php', { method: 'POST', body: formData })
                    .then(response => response.text())
                    .then(data => { document.getElementById('deleteResponse').innerHTML = data; })
                    .catch(error => { console.error('Error:', error); });
            }
        });
    </script>


    <!-- UPDATE PATIENT -->
    <h2>UPDATE PATIENT WEIGHT</h2>
    <form id="updateForm" method="post">
        <div><label for="ohip">OHIP:</label> <input type="text" name="ohip"></div>
        <div><label>New Weight:</label> <input type="text" name="weight"></div>
        <div>
            <label>Units:</label>
            <input type="radio" name="units" value="kg">kg
            <input type="radio" name="units" value="lbs">lbs
        </div>
        <input type="submit" id="updateBtn" value="Update Patient">
    </form>

    <div id="updateResponse"></div>

    <script>
        document.getElementById('updateBtn').addEventListener('click', function() {
            // Collect form data
            const formData = new FormData(document.getElementById('updateForm'));

            // Send the data to updatePatient.php using POST
            fetch('updatePatient.php', {method:'POST',body:formData})
            .then(response => response.text())
            .then(data => {document.getElementById('updateResponse').innerHTML = data;})
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('updateResponse').innerHTML = "An error occurred.";
            });
        });
    </script>

    <?php
        # Free result set
        mysqli_free_result($result);
        # Close database connection
        mysqli_close($connection);
    ?>
</body>
</html>
