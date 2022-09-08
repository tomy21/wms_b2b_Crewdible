<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Crewdible B2B | Login</title>

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
            <img src="<?= base_url() ?>/dist/img/logocrew.png" alt="Logo Crewdible" width="80%" height="50"
                style="object-fit:fill;">
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <h2 class="card-header"><?= lang('Auth.forgotPassword') ?></h2>
            <div class="card-body">

                <?= view('Myth\Auth\Views\_message_block') ?>

                <p><?= lang('Auth.enterEmailForInstructions') ?></p>

                <form action="<?= url_to('forgot') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="form-group">
                        <label for="email"><?= lang('Auth.emailAddress') ?></label>
                        <input type="email"
                            class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>"
                            name="email" aria-describedby="emailHelp" placeholder="<?= lang('Auth.email') ?>">
                        <div class="invalid-feedback">
                            <?= session('errors.email') ?>
                        </div>
                    </div>

                    <br>

                    <button type="submit"
                        class="btn btn-success btn-block"><?= lang('Auth.sendInstructions') ?></button>

                </form>
                <br>
                <p><a href="<?= site_url('/'); ?>" class="text-center">Back to Login</a></p>
            </div>
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