<?= $this->include('template/header'); ?>
<div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center mt-3">
        <div class="col-xl-8 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5 py-2" data-aos="zoom-in" data-aos-duration="300" style="background-color: rgba(238, 241, 241, 1);">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row"> 
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center" data-aos="zoom-in" data-aos-duration="700" data-aos-delay="500">
                                    <h4 class="card-header black-fonts"><?= lang('Auth.enterCodeEmailPassword') ?></h4>
                                </div>
                                <br>
                                <?= view('Myth\Auth\Views\_message_block') ?> 
                                <form class="user" action="<?= route_to('reset-password') ?>" method="post">
                                    <?= csrf_field() ?>
                                    <div class="form-group">
                                        <label for="token" class="black-fonts"><?= lang('Auth.token') ?></label>
                                        <input type="text" class="form-control black-fonts <?php if (session('errors.token')) : ?>is-invalid<?php endif ?>" name="token" placeholder="<?= lang('Auth.token') ?>" value="<?= old('token', $token ?? '') ?>">
                                        <div class="invalid-feedback">
                                            <?= session('errors.token') ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="black-fonts"><?= lang('Auth.email') ?></label>
                                        <input type="email" class="form-control black-fonts <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>" name="email" aria-describedby="emailHelp" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>">
                                        <div class="invalid-feedback">
                                            <?= session('errors.email') ?>
                                        </div>
                                    </div>
 
                                    <div class="form-group">
                                        <label for="password" class="black-fonts"><?= lang('Auth.newPassword') ?></label>
                                        <input type="password" class="form-control black-fonts <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" name="password" placeholder="Input New Password">
                                        <div class="invalid-feedback">
                                            <?= session('errors.password') ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="pass_confirm" class="black-fonts"><?= lang('Auth.newPasswordRepeat') ?></label>
                                        <input type="password" class="form-control black-fonts <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>" name="pass_confirm" placeholder="Repeat New Password">
                                        <div class="invalid-feedback">
                                            <?= session('errors.pass_confirm') ?>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary btn-user btn-block" type="submit" data-aos="fade-left" data-aos-duration="700" ><?=lang('Auth.resetPassword')?></button>
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