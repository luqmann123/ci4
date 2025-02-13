<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login</title>
    <link href="<?php echo base_url('admin') ?>/css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body style="background-image: url('/admin/assets/img/plz.jpg'); background-size: cover; background-position: center;">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Login</h3>
                                </div>
                                <div class="card-body">
                                <?= form_open(base_url('admin/login')) ?>    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>
    <div class="form-floating mb-3">
        <input class="form-control" id="inputEmail" name="username" type="text" placeholder="Enter your username" value="<?= old('username') ?>" required />
        <label for="inputEmail">Username</label>
    </div>
    <div class="form-floating mb-3">
        <input class="form-control" id="inputPassword" name="password" type="password" placeholder="Password" required />
        <label for="inputPassword">Password</label>
    </div>
    <div class="form-check mb-3">
        <input class="form-check-input" id="inputRememberPassword" name="remember_me" type="checkbox" value="1" />
        <label class="form-check-label" for="inputRememberPassword">Remember Password</label>
    </div>
    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
        <a class="small" href="password.html">Forgot Password?</a>
        <button type="submit" class="btn btn-primary">Login</button>
    </div>
    <?= form_close() ?>

                                </div>
                                <!-- <div class="card-footer text-center py-3">
                                    <div class="small">
                                        <a href="register.html">Need an account? Sign up!</a>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2021</div>
                        <div>
                            <!-- <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a> -->
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="<?php echo base_url('admin') ?>/js/scripts.js"></script>
</body>

</html>