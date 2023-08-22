<?php
// Collect data from the form if needed
// For example: $name = $_POST['name'];
// $email = $_POST['email'];

// Create CSV content (replace this with your data)
$csvData = "Name,Email\n";
// Append data to $csvData using a loop or other methods

// Set the appropriate headers for CSV download
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="products.csv"');

// Output the CSV content
echo $csvData;
exit;
?>
