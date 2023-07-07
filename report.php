<?php
session_start();
include('config/db_connect.php');


?>
<!DOCTYPE html>
<html lang="en">
<?php include('templates/header.php') ?>
<link rel="stylesheet" href="css/report.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">

<!-- <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="regstyle.css">
</head> -->
<script type="text/javascript" src="js/script.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous">
</script>
<!-- <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script> -->


<!-- <script>
        $(document).ready(function() {
            $("#dropdown2").change(function() {
                var selectedValue = $(this).val();
                $.ajax({
                    url: "fetch_report.php",
                    type: "POST",
                    data: { selectedValue: selectedValue },
                    success: function(response) {
                        $(".tableContainer").html(response);
                    }
                });
            });
        });
</script> -->

<body>
    <?php include('templates/nav.php') ?>
    <!-- <section id='menu'>
        <div class="logo">
            <img src="/Images/University-of-Lagos-courses.jpg" alt=""> 
            <h2>University Of Lagos</h2>
        </div>
        <div class="items">
            <li><i class="fa fa-pie-chart" aria-hidden="true"></i><a href="#">Dashboard</a></li>
            <li><i class="fa fa-user" aria-hidden="true"></i><a href="#">Manage Profile</a></li>
            <li><i class="fa fa-pie-chart" aria-hidden="true"></i><a href="#">Status</a></li>
            <li><i class="fa fa-cog" aria-hidden="true"></i><a href="#">Settings</a></li>
        </div>
    </section> -->
    <section id="interface">
        <div class="container">
            <h3 class="i-name">Report</h3>
            <!-- <h4 class="name">Personal</h4> -->
            <div class="input-boxS">
                <input type="text" name="search" id="searchInput" placeholder="Search">
                <button onclick="searchTable()" value="Search">Search</button>
            </div>
            <form action="report.php" method="POST">
                <div class="user-details">
                    <div class="input-box">
                        <span class="details">Select Report</span>
                        <select id="choice">
                            <option selected disabled>Select</option>
                            <option value="option1">Driver Details</option>
                            <option value="option2">Penalty</option>
                            <option value="option3">Inspection</option>
                            <option value="option4">Staff</option>
                        </select>
                    </div>
                    <div class="input-box" id="dynamicDropdowns">
                        <span class="details">Mode</span>
                        <select id="modeChoice">

                        </select>
                        <!-- The dynamically generated dropdowns will be inserted here -->
                    </div>
                    <div class="input-box" id="dynamicDropdowns">
                        <span class="details">Status</span>
                        <select id="statusChoice">

                        </select>
                        <!-- The dynamically generated dropdowns will be inserted here -->
                    </div>

                </div>
            </form>
        </div>
        <div class="board" id="tableContainer">
            <table width="100%" id="report" class="">
                <thead>
                    <tr>
                        <th>Column1</th>
                        <th>Column2</th>
                        <th>Column3</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                </tbody>
            </table>

        </div>


    </section>

</body>

</html>

<script>
    function searchTable() {
        // Retrieve the search term
        var input = document.getElementById('searchInput');
        var filter = input.value.toUpperCase();

        // Get the table and rows
        var table = document.getElementById('report');
        var rows = table.getElementsByTagName('tr');

        // Loop through all rows, hide/show based on search term
        for (var i = 1; i < rows.length; i++) {
            var cells = rows[i].getElementsByTagName('td');
            var rowMatch = false;

            // Loop through all cells in current row
            for (var j = 0; j < cells.length; j++) {
                var cell = cells[j];
                if (cell) {
                    var cellText = cell.textContent || cell.innerText;
                    if (cellText.toUpperCase().indexOf(filter) > -1) {
                        rowMatch = true;
                        break;
                    }
                }
            }

            // Show/hide row based on match
            if (rowMatch) {
                rows[i].style.display = '';
            } else {
                rows[i].style.display = 'none';
            }
        }
    }

    $(document).ready(function() {
        $("#choice").change(function() {
            var selectedValue = $(this).val();
            $.ajax({
                url: "test.php",
                type: "POST",
                data: {
                    selectedValue: selectedValue
                },
                success: function(response) {
                    $("#modeChoice").html(response);
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function() {
        $("#choice").change(function() {
            var selectedValue = $(this).val();
            $.ajax({
                url: "test2.php",
                type: "POST",
                data: {
                    selectedValue: selectedValue
                },
                success: function(response) {
                    $("#statusChoice").html(response);
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Initialize DataTables
        var searchTable, mainColumns, dbColumns, global_query = null,
            mode_query = null,
            status_query = null;


        // Handle dropdown change event
        $('#modeChoice').change(function() {
            //console.log('clicked')
            var table, columns, dbC, query = null;
            if ($(this).val() != 'All') {
                if (searchTable == 'registration') {
                    query = `mode = '${$(this).val()}'`;
                } else if (searchTable == 'penalty') {
                    query = `reg.mode = '${$(this).val()}'`;
                } else if (searchTable == 'inspection') {
                    query = `reg.mode = '${$(this).val()}'`;
                }
                mode_query = query;
                global_query = status_query != null ? mode_query + ' AND ' + status_query : query;
                console.log(global_query)
                reloadTable(searchTable, mainColumns, dbColumns, global_query)
            } else {
                mode_query = query;
                global_query = status_query;
                console.log(global_query)
                reloadTable(searchTable, mainColumns, dbColumns, global_query)
            }


        });
        $('#statusChoice').change(function() {
            //console.log('clicked')
            var table, columns, dbC, query = null;
            if ($(this).val() != 'All') {
                if (searchTable == 'penalty') {
                    query = `dp.status = '${$(this).val()}'`;
                }
                status_query = query;
                global_query = mode_query != null ? status_query + ' AND ' + mode_query : query;
                console.log(global_query)
                reloadTable(searchTable, mainColumns, dbColumns, global_query)
            } else {
                status_query = query;
                global_query = mode_query;
                console.log(global_query)
                reloadTable(searchTable, mainColumns, dbColumns, global_query)
            }

        });

        function reloadTable(table, columns, dbC, query) {
            // Make AJAX request to retrieve data based on the selected value
            $.ajax({
                url: 'fetch_report.php',
                method: 'POST',
                data: {
                    table: table,
                    columns: columns,
                    dbC: dbC,
                    query: query
                },
                success: function(response) {
                    // Clear existing table data
                    $('#tbody').html("");
                    var _table = $("#report");

                    // Set the table headers
                    var headerRow = '<tr>';
                    for (var i = 0; i < columns.length; i++) {
                        headerRow += '<th>' + columns[i] + '</th>';
                    }
                    headerRow += '</tr>';
                    $('#report thead').html(headerRow);

                    // Add the new data to the table
                    console.log(response)
                    var totalBodyRows = "";
                    response.forEach(element => {
                        var bodyRows = '<tr>';
                        for (var i = 0; i < element.length; i++) {
                            bodyRows += '<td>' + element[i] + '</td>';
                        }
                        bodyRows += '</tr>';
                        totalBodyRows += bodyRows;
                    });

                    $('#tbody').html(totalBodyRows);
                    console.log(totalBodyRows)
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        // Handle dropdown change event
        $('#choice').change(function() {
            var selectedValue = $(this).val();

            // Check the selected value and determine the table and columns
            var table, columns, dbC, query;
            if (selectedValue === 'option1') {
                table = 'registration';
                columns = ['reg no', 'name', 'mode', 'phone no', 'email'];
                dbC = ['reg_no', 'first_name', 'mode', 'phone_no', 'email'];
            } else if (selectedValue === 'option2') {
                table = 'penalty';
                columns = ['regno', 'name', 'mode', 'offence', 'penalty', 'amount', 'status'];
                dbC = ['regno', 'name', 'mode', 'offence', 'penalty', 'amount', 'status'];
            } else if (selectedValue === 'option4') {
                table = 'staff';
                columns = ['name', 'staff no', 'phone no'];
                dbC = ['first_name', 'staff_no', 'phone_no'];
            } else if (selectedValue === 'option3') {
                table = 'inspection';
                columns = ['reg no', 'name', 'phone no', 'mode', 'Inspect ID', 'Date Created'];
                dbC = ['reg_no', 'first_name', 'phone_no', 'mode', 'answer'];
            }
            searchTable = table;
            mainColumns = columns;
            dbColumns = dbC;

            reloadTable(searchTable, mainColumns, dbColumns, null)
        });



    });
</script>