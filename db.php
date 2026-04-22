<?php
$conn = mysqli_connect("localhost", "root", "", "tracify_db");

if (!$conn) {
    die("DB connection failed: " . mysqli_connect_error());
}
?>