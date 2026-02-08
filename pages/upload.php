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
            <div class="display-4 my-3 text-primary">
                Upload Photo
            </div>
            <div class="row">
                <div class="col-12">
                    <form action="" method="" class="p-2 rounded bg-body-tertiary">
                        <div class="p-2">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" required placeholder="Enter Title Here">
                        </div>
                        <div class="p-2">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="5" placeholder="Enter Description Here"></textarea>
                        </div>
                        <div class="p-2">
                            <label class="form-label">Photo</label>
                            <input type="file" name="title" class="form-control" required >
                        </div>
                        <div class="p-2">
                            <button type="submit" class="btn btn-secondary my-3">Upload Photo</button>
                        </div>
                        
                    </form>
                </div>
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
