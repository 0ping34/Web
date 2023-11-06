<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Aparat</title>
    <link rel="stylesheet" type="text/css" href="../Styles/style3.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/5.3.0/papaparse.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function fillInputs(codc, miza, sansa, codpa) {
            document.getElementById('codc').value = codc;
            document.getElementById('miza').value = miza;
            document.getElementById('sansa').value = sansa;
            document.getElementById('codpa').value = codpa;
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
                var mizaData = [];

                // Extract column data for miza
                $('tbody tr').each(function() {
                    var miza = $(this).children('td').eq(1).text();
                    mizaData.push(miza);
                });

                // Build URL with query parameters
                var url = 'graph3.html?miza=' + encodeURIComponent(JSON.stringify(mizaData));

                // Open graph3.html in a new window
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
            <li><a href="client.php">Client</a></li>
            <li><a href="../welcome.php">Intoarcere</a>
            </li>
        </ul>
    </nav>
</header>
<div class="inputContainer">
    <form method="post" action="">
        <label for="codc">CODC:</label>
        <input style="margin-bottom: 5px" type="text" id="codc" name="codc"><br>
        <label for="miza">Miza:</label>
        <input style="margin-bottom: 5px" type="text" id="miza" name="miza"><br>
        <label for="sansa">Sansa:</label>
        <input style="margin-bottom: 5px" type="text" id="sansa" name="sansa"><br>
        <label for="codpa">CODPA:</label>
        <input style="margin-bottom: 5px" type="text" id="codpa" name="codpa"><br>
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
            <th>CODC</th>
            <th>Miza</th>
            <th>Castiguri</th>
            <th>Profit</th>
            <th>Sansa</th>
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
                $miza = $_POST["miza"];
                $sansa = $_POST["sansa"];
                $castiguri = $miza * $sansa;
                $profit = $castiguri - $miza;
                $sql = "INSERT INTO cota (CODC, Miza, Castiguri, Profit, Sansa, CODPA) VALUES ('" . $_POST["codc"] . "', '" . $miza . "', '" . $castiguri . "', '" . $profit . "', '" . $sansa . "', '" . $_POST["codpa"] . "')";
                $conn->query($sql);
            } elseif (isset($_POST['modifica'])) {
                $miza = $_POST["miza"];
                $sansa = $_POST["sansa"];
                $castiguri = $miza * $sansa;
                $profit = $castiguri - $miza;
                $sql = "UPDATE cota SET Miza='" .  $miza . "', Castiguri='" .  $castiguri . "', Profit='" .  $profit . "', Sansa='" .  $sansa . "', CODPA='" .  $_POST["codpa"] . "' WHERE CODC='" .  $_POST["codc"]. "'";
                $conn->query($sql);
            } elseif (isset($_POST['sterge'])) {
                $sql = "DELETE FROM cota WHERE CODC='" . $_POST["codc"] . "'";
                $conn->query($sql);
            }
        }

        $sql = "SELECT CODC, Miza, Castiguri, Profit, Sansa, CODPA FROM cota";
        if (isset($_POST['cauta']) && $_POST['cautare'] != '') {
            $sql .= " WHERE CODC='" . $_POST["cautare"] . "'";
        }
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr onclick='fillInputs(\"" . $row["CODC"] . "\",\"" . $row["Miza"] . "\",\"" . $row["Sansa"] . "\",\"" . $row["CODPA"] . "\")'><td>" . $row["CODC"] . "</td><td>" . $row["Miza"] . "</td><td>" . $row["Sansa"] . "</td><td>" . $row["Castiguri"] . "</td><td>" . $row["Profit"] . "</td><td>" . $row["CODPA"] . "</td></tr>";
            }
        } else {
            echo "<tr><td colspan='4'>0 results</td></tr>";
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