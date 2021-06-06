<?= $this->extend('dashboard/bootstraper'); ?>
<?= $this->section('content'); ?>
<h1 data-aos="fade-right" data-aos-duration="500" data-aos-delay="300">Edit <?= $userdata->username; ?></h1>


<?php

if ($validation->hasError('username') && $validation->hasError('email')) {
    echo "
    <script>
        demo.dangerNotification('top', 'right', '<b>Failed Update User Data</b><br>Check Your Username And Email');
    </script>
    ";
} elseif ($validation->hasError('username')) {
    echo "
    <script>
        demo.dangerNotification('top', 'right', '<b>Failed Update User Data</b><br>Check Your Username');
    </script>
    ";
} elseif ($validation->hasError('email')) {
    echo "
    <script>
        demo.dangerNotification('top', 'right', '<b>Failed Update User Data</b><br>Check Your Email');
    </script>
    ";
};

?>


<form class="mt-5" action="<?= base_url('/team/update') . '/' . $userdata->userid; ?>" method="POST">
    <?= csrf_field(); ?>
    <input type="hidden" name="_method" value="PUT">
    <div class="form-group" data-aos="fade-right" data-aos-duration="500" data-aos-delay="500">
        <label for="username" class="white-fonts">Username</label>
        <input type="text" name="username" class="<?= ($validation->hasError('username')) ? 'is-invalid' : ''; ?> form-control" placeholder="Input Your Username" id="username" value="<?= (old('username')) ? old('username') : $userdata->username; ?>" />

        <div class="invalid-feedback ">
            <?= $validation->getError('username'); ?>
        </div>
    </div>
    <div class="form-group" data-aos="fade-right" data-aos-duration="500" data-aos-delay="700">
        <label for="email" class="white-fonts">Email</label>
        <input type="email" class="form-control <?= ($validation->hasError('email')) ? 'is-invalid' : ''; ?>" placeholder="Input Your Email" name="email" id="email" value="<?= (old('email')) ? old('email') : $userdata->email; ?>" />
        <div class="invalid-feedback ">
            <?= $validation->getError('email'); ?>
        </div>
    </div>
    <div class="form-group form-check" data-aos="fade-right" data-aos-duration="500" data-aos-delay="900">
        <label for="groups" class="white-fonts" class="white-fonts">Children Role</label>
        <select name="groups" id="groups" class="form-control white-fonts <?= ($validation->hasError('groups')) ? 'is-invalid' : ''; ?>">
            <optgroup label="Current Option">
                <option value="<?= $userdata->groupId; ?>"><?= $userdata->name; ?></option>
            </optgroup>
            <optgroup label="All Options">
                <?php foreach ($group as $g) : ?>
                    <option value="<?= $g->id; ?>"><?= $g->name; ?></option>
                <?php endforeach; ?>
            </optgroup>
        </select>
        <div class="invalid-feedback ">
            <?= $validation->getError('groups'); ?>
        </div>
    </div>
    <div class="form-group form-check" data-aos="fade-right" data-aos-duration="500" data-aos-delay="1100">
        <label for="cabang" class="white-fonts">Cabang</label>
        <select name="cabang" id="cabang" class="form-control white-fonts <?= ($validation->hasError('cabang')) ? 'is-invalid' : ''; ?>">
            <optgroup label="Current Value">
                <option value="<?= $userdata->id_cabang; ?>"><?= $userdata->nama_cabang; ?></option>
            </optgroup>
            <optgroup label="All Option">
                <?php foreach ($cabangs as $cabang) : ?>
                    <option value="<?= $cabang->id_cabang; ?>"><?= $cabang->nama_cabang; ?></option>
                <?php endforeach; ?>
            </optgroup>
        </select>
        <div class="invalid-feedback ">
            <?= $validation->getError('cabang'); ?>
        </div>
    </div>
    <button type="submit" class="btn btn-primary mt-5" data-aos="fade-right" data-aos-duration="500" data-aos-delay="1300">Submit</button>
</form>

<script src="<?= base_url('/assets/js/logics/team.js'); ?>"></script>

<?= $this->endSection(); ?>