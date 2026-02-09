<?php
require './config/db.php';

try 
{
  $sql = "SELECT id, username, image_url, subject, created FROM post";
  // Execute the SQL query
  $result = $conn->query($sql);
} 
catch(PDOException $e) 
{
  echo "Error: " . $e->getMessage();
}

?>

<!doctype html>
<html lang="en">

<head>
    <title>Home | Photo Gallary</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>
    <!-- Header -->
    <?php include './includes/header.php' ?>
    <main class="">
        <!-- Banner -->
         <div class="banner my-3">
            <img src="./assets/img/banner.png" alt="">
         </div>
         <div class="container">
            <div class="display-4 my-3 text-primary text-center">
                Latest Photos
            </div>
            <div class="row justify-content-center g-3">
                <!-- Process the result set -->
                <?php if($result->rowCount() > 0): ?>
                <!-- Output data of each row -->
                    <?php while($row = $result->fetch()): ?>
                            <div class="col-8 col-sm-6 col-md-4 col-lg-3">
                                <a href="./pages/post.php?id=<?php echo $row['id'] ?>" class="text-decoration-none text-dark">
                                    <div class="card">
                                        <div class="post-img">
                                            <img src="<?php echo './uploads/' . $row['image_url'] ?>" class="card-img-top" alt="..." style="height: 300px;">
                                            <div class="overlay">
                                                <span><?php echo $row['subject'] ?></span>
                                            </div>
                                        </div>
                                        <div class="card-body small">
                                            <span class="card-link"><?php echo $row['created'] ?></span>
                                            <span class="card-link float-end">by <?php echo $row['username'] ?></span>
                                            <a href="#" class="btn btn-primary my-2">Read More</a>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="display-3 my-5 text-danger">No post found.</div>
                <?php endif; ?>
            </div>
         </div>
         
    </main>
    <!-- Footer -->
     <?php include './includes/footer.php' ?>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>