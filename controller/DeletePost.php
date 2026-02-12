<?php
require '../config/db.php';
session_start();

if (isset($_SESSION['username']) && isset($_GET['id'])) 
{
    $username = $_SESSION['username'];
    $id = cleanData($_GET['id']);

    try {

    $sql = "SELECT image_url FROM post WHERE id = ? AND username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id, $username]);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);
    $imagePath = "../uploads/" . $post['image_url'];
    // Delete image from folder
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }

    // SQL to delete a record
    $sql = "DELETE FROM post WHERE id=? and username=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id, $username]);
  
    if($stmt->rowCount() > 0)
    {
        header("Location: ../pages/profile.php?result=Post deleted successfully");
        exit;
    }
    else
    {
        header("Location: ../pages/profile.php?result=Access Dennied!");
        exit;
    }
    } 
    catch(PDOException $e) 
    {
        header("Location: ../pages/profile.php?result=" . $e->getMessage());
        exit;
    }
}
else
{
    header("Location: ../pages/profile.php?result=Somthing went Wrong");
    exit;   
}

function cleanData($data)
{
    $data = trim($data);              // remove spaces
    $data = stripslashes($data);      // remove \
    $data = htmlspecialchars($data);  // XSS protection
    return $data;
}
?>