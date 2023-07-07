<?php 

    include('config/db_connect.php');

    // if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //     $selectedValue = $_POST["selectedValue"];
    
    //     // Generate the table HTML based on the selected value
    //     if ($selectedValue === "option1") {

    //         $query = "SELECT * FROM registration";
    //         $result = mysqli_query($conn, $query);
    //         $count = mysqli_num_rows($result);

    //         // Generate the table for option A
    //         $table = '<table width="100%">';
    //         $table .= '<tr>';
    //         $table .= '<th>NO</th>';
    //         $table .= '<th>REG NO</th>';
    //         $table .= '<th>NAME</th>';
    //         $table .= '</tr>';

            
    
    //         // Loop through the data for option A and generate table rows
    //         while ($row = $result->fetch_assoc()) {
    //             $table .= '<tr>';
    //             $table .= '<td>' . $row[''] . '</td>';
    //             $table .= '<td>' . $row['1'] . '</td>';
    //             $table .= '<td>' . $row['2'] . '</td>';
    //             $table .= '</tr>';
    //         }
    
    //         $table .= '</table>';
    //     } elseif ($selectedValue === "option2") {
    //         // Generate the table for option B
    //         $table = '<table>';
    //         $table .= '<tr>';
    //         $table .= '<th>Header 4</th>';
    //         $table .= '<th>Header 5</th>';
    //         $table .= '<th>Header 6</th>';
    //         $table .= '</tr>';
    
    //         // Loop through the data for option B and generate table rows
    
    //         $table .= '</table>';
    //     } elseif ($selectedValue === "option3") {
    //         // Generate the table for option C
    //         $table = '<table>';
    //         $table .= '<tr>';
    //         $table .= '<th>Header 7</th>';
    //         $table .= '<th>Header 8</th>';
    //         $table .= '<th>Header 9</th>';
    //         $table .= '</tr>';
    
    //         // Loop through the data for option C and generate table rows
    
    //         $table .= '</table>';
    //     } else {
    //         // Handle the case when none of the options match
    //         $table = '<p>No data available for the selected option.</p>';
    //     }
    
    //     echo $table;
    
    //     // Close the database connection
    //     $conn->close();
    // }

    $table = $_POST['table']; // Get the table name from the POST data
    $whereClause =$_POST['query'] == null ? '' : "WHERE $_POST[query]";
    $columns = $_POST['columns'];
    $dbC = $_POST['dbC'];
    $columnNames = implode(',', $dbC);

    // Retrieve data from the specified table and format it as an array
    if($table == 'penalty'){
      $query = "SELECT reg.reg_no, reg.first_name, reg.mode, p.offence, p.penalty, dp.amount, dp.status 
      FROM registration AS reg JOIN driver_penalty AS dp ON reg.reg_no = dp.reg_no JOIN penalty AS p ON dp.penalty_id = p.id $whereClause";
    } else if($table == 'inspection'){
      $query = "SELECT reg.reg_no, reg.first_name, reg.phone_no, reg.mode, d.id, d.date_created FROM registration AS reg JOIN 
      driver_inspect AS d ON reg.reg_no = d.reg_no $whereClause";
    } else {
      $query = "SELECT $columnNames FROM $table $whereClause";
    }
    //die($query);
    $result = $conn->query($query);
    //die($result);
    $data = array();
    while ($row = $result->fetch_assoc()) {
      $data[] = array_values($row);
    }
    
    // Close the connection
    $conn->close();
    
    // Return the data as a JSON response
    header('Content-Type: application/json');
    echo json_encode($data);

?>
