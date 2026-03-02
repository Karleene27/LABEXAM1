<?php
include 'db.php';

$id_number = $full_name = $email = $course = "";
$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_number = mysqli_real_escape_string($conn, $_POST['id_number']);
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $course = mysqli_real_escape_string($conn, $_POST['course']);
    
    if (empty($id_number) || empty($full_name) || empty($email) || empty($course)) {
        $error = "All fields are required!";
    } else {
        $check_query = "SELECT id_number FROM student WHERE id_number = '$id_number'";
        $check_result = mysqli_query($conn, $check_query);
        
        if (mysqli_num_rows($check_result) > 0) {
            $error = "ID Number already exists!";
        } else {
            $insert_query = "INSERT INTO student (id_number, full_name, email, course) 
                            VALUES ('$id_number', '$full_name', '$email', '$course')";
            
            if (mysqli_query($conn, $insert_query)) {
                $success = "Student added successfully!";
                $id_number = $full_name = $email = $course = "";
            } else {
                $error = "Error: " . mysqli_error($conn);
            }
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
    <title>Add Student</title>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1>ADD STUDENT</h1>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="id_number">ID Number:</label>
                    <input type="number" 
                           id="id_number" 
                           name="id_number" 
                           placeholder="Enter ID Number" 
                           value="<?php echo htmlspecialchars($id_number); ?>" 
                           required>
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
                
                <button type="submit" class="submit-btn">Add Student</button>
            </form>
            
            <a href="dashboard.php" class="back-link">Cancel</a>
        </div>
    </div>
</body>
</html>