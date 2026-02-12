<?php 
    require '../config/db.php';
    session_start();
    if(!isset($_SESSION['username']))
    {
        header("Location: /photogallary/pages/login.php?result=Please Login First...");
        exit;
    }
    $username = $_SESSION['username'];
    try 
    {
        // 1. Fetch only the user by username
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        $sql = "SELECT * FROM post where username=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$username]);
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } 
    catch (PDOException $e) 
    {
        echo "Error: " . $e->getMessage();
    }
    session_abort();
?>
<!doctype html>
<html lang="en">
    <head>
        <title>Profile</title>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1, shrink-to-fit=no"
        />

        <!-- Bootstrap CSS v5.2.1 -->
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="../assets/css/style.css">
    </head>

    <body>
        <header>
            <?php include '../includes/header.php' ?>
        </header>
        <main>
            <div class="container my-5">
                <h2 class="text-center mb-4">Welcome <?php echo $user['username'] ?></h2>
                <div class="text-center rounded-circle">
                    <img src="../assets/img/profile.png" height="250px" alt="">
                </div>
                <!-- Personal Details Form -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">Personal Details</div>
                    <div class="card-body">
                    
                            <div class="row mb-3">
                                <div class="col">
                                    <div>Name</div>
                                    <p><?php echo $user['name'] ?></p>
                                </div>
                                <div class="col">
                                    <div>Email</div>
                                    <p><?php echo $user['email'] ?></p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <div>Gender</div>
                                    <p><?php echo $user['gender'] ?></p>
                                </div>
                                <div class="col">
                                    <div>Portfolio</div>
                                    <p><?php echo $user['portfolio'] ?></p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <div>Join Date</div>
                                    <p><?php echo $user['created'] ?></p>
                                </div>
                            </div>
                    </div>
                </div>


                <!-- Profile Table -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">Your Posts List</div>
                    <div class="card-body table-responsive">
                        <table class="table-sm table-bordered table-striped text-center">
                            <thead class="table-success">
                            <tr class="text-uppercase">
                                <th>id</th>
                                <th>title</th>
                                <th>description</th>
                                <th>image</th>
                                <th>subject</th>
                                <th>created</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php if($posts): ?>
                                    <!-- Output data of each row -->
                                    <?php foreach($posts as $row): ?>
                                        <tr>
                                            <td><?php echo $row['id'] ?></td>
                                            <td><?php echo $row['title'] ?></td>
                                            <td><?php echo $row['description'] ?></td>
                                            <td>
                                                <img height="70px" src="<?php echo "../uploads/" . $row['image_url'] ?>" alt="">
                                            </td>
                                            <td><?php echo $row['subject'] ?></td>
                                            <td><?php echo $row['created'] ?></td>
                                            <td>
                                                <a href="update.php?id=<?php echo $row['id'] ?>" class="btn btn-warning mb-2">Update Post</a>
                                                <a href="../controller/DeletePost.php?id=<?php echo $row['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this post?');">Delete Post</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td aria-colspan="7">You Have No Posts</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Gallery Section -->
                <div class="card">
                    <div class="card-header bg-info text-white">Profile Action</div>
                    <div class="card-body">

                        <div class="mb-3">
                            <a href="upload.php" class="btn btn-primary">Add Post</a>
                            <a href="#" class="btn btn-danger">Delete Account</a>
                        </div>
                    </div>
                </div>

            </div>
        </main>
        <footer>
            <?php include '../includes/footer.php' ?>
        </footer>
            
        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>
    </body>
</html>
