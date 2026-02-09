<?php
require '../config/db.php';
session_start();

if (
    isset($_SESSION['username']) &&
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['upload'])
) 
{
    $username    = $_SESSION['username'];
    $title       = cleanData($_POST['title']);
    $subject     = cleanData($_POST['subject']);
    $description = cleanData($_POST['description']);
    $img         = $_FILES['img'];

    if (empty($title) || empty($subject) || empty($description) || $img['error'] === UPLOAD_ERR_NO_FILE) 
    {
        header("Location: ../pages/upload.php?result=All fields are required");
        exit;
    }

    $uploadDir = __DIR__ . '/../uploads/';

    $validation = validateImageUpload($img, $uploadDir, 2);
    if (!$validation['status']) {
        header("Location: ../pages/upload.php?result=" . $validation['message']);
        exit;
    }

    $imgName    = $validation['filename'];
    $targetFile = $validation['path'];

    try {
        $conn->beginTransaction();

        $sql = "INSERT INTO post (title, username, subject, description, image_url)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$title, $username, $subject, $description, $imgName]);

        if (!move_uploaded_file($img['tmp_name'], $targetFile)) {
            throw new Exception("File upload failed");
        }

        $conn->commit();
        header("Location: ../pages/upload.php?result=Post Uploaded Successfully");
        exit;

    } catch (Exception $e) {
        $conn->rollBack();

        if (file_exists($targetFile)) {
            unlink($targetFile);
        }

        header("Location: ../pages/upload.php?result=Something went wrong");
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

function validateImageUpload(array $file, string $uploadDir, int $maxSizeMB = 2): array
{
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['status' => false, 'message' => 'Upload error'];
    }

    $imageInfo = getimagesize($file['tmp_name']);
    if ($imageInfo === false) {
        return ['status' => false, 'message' => 'File is not a valid image'];
    }

    $allowedMime = ['image/jpeg', 'image/png', 'image/webp'];
    if (!in_array($imageInfo['mime'], $allowedMime, true)) {
        return ['status' => false, 'message' => 'Invalid image format'];
    }

    if ($file['size'] > ($maxSizeMB * 1024 * 1024)) {
        return ['status' => false, 'message' => "Image must be under {$maxSizeMB}MB"];
    }

    $safeName  = preg_replace('/[^a-zA-Z0-9._-]/', '_', $file['name']);
    $finalName = time() . '_' . $safeName;
    $path      = rtrim($uploadDir, '/') . '/' . $finalName;

    return [
        'status'   => true,
        'filename' => $finalName,
        'path'     => $path
    ];
}

?>