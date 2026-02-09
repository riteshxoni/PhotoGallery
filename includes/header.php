 <?php
    session_start();
 ?>
 <header>
    <nav class="navbar navbar-expand-lg bg-bg-body-tertiary shadow-lg">
        <div class="container">
            <a class="navbar-brand fw-lighter" href="/PHOTOGALLARY/">
                <img src="/PHOTOGALLARY/assets/img/logo.png" alt="" class="rounded-5" height="40px">
                <span class="ms-1">My Gallary</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="bi bi-list display-3 fw-bold"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/PHOTOGALLARY/pages/upload.php">Upload Photo</a>
                    </li>
                    <li class="nav-item me-2">
                        <a class="nav-link" href="/PHOTOGALLARY/">Gallary</a>
                    </li>
                    <?php if(isset($_SESSION['username'])): ?> 
                        <div class="dropdown">
                            <a href="#" class="d-flex align-items-center link-body-emphasis text-decoration-none dropdown-toggle pt-1"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="/PHOTOGALLARY/assets//img/profile.png" alt="profile" width="32" height="32" class="rounded-circle">
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end text-small shadow">
                                <li>
                                <span class="dropdown-item-text">
                                    <a class="text-dark text-decoration-none" href="/PHOTOGALLARY/index.php"><?php echo htmlspecialchars($_SESSION['username']); ?></a>
                                </span>
                                </li>
                                <li><a class="dropdown-item" href="/PHOTOGALLARY/pages/upload.php">New Photo...</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="/PHOTOGALLARY/controller/logout.php">Sign out</a></li>
                            </ul>
                        </div>

                    <?php else: ?>  
                        <li class="nav-item">
                            <a class="nav-link" href="/PHOTOGALLARY/pages/login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/PHOTOGALLARY/pages/register.php">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>
 <?php
    session_abort();
 ?>
 