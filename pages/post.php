<?php
require '../config/db.php';

if(isset($_GET['id']))
{
    $id = $_GET['id'];
    try 
    {
        $sql = "SELECT * FROM post where id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);
        $post = $stmt->fetch(PDO::FETCH_OBJ);
        if(!$post)
        {
            header("Location: ../index.php?result=Please correct id.");
            exit;
        }

        $sql = "SELECT id, username, image_url, subject, created FROM post WHERE subject = ? ORDER BY id DESC LIMIT 4";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$post->subject]);
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);

    } 
    catch(PDOException $e) 
    {
    echo "Error: " . $e->getMessage();
    }
}
else
{
    header("Location: ../index.php?result=Please provide id.");
    exit;
}

?>
<!doctype html>
<html lang="en">
    <head>
        <title>Upload Photo</title>
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
        <!-- Header -->
        <?php include '../includes/header.php' ?>
        <main class="">
        <!-- Banner -->
         <div class="banner my-3">
            <img src="../assets/img/banner.png" alt="">
         </div>
         <div class="container">
            <div class="display-4 my-4 text-primary text-center text-md-start">
                <?php echo $post->title ?>
            </div>
            <div class="row justify-content-center g-4">
                <div class="col-8 col-md-8 col-lg-6">
                    <img src="<?php echo "../uploads/" . $post->image_url ?>" class="w-100 rounded-5 shadow-lg" alt="" height="350px">
                </div>
                <div class="col-8 col-md-4 col-lg-6 bg-body-tertiary">
                    <div class="row g-3">
                        <div class="col-12 fw-bold display-5"><?php echo $post->title ?></div>
                        <div class="col-12 fw-medium"><?php echo $post->subject ?></div>
                        <div class="col-12 small fw-light"><?php echo $post->description ?></div>
                        <div class="col-6"><?php echo $post->username ?></div>
                        <div class="col-12"><?php echo $post->created ?></div>
                    </div>
                </div>
            </div>
            <div class="display-5 my-5 text-primary text-center text-md-start">
                Explore More Posts
            </div>
            <div class="row g-3">
                <!-- Process the result set -->
                <?php if($result): ?>
                <!-- Output data of each row -->
                    <?php foreach ($result as $item): ?>
                            <div class="col-6 col-sm-6 col-md-3">
                                <a href="post.php?id=<?php echo $item->id ?>" class="text-decoration-none text-dark">
                                    <div class="card">
                                        <div class="post-img">
                                            <img src="<?php echo '../uploads/' . $item->image_url ?>" class="card-img-top" alt="..." style="height: 200px;">
                                            <div class="overlay">
                                                <span><?php echo $item->subject ?></span>
                                            </div>
                                        </div>
                                        <div class="card-body small">
                                            <span class="card-link"><?php echo $item->created ?></span>
                                            <span class="card-link float-end">by <?php echo $item->username ?></span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        
                    <?php endforeach; ?>  
                <?php endif; ?>
            </div>
         </div>
         
        </main>
        <!-- Footer -->
        <?php include '../includes/footer.php' ?>
        <!-- Bootstrap JavaScript Libraries -->
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
