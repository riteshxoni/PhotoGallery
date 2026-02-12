<?php
require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) 
{

 $user = cleanData($_POST['user']);
 $password = $_POST['password'];

 if (empty($user) || empty($password)) {
    header("Location: ../pages/login.php?result=All fields are required for login");
    exit;
}

    try 
    {
        // 1. Fetch only the user by username / email
        $sql = "SELECT username, password FROM users WHERE username = ? or email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$user, $user]);
        $fetcheduser = $stmt->fetch();
        // 2. Check if user exists and verify password against the stored hash
        if ($fetcheduser && password_verify($password, $fetcheduser['password'])) 
        {
            // SUCCESS: Start session and log user in
            session_start();
            $_SESSION['username'] = $fetcheduser['username'];
            header("Location: ../index.php?result=Login Successfull.");
            exit;
        } 
        else 
        {
            // FAILURE: Generic error message for security
            header("Location: ../pages/login.php?result=Invalid username or password.");
            exit;
        }
    } 
    catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function cleanData($data)
{
    $data = trim($data);              // remove spaces
    $data = stripslashes($data);      // remove \
    $data = htmlspecialchars($data);  // XSS protection
    return $data;
}

?>