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
                                    <h2 class="card-header black-fonts"><?= lang('Auth.forgotPassword') ?></h2>
                                    <br>
                                </div>
                                <?= view('Myth\Auth\Views\_message_block') ?>
                                <p class="text-center black-fonts"><?= lang('Auth.enterEmailForInstructions') ?></p>
                                <br>
                                <form class="user" action="<?= route_to('forgot') ?>" method="post">
                                    <?= csrf_field() ?>
                                    <div class="form-group">
                                        <label for="email" class="black-fonts"><?= lang('Auth.emailAddress') ?></label>
                                        <input type="email" class="form-control black-fonts <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>" name="email" aria-describedby="emailHelp" placeholder="<?= lang('Auth.email') ?>">
                                        <div class="invalid-feedback">
                                            <?= session('errors.email') ?>
                                        </div>
                                    </div>

                                    <button class="btn btn-primary btn-user btn-block" type="submit" data-aos="fade-left" data-aos-duration="700" data-aos-delay="900"><?= lang('Auth.sendInstructions') ?></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->include('template/footers'); ?>