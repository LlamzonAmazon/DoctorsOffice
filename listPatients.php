<h1>PATIENT DATA</h1>
    
    <!-- Form for sorting by first name or last name -->
    <form id="sortForm">
        <input type="radio" name="sort" value="firstname" <?php if ($sortOrder == 'firstname') echo 'checked'; ?>> by first name<br>
        <input type="radio" name="sort" value="lastname" <?php if ($sortOrder == 'lastname') echo 'checked'; ?>> by last name<br>
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
                <th>Patient ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Weight (kg)</th>
                <th>Birthdate</th>
                <th>Height (m)</th>
                <th>Doctor ID</th>
            </tr>
        </thead>
        <tbody>
<?php
    # Display patient data
    if ($result) {
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>" . $row["ohip"] .
            "</td><td>" . $row["firstname"] .
            "</td><td>" . $row["lastname"] .
            "</td><td>" . $row["weight"] .
            "</td><td>" . $row["birthdate"] .
            "</td><td>" . $row["height"] .
            "</td><td>" . $row["treatsdocid"] . "</td></tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($connection);
    }
