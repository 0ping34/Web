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
        function fillInputs(codpa, tip, sport, data_incheieri, data_realizari, codap) {
            document.getElementById('codpa').value = codpa;
            document.getElementById('tip').value = tip;
            document.getElementById('sport').value = sport;
            document.getElementById('data_incheieri').value = data_incheieri;
            document.getElementById('data_realizari').value = data_realizari;
            document.getElementById('codap').value = codap;
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
                var sportData = [];

                // Extract column data for sport
                $('tbody tr').each(function() {
                    var sport = $(this).children('td').eq(2).text();
                    sportData.push(sport);
                });

                // Build URL with query parameters
                var url = 'graph2.html?sport=' + encodeURIComponent(JSON.stringify(sportData));

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
            <li><a href="cota.php">Cota</a></li>
            <li><a href="client.php">Client</a></li>
            <li><a href="../welcome.php">Intoarcere</a>
            </li>
        </ul>
    </nav>
</header>
<div class="inputContainer">
    <form method="post" action="">
        <label for="codpa">CODPA:</label>
        <input style="margin-bottom: 5px" type="text" id="codpa" name="codpa"><br>
        <label for="tip">Tip:</label>
        <input style="margin-bottom: 5px" type="text" id="tip" name="tip"><br>
        <label for="sport">Sport:</label>
        <input style="margin-bottom: 5px" type="text" id="sport" name="sport"><br>
        <label for="data_incheieri">Data Incheieri:</label>
        <input style="margin-bottom: 5px" type="date" id="data_incheieri" name="data_incheieri"><br>
        <label for="data_realizari">Data Realizari:</label>
        <input style="margin-bottom: 5px" type="date" id="data_realizari" name="data_realizari"><br>
        <label for="codap">CODAP:</label>
        <input style="margin-bottom: 5px" type="text" id="codap" name="codap"><br>
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
            <th>CODPA</th>
            <th>Tip</th>
            <th>Sport</th>
            <th>Data Incheieri</th>
            <th>Data Realizari</th>
            <th>CODAP</th>
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
                $sql = "INSERT INTO pariu (CODPA, Tip, Sport, Data_Incheieri, Data_Realizari, CODAP) VALUES ('" . $_POST["codpa"] . "', '" . $_POST["tip"] . "', '" . $_POST["sport"] . "', '" . $_POST["data_incheieri"] . "', '" . $_POST["data_realizari"] . "', '" . $_POST["codap"] . "')";
                $conn->query($sql);
            } elseif (isset($_POST['modifica'])) {
                $sql = "UPDATE pariu SET Tip='" .  $_POST["tip"]. "', Sport='" .  $_POST["sport"] . "', Data_Incheieri='" .  $_POST["data_incheieri"] . "', Data_Realizari='" .  $_POST["data_realizari"] . "', CODAP='" .  $_POST["codap"] . "' WHERE CODPA='" .  $_POST["codpa"]. "'";
                $conn->query($sql);
            } elseif (isset($_POST['sterge'])) {
                $sql = "DELETE FROM pariu WHERE CODPA='" . $_POST["codpa"] . "'";
                $conn->query($sql);
            }
        }

        $sql = "SELECT CODPA, Tip, Sport, Data_Incheieri, Data_Realizari, CODAP FROM pariu";
        if (isset($_POST['cauta']) && $_POST['cautare'] != '') {
            $sql .= " WHERE CODPA='" . $_POST["cautare"] . "'";
        }
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr onclick='fillInputs(\"" . $row["CODPA"] . "\",\"" . $row["Tip"] . "\",\"" . $row["Sport"] . "\",\"" . $row["Data_Incheieri"] . "\",\"" . $row["Data_Realizari"] . "\",\"" . $row["CODAP"] . "\")'><td>" . $row["CODPA"] . "</td><td>" . $row["Tip"] . "</td><td>" . $row["Sport"] . "</td><td>" . $row["Data_Incheieri"] . "</td><td>" . $row["Data_Realizari"] . "</td><td>" . $row["CODAP"] . "</td></tr>";
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