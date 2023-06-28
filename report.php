<?php 
    session_start();
    include('config/db_connect.php');

    if(isset($_POST['submit_search'])){
        $search = mysqli_real_escape_string($conn, $_POST['search']);
        
        $sql = "SELECT * FROM registration WHERE id LIKE '%$search%' OR reg_no LIKE '%$search%' OR first_name LIKE '%$search%' OR last_name LIKE '%$search%' OR phone_no LIKE '%$search%' OR mode LIKE '%$search%'";

        $result = mysqli_query($conn, $sql);
        $registration = mysqli_fetch_all($result, MYSQLI_ASSOC);
        
    }
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
            <form action="report.php" method="POST">
                <div class="user-details">
                    <!-- <div class="input-box">
                        <i class="fa fa-search"></i>
                        <input type="text" name="search" placeholder="Search">
                        <input type="submit" name="submit_search" value="Search">
                    </div> -->
                    <!-- <div class="input-box">   
                        <input type="hidden" name="" placeholder="Search" value="" >
                    </div> -->
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
            <!-- <table width="100%">
                <thead>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                </thead>
            </table> -->
        </div>


    </section>
    <!-- <section id="interface">
    
    </section> -->
</body>

</html>

<script>
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
        var searchTable, mainColumns, dbColumns;


        // Handle dropdown change event
        $('#modeChoice').change(function() {
            console.log('clicked')
            var table, columns, dbC, query;
            if (searchTable == 'registration') {
                query = `mode = '${$(this).val()}'`;
            }                 
            console.log(query)  
            reloadTable(searchTable, mainColumns, dbColumns, query)
        });
        $('#statusChoice').change(function() {
            console.log('clicked')
            var table, columns, dbC, query;
            if (searchTable == 'penalty') {
                query = `status = '${$(this).val()}'`;
            }                 
            console.log(query)  
            reloadTable(searchTable, mainColumns, dbColumns, query)
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
                    query : query
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