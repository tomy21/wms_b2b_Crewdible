<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url() ?>/dist/img/favicon.png">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <title>Crewdible X Bukalapak</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= base_url() ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url() ?>/dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <img src="<?= base_url() ?>/dist/img/logocrew.png" alt="" width="300px" height="60px">
            <br>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">
                    <b>Crewdible </b><b> </b><b>B2B</b>
                </p>

                <?= view('Myth\Auth\Views\_message_block') ?>

                <form action="<?= url_to('login') ?>" method="post">
                    <?= csrf_field() ?>

                    <?php if ($config->validFields === ['email']) : ?>
                    <div class="input-group mb-3">
                        <?php
                            $isInvalidUser = (session()->getFlashdata('errEmail')) ? 'is-invalid' : '';
                            ?>
                        <input type="email"
                            class="form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>"
                            placeholder="<?= lang('Auth.email') ?>" name="email" autofocus autocomplete="off">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        <div class="invalid-feedback">
                            <?= session('errors.login') ?>
                        </div>
                        <?php else : ?>
                        <div class="input-group mb-3">
                            <?php
                                $isInvalidUser = (session()->getFlashdata('errEmail')) ? 'is-invalid' : '';
                                ?>
                            <input type="email"
                                class="form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>"
                                name="login" placeholder="<?= lang('Auth.emailOrUsername') ?>"
                                placeholder="<?= lang('Auth.email') ?>" name="email" autofocus autocomplete="off">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                            <div class="invalid-feedback">
                                <?= session('errors.login') ?>
                            </div>
                            <?php endif; ?>

                        </div>

                        <div class="input-group mb-3">
                            <?php
                                $isInvalPass = (session()->getFlashdata('errPass')) ? 'is-invalid' : '';
                                ?>
                            <input type="password"
                                class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>"
                                placeholder="<?= lang('Auth.password') ?>" placeholder="<?= lang('Auth.password') ?>"
                                name="password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                            <div class="invalid-feedback">
                                <?= session('errors.password') ?>
                            </div>
                            <?php
                                if (session()->getFlashdata('errPass')) {
                                    echo '
              <div id="validationServer03Feedback" class="invalid-feedback">
                ' . session()->getFlashdata('errPass') . '
              </div>
              ';
                                }
                                ?>
                        </div>

                        <div class="row">
                            <!-- /.col -->
                            <div class="col-12">
                                <button type="submit" class="btn btn-success btn-block">Sign In</button>
                            </div>
                            <!-- /.col -->

                        </div>
                        <br>
                        <?php if ($config->activeResetter) : ?>
                        <div class="row">
                            <!-- /.col -->
                            <div class="col-12">
                                <a class="btn btn-sm btn-info"
                                    href="<?= url_to('forgot') ?>"><?= lang('Auth.forgotYourPassword') ?></a>
                            </div>
                            <!-- /.col -->
                        </div>
                        <?php endif; ?>

                        <!-- <?php if ($config->allowRegistration) : ?>
                        <p><a href="<?= url_to('register') ?>"><?= lang('Auth.needAnAccount') ?></a></p>
                        <?php endif; ?> -->

                    </div>
                </form>
                <!-- /.login-card-body -->
            </div>

        </div>
        <!-- /.login-box -->

        <!-- jQuery -->
        <script src="<?= base_url() ?>/plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap 4 -->
        <script src="<?= base_url() ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE App -->
        <script src="<?= base_url() ?>/dist/js/adminlte.min.js"></script>
</body>

</html>