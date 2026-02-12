<?php
require '../config/db.php';
session_start();

if (
    isset($_SESSION['username']) &&
    $_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['update'])
) {
    $username    = $_SESSION['username'];
    $id = cleanData($_POST['id']);
    $title       = cleanData($_POST['title']);
    $subject     = cleanData($_POST['subject']);
    $description = cleanData($_POST['description']);
    $img         = $_FILES['img'];

    if (empty($id) || empty($title) || empty($subject) || empty($description) || $img['error'] === UPLOAD_ERR_NO_FILE) {
        header("Location: ../pages/update.php?id=$id&result=All fields are required");
        exit;
    }

    $uploadDir = __DIR__ . '/../uploads/';

    $validation = validateImageUpload($img, $uploadDir, 2);
    if (!$validation['status']) {
        header("Location: ../pages/update.php?id=$id&result=" . $validation['message']);
        exit;
    }

    $imgName    = $validation['filename'];
    $targetFile = $validation['path'];

    try {
        $conn->beginTransaction();

        $sql = "update post set title=?, subject=?, description=?, image_url=? where id=? and username=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$title, $subject, $description, $imgName, $id, $username]);

        if (!move_uploaded_file($img['tmp_name'], $targetFile)) {
            throw new Exception("File upload failed");
        }

        $conn->commit();
        header("Location: ../pages/update.php?id=$id&result=Post Updated Successfully");
        exit;
    } catch (Exception $e) {
        $conn->rollBack();

        if (file_exists($targetFile)) {
            unlink($targetFile);
        }

        header("Location: ../pages/update.php?id=$id&result=Something went wrong");
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
