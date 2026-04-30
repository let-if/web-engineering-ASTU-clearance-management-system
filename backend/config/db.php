<?php
$conn = new mysqli("localhost", "root", "Letif7327", "test_db" ,3306);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>