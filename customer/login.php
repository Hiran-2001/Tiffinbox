<?php include 'header.php'; ?>

            <div class="container-xxl py-5 bg-dark hero-header mb-5">
                <div class="container text-center my-5 pt-5 pb-4">
                    <h1 class="display-3 text-white mb-3 animated slideInDown">Customer Login</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center text-uppercase">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Login</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Navbar & Hero End -->
        <!-- Login/Register Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h5 class="section-title ff-secondary text-center text-primary fw-normal">Customer Login</h5>
                    <h1 class="mb-5">Sign In to Your Account</h1>
                </div>

                <div class="row justify-content-center">
                    <!-- Login Form -->
                    <div class="col-md-6 col-lg-5">
                        <div class="wow fadeInUp" data-wow-delay="0.1s">
                            <div class="bg-light p-5 rounded shadow">
                                <div class="text-center mb-4">
                                    <i class="fa fa-user-circle fa-3x text-primary mb-3"></i>
                                    <h4 class="text-primary">Welcome Back!</h4>
                                    <p class="text-muted">Please sign in to your account</p>
                                </div>
                                
                                <form method="POST" action="loginaction.php">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                                                <label for="username"><i class="fa fa-user me-2"></i>Username</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-floating">
                                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                                <label for="password"><i class="fa fa-lock me-2"></i>Password</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                                <label class="form-check-label" for="remember">
                                                    Remember me
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary w-100 py-3" type="submit" name="login" value="login">
                                                <i class="fa fa-sign-in-alt me-2"></i>Sign In
                                            </button>
                                        </div>
                                        <div class="col-12 text-center">
                                            <a href="#" class="text-primary">Forgot Password?</a>
                                        </div>
                                        <div class="col-12 text-center">
                                            <hr>
                                            <p class="mb-0">Don't have an account? <a href="signup.php" class="text-primary fw-bold">Sign Up</a></p>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Login End -->

<?php include 'footer.php'; ?>