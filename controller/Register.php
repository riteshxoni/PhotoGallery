<?php
require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {

    $name = cleanData($_POST['name']);
    $email = cleanData($_POST['email']);
    $username = cleanData($_POST['username']);
    $porfolio = cleanUrl($_POST['portfolio']);
    $gender = cleanData($_POST['gender']);

    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    if ((empty($name) || empty($email) || empty($username) || empty($password) || empty($cpassword) || empty($gender))) {
        header("Location: ../pages/register.php?result=All fields are required");
        exit;
    }

    // Name Regex (only letters + space, min 3 chars)
    if (!preg_match("/^[a-zA-Z ]{3,}$/", $name)) {
        header("Location: ../pages/register.php?result=Invalid Name");
        exit;
    }

    // Email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../pages/register.php?result=Invalid Email Format");
        exit;
    }

    if(!empty($porfolio))
    {
        // Url validation
        if (!filter_var($porfolio, FILTER_VALIDATE_URL)) {
            header("Location: ../pages/register.php?result=Invalid Link Format");
            exit;
        }
    }

    //Gender Validation
    $allowedGender = ['male', 'female', 'other'];
    if (!in_array($gender, $allowedGender)) {
        header("Location: ../pages/register.php?result=Invalid gender value");
        exit;
    }
    

    //Password Regex
    // min 8 chars, 1 uppercase, 1 lowercase, 1 number, 1 special char
    if (!preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*#?&]).{8,}$/", $password)) {
        header("Location: ../pages/register.php?result=Weak Password");
        exit;
    }

    //Confirm password check
    if ($password !== $cpassword) {
        header("Location: ../pages/register.php?result=Passwords do not match");
        exit;
    }

    $password = password_hash($password, PASSWORD_DEFAULT);

    try 
    {
        $sql = "INSERT INTO users (name, username, email, password, gender, portfolio)VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$name, $username, $email, $password, $gender, $porfolio]);
        header("Location: ../pages/register.php?result=User Registered Successfully.");
        exit;
    } 
    catch (PDOException $e) 
    {
        $errorCode = $e->errorInfo[1];
        if ($errorCode == 1062) 
        {
            header("Location: ../pages/register.php?result=User already registered!");
        } 
        else 
        {
            header("Location: ../pages/register.php?result=Something went wrong!");
        }
        exit;
    }
}
function cleanData($data)
{
    $data = trim($data);              // remove spaces
    $data = stripslashes($data);      // remove \
    $data = htmlspecialchars($data);  // XSS protection
    return $data;
}

function cleanUrl($data)
{
    $data = trim($data);              // remove spaces
    $data = htmlspecialchars($data);  // XSS protection
    return $data;
}