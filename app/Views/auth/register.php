<?= $this->include('template/header'); ?>

<div class="container">
    <div class="card o-hidden border-0 shadow-lg" style="margin-top:100px;" data-aos="zoom-in" data-aos-duration="500">
        <div class="card-body" style="background-color: rgba(238, 241, 241, 1);">
            <!-- Nested Row within Card Body -->
            <div class="row mt-5 mb-5 mx-3">
                <div class="col-lg-5 d-none d-lg-block" data-aos="flip-right" data-aos-duration="700" data-aos-delay="300">
                    <img src="<?= base_url(); ?>/assets/img/Artboard.png" alt="">
                </div>
                <div class="col-lg-7">
                    <div class="p-5">
                        <div class="text-center" data-aos="zoom-in" data-aos-duration="700" data-aos-delay="500">
                            <h1 class="h4 text-gray-900 mb-4 black-fonts">Create an Account!</h1>
                        </div>
                        <?= view('Myth\Auth\Views\_message_block') ?>
                        <form class="user" action="<?= route_to('register') ?>" method="post">
                            <?= csrf_field() ?>

                            <div class="form-group row" data-aos="fade-left" data-aos-duration="700" data-aos-delay="500">
                                <div class="col-sm mb-0">
                                    <input type="text" class="form-control form-control-user black-fonts " placeholder="Username" name="username" value="<?= old('username') ?>" required>
                                </div>
                            </div>

                            <div class="form-group mb-2" data-aos="fade-left" data-aos-duration="700" data-aos-delay="600">
                                <input type="email" class="form-control form-control-user black-fonts mb-sm-0 " placeholder="Email Address" name="email" value="<?= old('email') ?>" required email>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-6 mb-2 mb-sm-0" data-aos="fade-right" data-aos-duration="700" data-aos-delay="700">
                                    <div class="input-group">
                                        <div class="input-group-prepend" id='viewPassword'>
                                            <div class="input-group-text" id="icon">
                                                <i class="fas fa-eye-slash black-fonts"></i>
                                            </div>
                                        </div>
                                        <input id='password' type="password" name="password" class="form-control form-control-user black-fonts" placeholder="Password" required minlength="8">
                                    </div>
                                </div>

                                <div class="col-sm-6 mb-sm-0" data-aos="fade-left" data-aos-duration="700" data-aos-delay="700">
                                    <input type="password" class="form-control form-control-user black-fonts  " name="pass_confirm" placeholder="Repeat Password" required>
                                </div>

                            </div>

                            <div class="form-group" data-aos="fade-left" data-aos-duration="700" data-aos-delay="800">
                                <div class="mb-2 mb-sm-0">
                                    <select class="custom-select form-control black-fonts cabang" name="region" id="section" required>
                                        <option value="" class="cabang"> Select Cabang Region </option>
                                        <?php array_pop($cabangs); ?>
                                        <?php foreach ($cabangs as $cabang) : ?>
                                            <option class="cabang" value="<?= $cabang['id_cabang']; ?>"><?= $cabang['nama_cabang']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <button class="btn btn-primary btn-user btn-block" type="submit" data-aos="fade-left" data-aos-duration="700" data-aos-delay="900">Register Account</button>
                        </form>
                        <hr data-aos="fade-left" data-aos-duration="700" data-aos-delay="900">
                        <!-- <div class="text-center">
                            <a class="small" href="forgot-password.html">Forgot Password?</a>
                        </div> -->
                        <div class="text-center" data-aos="fade-left" data-aos-duration="700" data-aos-delay="1000">
                            <a class="small" href="<?= base_url(); ?>">Already have an account? Login!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('#viewPassword').on('click', function() {
        if ($('#password').attr('type') == 'password') {
            $('#icon').html(`<i class="fas fa-eye black-fonts"></i>`);
            $('#password').attr('type', 'text');
        } else {
            $('#icon').html(`<i class="fas fa-eye-slash black-fonts"></i>`);
            $('#password').attr('type', 'password');
        }
    });
</script>
<?= $this->include('template/footers'); ?>