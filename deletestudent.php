<?php
include 'db.php';

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM student WHERE id_number = $id");

header("Location: dashboard.php");
exit();
?>