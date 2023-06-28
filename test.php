<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $selectedValue = $_POST["selectedValue"];

    // Assuming you have an array of options based on the selected value
    $options = array();
    if ($selectedValue === "option1") {
        $options = array("All", "Shuttle", "Cab");
    } elseif ($selectedValue === "option2") {
        $options = array("All", "Shuttle", "Cab");
    } elseif ($selectedValue === "option3") {
        $options = array("All", "Shuttle", "Cab");
    }

    // Generate the dynamic dropdown based on the options array
    $dropdown = '';
    foreach ($options as $option) {
        $dropdown .= '<option value="' . $option . '">' . $option . '</option>';
    }

    echo $dropdown;
}
?>
