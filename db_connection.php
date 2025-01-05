<?php
// Database connection details
$serverName = "SWETA"; 
$connectionOptions = [
    "Database" => "php_db1", 
    "Uid" => "",          
    "PWD" => "",          
    "CharacterSet" => "UTF-8"       
];

// Establish the connection
$conn = sqlsrv_connect($serverName, $connectionOptions);

// Check the connection
if ($conn === false) {
    die("Connection failed: " . print_r(sqlsrv_errors(), true));
} else {
    echo "Connected to SQL Server successfully!";
}
?>
