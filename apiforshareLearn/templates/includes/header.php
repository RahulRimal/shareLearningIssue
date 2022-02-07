<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Sabaeko Books</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URI; ?>templates/css/boot/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Custom Css -->
    <link rel="stylesheet" href="<?php echo BASE_URI; ?>templates/css/style.css">

    <!-- lightslider css -->
    <link rel="stylesheet" href="<?php echo BASE_URI; ?>templates/css/lightslider.css">

    <!-- Ckeditor Js -->
    <script src="<?php echo BASE_URI; ?>templates/js/ckeditor/ckeditor.js"></script>

</head>

<body>

    <!-- Top bar starts here  -->

    <section id="top-bar">
        <div class="container">
            <div class="row">
                <div class="top-bar-content d-flex justify-content-between justify-content-lg-around px-5 px-lg-0">
                    <div class="topbar-mail">
                        <p>Krishna@mail.com</p>
                    </div>
                    <div class="topbar-links">
                        <i class="fa fa-facebook" aria-hidden="true"></i>
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Top bar ends here  -->

    <!-- Header starts here -->

    <header id="header" class="sticky-top">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container d-flex justify-content-between">
                <div class=" d-flex align-items-center">
                    <a class="navbar-brand" href="<?php echo BASE_URI; ?>">Sabaeko Books</a>
                    <form class="form-inline d-none d-md-flex" role="form">
                        <div class="input-group">
                            <input type="text" class="form-control shadow-none" placeholder="Search" aria-label="SearchHere" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-light" type="button">
                                    <i class="fa fa-search text-danger" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <? //php if (isLoggedIn()) : 
                ?>
                <!-- <div class="user-profile d-flex d-md-none">
                        <div class="nav-item dropdown d-flex align-items-center">
                            <img class="nav-link circle-avatar-icon p-1" src="<? //php echo BASE_URI 
                                                                                ?>images/<? //php echo currentUserInfo($_SESSION['user_id'])->picture; 
                                                                                                                ?>" alt="">
                            <a class="nav-link active dropdown-toggle d-flex align-items-center text-light p-0" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><? //php echo currentUserInfo($_SESSION['user_id'])->firstName; 
                                                                                                                                                                                                            ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">CSIT</a></li>
                                <li><a class="dropdown-item" href="#">BCA</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">BIT</a></li>
                            </ul>
                        </div>

                    </div> -->

                <? //php endif; 
                ?>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-around" id="navbarSupportedContent">
                    <ul class="navbar-nav mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active d-flex flex-column align-items-center" href="<?php echo BASE_URI; ?>"><i class="fa fa-home" aria-hidden="true"></i>Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex flex-column align-items-center" href="all-posts.php?user=<?php echo $_SESSION['user_id']; ?>"> <i class="fa fa-shopping-cart" aria-hidden="true"></i>My Books</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex flex-column align-items-center" href="#"> <i class="fas fa-comment-dots"></i>Messages</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link d-flex flex-column align-items-center" href="#"><i class="fas fa-bolt"></i>Notifications</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex flex-column align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-book-open"></i>Classwise
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">CSIT</a></li>
                                <li><a class="dropdown-item" href="#">BCA</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">BIT</a></li>
                            </ul>
                        </li>
                    </ul>
                    <form class="form-inline d-flex d-md-none align-items-center my-2 my-lg-0">
                        <input style="height: 40px;" class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-info my-2 my-sm-0" type="submit">Search</button>
                    </form>
                    <ul class="navbar-nav mb-2 mt-2 mb-lg-0">
                        <?php if (!isLoggedIn()) : ?>
                            <div class="login-signup d-flex align-items-center">
                                <li class="nav-item">
                                    <a class="nav-link me-2" href="#">LogIn</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="btn btn-light">SignUp</a>
                                </li>
                            </div>
                        <?php else : ?>
                            <div class="logout-form d-lg-block d-md-none">
                                <form action="logout.php" method="post">
                                    <button type="submit" name="doLogout" class="btn btn-primary w-100 h6">LogOut</button>
                                </form>
                            </div>
                            <div class="user-profile d-lg-flex d-md-none">
                                <div class="nav-item dropdown d-flex align-items-center">
                                    <img class="nav-link circle-avatar-icon p-1" src="<?php echo BASE_URI ?>images/<?php echo currentUserInfo($_SESSION['user_id'])->picture; ?>" alt="">
                                    <a class="nav-link active dropdown-toggle d-flex align-items-center text-light p-0" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?php echo currentUserInfo($_SESSION['user_id'])->firstName; ?>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item" href="#">CSIT</a></li>
                                        <li><a class="dropdown-item" href="#">BCA</a></li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="#">BIT</a></li>
                                    </ul>
                                </div>

                            </div>
                        <?php endif; ?>
                </div>
                </ul>
            </div>
            </div>
        </nav>

        <?php displayMessage(); ?>

    </header>

    <!-- Header ends here -->

    <!-- Hero Starts Here  -->

    <!-- <section id="hero">
        <div class="container col-xxl-8 px-4 py-5">
            <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
                <div class="col-10 col-sm-8 col-lg-6">
                    <img src="https://cdn.pixabay.com/photo/2020/01/21/20/44/mountains-4783955__340.jpg"
                        class="d-block mx-lg-auto img-fluid" alt="Bootstrap Themes" width="700" height="300"
                        loading="lazy">
                </div>
                <div class="col-lg-6">
                    <h1 class="display-5 fw-bold lh-1 mb-3">Responsive left-aligned hero with image</h1>
                    <p class="lead">Quickly design and customize responsive mobile-first sites with Bootstrap, the
                        world’s most popular front-end open source toolkit, featuring Sass variables and mixins,
                        responsive grid system, extensive prebuilt components, and powerful JavaScript plugins.</p>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                        <button type="button" class="btn btn-primary btn-lg px-4 me-md-2">Primary</button>
                        <button type="button" class="btn btn-outline-secondary btn-lg px-4">Default</button>
                    </div>
                </div>
            </div>
        </div>
    </section> -->

    <!-- Hero ends here -->