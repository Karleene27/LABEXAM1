<?php
session_start();
include 'db.php';

if (!isset($_SESSION['loggedin'])) {
    header("Location: index.php");
    exit();
}

function get_count($conn, $query, $key) {
    $result = mysqli_query($conn, $query);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row[$key];
    }
    return 0;
}

$student_count = get_count($conn, "SELECT COUNT(*) as count FROM student", "count");
$students_query = "SELECT id_number, full_name, email, course FROM student ORDER BY full_name";
$students_result = mysqli_query($conn, $students_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Student Records</title>
</head>
<body>
    <div class="container">
        <h1>Student Records</h1>
        
        <div class="total-students">
            <div class="card stats-card">
                <span class="value"><?php echo number_format($student_count); ?></span>
                <span class="label">Total Students</span>
            </div>
        </div>
        
        <a href="addstudent.php">
            <button type="button" class="add-btn">Add Student</button>
        </a>
        
        <div class="cards-grid">
            <?php 
            if (mysqli_num_rows($students_result) > 0) {
                while ($student = mysqli_fetch_assoc($students_result)) {
            ?>
            <div class="card student-card">
                <div class="student-id">ID: <?php echo htmlspecialchars($student['id_number']); ?></div>
                <h3 class="student-name"><?php echo htmlspecialchars($student['full_name']); ?></h3>
                <p class="student-email">
                    <strong>Email:</strong> <?php echo htmlspecialchars($student['email']); ?>
                </p>
                <p class="student-course">
                    <strong>Course:</strong> <?php echo htmlspecialchars($student['course']); ?>
                </p>
                
                <div class="card-actions">
                    <a href="editstudent.php?id=<?php echo $student['id_number']; ?>">
                        <button type="button" class="edit-btn">Edit</button>
                    </a>
                    <a href="deletestudent.php?id=<?php echo $student['id_number']; ?>" onclick="return confirm('Are you sure?')">
                        <button type="button" class="delete-btn">Delete</button>
                    </a>
                </div>
            </div>
            <?php 
                }
            } else {
                echo "<p class='no-records'>No student records found.</p>";
            }
            ?>
        </div>
        
        <a href="index.php">
            <button class="logout-btn">Logout</button>
        </a>
    </div>
</body>
</html>