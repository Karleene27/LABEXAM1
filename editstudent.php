<?php
include 'db.php';

$id_number = $full_name = $email = $course = "";
$error = "";
$success = "";

if (isset($_GET['id'])) {
    $edit_id = mysqli_real_escape_string($conn, $_GET['id']);
    
    $query = "SELECT * FROM student WHERE id_number = '$edit_id'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) == 1) {
        $student = mysqli_fetch_assoc($result);
        $id_number = $student['id_number'];
        $full_name = $student['full_name'];
        $email = $student['email'];
        $course = $student['course'];
    } else {
        $error = "Student not found!";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_number = mysqli_real_escape_string($conn, $_POST['id_number']);
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $course = mysqli_real_escape_string($conn, $_POST['course']);
    
    if (empty($id_number) || empty($full_name) || empty($email) || empty($course)) {
        $error = "All fields are required!";
    } else {
        $update_query = "UPDATE student SET 
                        full_name = '$full_name', 
                        email = '$email', 
                        course = '$course' 
                        WHERE id_number = '$id_number'";
        
        if (mysqli_query($conn, $update_query)) {
            $success = "Student updated successfully!";
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Edit Student</title>
    
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1>EDIT STUDENT</h1>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <?php if (!empty($id_number) || isset($_GET['id'])): ?>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="id_number">ID Number:</label>
                    <input type="number" 
                           id="id_number" 
                           name="id_number" 
                           value="<?php echo htmlspecialchars($id_number); ?>" 
                           readonly>
                    <div class="info-text">ID Number cannot be changed</div>
                </div>
                
                <div class="form-group">
                    <label for="full_name">Full Name:</label>
                    <input type="text" 
                           id="full_name" 
                           name="full_name" 
                           placeholder="Enter Full Name" 
                           value="<?php echo htmlspecialchars($full_name); ?>" 
                           required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           placeholder="Enter Email Address" 
                           value="<?php echo htmlspecialchars($email); ?>" 
                           required>
                </div>
                
                <div class="form-group">
                    <label for="course">Course:</label>
                    <input type="text" 
                           id="course" 
                           name="course" 
                           placeholder="Enter Course" 
                           value="<?php echo htmlspecialchars($course); ?>" 
                           required>
                </div>
                
                <div class="button-group">
                    <button type="submit" class="update-btn">Update Student</button>
                    <a href="dashboard.php" class="cancel-btn">Cancel</a>
                </div>
            </form>
            <?php else: ?>
                <p style="text-align: center; color: #999; margin: 30px 0;">No student selected for editing.</p>
                <a href="index.php" class="back-link" style="display: block; text-align: center;">← Back to Student Records</a>
            <?php endif; ?>
            
            <?php if (!isset($_GET['id']) && !$success): ?>
            <a href="index.php" class="back-link">← Back to Student Records</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>