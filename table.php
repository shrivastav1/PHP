<?php
require_once 'db_connection.php';

$createTable = "
CREATE TABLE Users (
    id INT PRIMARY KEY IDENTITY(1,1),
    name VARCHAR(50) NOT NULL,
    username VARCHAR(30) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    created_at DATETIME DEFAULT GETDATE()
)";

$sql = sqlsrv_query($conn, $createTable);

if($sql === false){
    die("Tablel creation failed ". print_r(sqlsrv_errors(), true));
}else {
    echo "Table 'Users' created successfully!";
}
sqlsrv_close($conn);;
?>