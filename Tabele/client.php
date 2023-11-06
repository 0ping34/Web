<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Angajat</title>
    <link rel="stylesheet" type="text/css" href="../Styles/style3.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function fillInputs(CNP, Nume, Prenume, Adresa, Varsta, CODPA) {
            document.getElementById('CNP').value = CNP;
            document.getElementById('Nume').value = Nume;
            document.getElementById('Prenume').value = Prenume;
            document.getElementById('Adresa').value = Adresa;
            document.getElementById('Varsta').value = Varsta;
            document.getElementById('CODPA').value = CODPA;
        }

        $(document).ready(function() {
            // Filter in real-time
            $('#cautare').on('input', function() {
                var value = $(this).val().toLowerCase();
                $('tbody tr').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });

            // Reset button
            $('#reset').on('click', function() {
                location.reload();
            });

            // Table sorting
            $('th').on('click', function() {
                var column = $(this).index();
                var rows = $('tbody tr').get();

                rows.sort(function(a, b) {
                    var A = $(a).children('td').eq(column).text().toUpperCase();
                    var B = $(b).children('td').eq(column).text().toUpperCase();
                    return A.localeCompare(B);
                });

                $.each(rows, function(index, row) {
                    $('tbody').append(row);
                });
            });

            // Import button
            $('#import').on('click', function() {
                // Open file input dialog
                $('#fileInput').click();
            });

            // Handle file selection
            $('#fileInput').on('change', function(e) {
                var file = e.target.files[0];

                // Check if the selected file is a CSV file
                if (file.type !== 'text/csv') {
                    alert('Please select a CSV file.');
                    return;
                }

                var reader = new FileReader();

                reader.onload = function(e) {
                    var csvData = e.target.result;

                    Papa.parse(csvData, {
                        header: true,
                        complete: function(results) {
                            var data = results.data;

                            // Clear existing table
                            $('thead').empty();
                            $('tbody').empty();

                            // Create table header based on CSV headers
                            var headers = Object.keys(data[0]);
                            var headerRow = $('<tr></tr>');

                            headers.forEach(function(header) {
                                headerRow.append('<th>' + header + '</th>');
                            });

                            $('thead').append(headerRow);

                            // Append imported data to the table
                            data.forEach(function(row) {
                                var tableRow = $('<tr></tr>');

                                // Append table data for each column
                                headers.forEach(function(header) {
                                    tableRow.append('<td>' + row[header] + '</td>');
                                });

                                $('tbody').append(tableRow);
                            });
                        }
                    });
                };

                reader.readAsText(file);
            });

            // Export button
            $('#export').on('click', function() {
                var tableData = [];
                $('tbody tr').each(function() {
                    var rowData = [];
                    $(this).find('td').each(function() {
                        rowData.push($(this).text());
                    });
                    tableData.push(rowData);
                });

                var csvContent = Papa.unparse(tableData, { header: true });
                var blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
                var link = document.createElement("a");
                if (link.download !== undefined) {
                    var url = URL.createObjectURL(blob);
                    link.setAttribute("href", url);
                    link.setAttribute("download", "table.csv");
                    link.style.visibility = 'hidden';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                }
            });

              // Frequency graph
            $('#frequency').on('click', function() {
                var numeData = [];

                // Extract column data for nume
                $('tbody tr').each(function() {
                    var nume = $(this).children('td').eq(1).text();
                    numeData.push(nume);
                });

                // Build URL with query parameters
                var url = 'graph.html?nume=' + encodeURIComponent(JSON.stringify(numeData));

                // Open graph.html in a new window
                window.open(url);
            });
        });
    </script>
</head>
<body>
<header>
    <nav>
        <ul>
            <li><a href="casa_de_pariuri.php">Casa de pariuri</a></li>
            <li><a href="angajat.php">Angajat</a></li>
            <li><a href="aparat.php">Aparat</a></li>
            <li><a href="pariu.php">Pariu</a></li>
            <li><a href="cota.php">Cota</a></li>
            <li><a href="../welcome.php">Intoarcere</a>
            </li>
        </ul>
    </nav>
</header>
<div class="inputContainer">
    <form method="post" action="">
        <label for="CNP">CNP:</label>
        <input style="margin-bottom: 5px" type="text" id="CNP" name="CNP"><br>
        <label for="Nume">Nume:</label>
        <input style="margin-bottom: 5px" type="text" id="Nume" name="Nume"><br>
        <label for="Prenume">Prenume:</label>
        <input style="margin-bottom: 5px" type="text" id="Prenume" name="Prenume"><br>
        <label for="Adresa">Adresa:</label>
        <input style="margin-bottom: 5px" type="text" id="Adresa" name="Adresa"><br>
        <label for="Varsta">Varsta:</label>
        <input style="margin-bottom: 5px" type="text" id="Varsta" name="Varsta"><br>
        <label for="CODPA">CODPA:</label>
        <input style="margin-bottom: 5px" type="text" id="CODPA" name="CODPA"><br>
        <input type="submit" name="adaugare" value="Adaugare">
        <input type="submit" name="modifica" value="Modifica">
        <input type="submit" name="sterge" value="Sterge"><br>
        <label for="cautare">Filtru:</label>
        <input type="text" id="cautare" name="cautare"><br>
        <input type="button" id="reset" class="resetButton" value="Reset">
    </form>
</div>
<div class="tableContainer">
    <table>
        <thead>
        <tr>
            <th>CNP</th>
            <th>Nume</th>
            <th>Prenume</th>
            <th>Adresa</th>
            <th>Varsta</th>
            <th>CODPA</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $servername = "localhost";
        $username = "admin";
        $password = "1234";
        $db_name = "casa_de_pariuri";
        $conn = new mysqli($servername, $username, $password, $db_name);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Handle form submission
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['adaugare'])) {
                $sql = "INSERT INTO client (CNP, Nume, Prenume, Adresa, Varsta, CODPA) VALUES ('" . $_POST["CNP"] . "', '" . $_POST["Nume"] . "', '" . $_POST["Prenume"] . "', '" . $_POST["Adresa"] . "', '" . $_POST["Varsta"] . "', '" . $_POST["CODPA"] . "')";
                $conn->query($sql);
            } elseif (isset($_POST['modifica'])) {
                $sql = "UPDATE client SET Nume='" .  $_POST["Nume"]. "', Prenume='" .  $_POST["Prenume"] . "', Adresa='" .  $_POST["Adresa"] . "', Varsta='" .  $_POST["Varsta"] . "', CODPA='" .  $_POST["CODPA"] . "' WHERE CNP='" .  $_POST["CNP"]. "'";
                $conn->query($sql);
            } elseif (isset($_POST['sterge'])) {
                $sql = "DELETE FROM client WHERE CNP='" . $_POST["CNP"] . "'";
                $conn->query($sql);
            }
        }

        $sql = "SELECT CNP, Nume, Prenume, Adresa, Varsta, CODPA FROM client";
        if (isset($_POST['cauta']) && $_POST['cautare'] != '') {
            $sql .= " WHERE CNP='" . $_POST["cautare"] . "'";
        }
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr onclick='fillInputs(\"" . $row["CNP"] . "\",\"" . $row["Nume"] . "\",\"" . $row["Prenume"] . "\",\"" . $row["Adresa"] . "\",\"" . $row["Varsta"] . "\",\"" . $row["CODPA"] . "\")'><td>" . $row["CNP"] . "</td><td>" . $row["Nume"] . "</td><td>" . $row["Prenume"] . "</td><td>" . $row["Adresa"] . "</td><td>" . $row["Varsta"] . "</td><td>" . $row["CODPA"] . "</td></tr>";
            }
        } else {
            echo "<tr><td colspan='6'>0 results</td></tr>";
        }
        $conn->close();
        ?>
        </tbody>
    </table>

</div>
<input type="file" id="fileInput" style="display: none;">
<input type="button" id="import" class="importButton" value="Import">
<input type="button" id="export" class="exportButton" value="Export">
<input type="button" id="frequency" class="graphButton" value="Grafic">
</body>
</html>