<?php 

    include('config/db_connect.php');

    function filterData(&$str){ 
        $str = preg_replace("/\t/", "\\t", $str); 
        $str = preg_replace("/\r?\n/", "\\n", $str); 

        if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
    }

// Excel file name for download 
$fileName = "members-data_" . date('Y-m-d') . ".xls"; 
 
// Column names 
$fields = array('NO', 'REGNO', 'NAME', 'MODE', 'OFFENCE', 'PENALTY'); 
 
// Display column names as first row 
$excelData = implode("\t", array_values($fields)) . "\n"; 
 
// Fetch records from database 
$query = "SELECT * FROM registration r, driver_penalty d, penalty p WHERE r.reg_no = d.reg_no AND d.penalty_id = p.id" ;
$result = mysqli_query($conn, $query);
if($result->num_rows > 0){ 
    // Output each row of the data 
    while($row = mysqli_fetch_assoc($result)){ 
        $status = ($row['status'] == 1)?'Active':'Inactive'; 
        $lineData = array($row['id'], $row['reg_no'], $row['first_name'], $row['mode'], $row['offence'], $row['penalty']); 
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n"; 
    } 
}else{ 
    $excelData .= 'No records found...'. "\n"; 
}   

// Headers for download 
header("Content-Type: application/vnd.ms-excel"); 
header("Content-Disposition: attachment; filename=\"$fileName\""); 
 
// Render excel data 
echo $excelData; 
 
exit;

?>