<?= $this->include('template/header'); ?>
<div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center mt-5">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5 py-5" data-aos="zoom-in" data-aos-duration="300" style="background-color: rgba(238, 241, 241, 1);">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block" data-aos="flip-right" data-aos-duration="700" data-aos-delay="500">
                            <img src="<?= base_url(); ?>/assets/img/Artboard.png" alt="">
                        </div>
                        <div class="col-lg-6 mt-5">
                            <div class="p-5">
                                <div class="text-center" data-aos="zoom-in" data-aos-duration="700" data-aos-delay="500">
                                    <h1 class="h4 text-gray-900 mb-4 black-fonts">Welcome Back!</h1>
                                </div>
                                <?= view('Myth\Auth\Views\_message_block') ?>
                                <form class="user" action="<?= route_to('login') ?>" method="post">
                                    <?= csrf_field() ?>
                                    <div class="form-group" data-aos="fade-left" data-aos-duration="700" data-aos-delay="600">
                                        <input type="email" class="form-control form-control-user black-fonts <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>" name="login" aria-describedby="emailHelp" placeholder="Enter Email Address..." email required>
                                        <div class="invalid-feedback">
                                            <?= session('errors.login') ?>
                                        </div>
                                    </div>

                                    <div class="form-group" data-aos="fade-left" data-aos-duration="700" data-aos-delay="700">
                                        <div class="input-group">
                                            <div class="input-group-prepend" id='viewPassword'>
                                                <div class="input-group-text" id="icon">
                                                    <i class="fas fa-eye-slash black-fonts"></i>
                                                </div>
                                            </div>
                                            <input id='password' type="password" class="form-control form-control-user black-fonts <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" name="password" placeholder="Password" minlength="8" password required>
                                        </div>
                                        <div class="invalid-feedback">
                                            <?= session('errors.password') ?>
                                        </div>
                                    </div>

                                    <?php if ($config->allowRemembering) : ?>
                                        <div class="form-group" data-aos="fade-left" data-aos-duration="700" data-aos-delay="800">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" name="remember" class="custom-control-input <?php if (old('remember')) : ?> checked <?php endif ?>>" id="customCheck">
                                                <label class="custom-control-label black-fonts" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <button class="btn btn-primary btn-user btn-block" type="submit" data-aos="fade-left" data-aos-duration="700" data-aos-delay="900">Login</button>

                                </form>
                                <hr data-aos="fade-left" data-aos-duration="700" data-aos-delay="1000">
                                <!-- <div class="text-center">
                                    <a class="small" href="forgot-password.html">Forgot Password?</a>
                                </div> -->
                                <?php if ($config->allowRegistration) : ?>
                                    <div class="text-center" data-aos="fade-left" data-aos-duration="700" data-aos-delay="1100">
                                        <a class="small" href="<?= base_url(); ?>/register">Create an Account!</a>
                                    </div>
                                <?php endif; ?>
                                <?php if ($config->activeResetter) : ?>
                                    <div class="text-center" data-aos="fade-left" data-aos-duration="700" data-aos-delay="1100">
                                        <a class="small" href="<?= route_to('forgot') ?>"><?= lang('Auth.forgotYourPassword') ?></a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#viewPassword').mousedown(function() {
        $('#icon').html(`<i class="fas fa-eye black-fonts"></i>`);
        $('#password').attr('type', 'text');
    }).mouseup(function() {
        $('#icon').html(`<i class="fas fa-eye-slash black-fonts"></i>`);
        $('#password').attr('type', 'password');
    });
</script>
<?= $this->include('template/footers'); ?>