<?= $this->extend('dashboard/bootstraper'); ?>
<?= $this->section('content'); ?>
<h1 data-aos="zoom-in" data-aos-duration="500">Edit Absensi</h1>

<?php

if (user()->toArray()['region'] == 'super') {
    $class = ' ';
} else {
    $class = 'disabled';
}
?>

<form class="mt-5" action="<?= base_url('absensi/update') . '/' . $id; ?>" method="POST">
    <?= csrf_field(); ?>
    <input type="hidden" name="_method" value="PUT">
    <div class="form-group white-fonts" data-aos="fade-right" data-aos-duration="500" data-aos-delay="300">
        <label for="children_name">Children Name</label>
        <input type="text" class="form-control grey-fonts" id="children_name" aria-describedby="children name" value="<?= $data['children']['children_name']; ?>" <?= $class; ?>>
    </div>
    <div class="form-group" data-aos="fade-right" data-aos-duration="500" data-aos-delay="500">
        <label for="pembimbing_name" class="white-fonts">Pembimbing Name</label>
        <input type="text" class="form-control grey-fonts" id="pembimbing_name" value="<?= $data['pembimbing']['name_pembimbing']; ?>" <?= $class; ?>>
    </div>
    <div class="form-group" data-aos="fade-right" data-aos-duration="500" data-aos-delay="700">
        <label for="foto" class="white-fonts">Foto</label>
        <select name="foto" id="foto" class="form-control grey-fonts" <?= $class; ?>>
            <optgroup label='Default Value'>
                <option value="<?= $data['absensi']['image']; ?>"><?= strtoupper($data['absensi']['image']); ?></option>
            </optgroup>
            <optgroup label="Options">
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </optgroup>
        </select>
    </div>
    <div class="form-group" data-aos="fade-right" data-aos-duration="500" data-aos-delay="900">
        <label for="video" class="white-fonts">Video</label>
        <select name="video" id="video" class="form-control grey-fonts" <?= $class; ?>>
            <optgroup label='Default Value'>
                <option value="<?= $data['absensi']['video']; ?>"><?= strtoupper($data['absensi']['video']); ?></option>
            </optgroup>
            <optgroup label="Options">
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </optgroup>
        </select>
    </div>
    <?php if ($quiz) : ?>
        <div class="form-group" data-aos="fade-right" data-aos-duration="500" data-aos-delay="1100">
            <label for="quiz" class="white-fonts">Quiz</label>
            <select name="quiz" id="quiz" class="form-control grey-fonts">
                <optgroup label='Default Value'>
                    <option value="<?= $data['absensi']['quiz']; ?>"><?= strtoupper($data['absensi']['quiz']); ?></option>
                </optgroup>
                <optgroup label="Options">
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </optgroup>
            </select>
        </div>

    <?php endif; ?>
    <?php if ($zoom) : ?>
        <div class="form-group" data-aos="fade-right" data-aos-duration="500" data-aos-delay="1100">
            <label for="quiz" class="white-fonts">Zoom</label>
            <select name="zoom" id="quiz" class="form-control grey-fonts">
                <optgroup label='Default Value'>
                    <option value="<?= $data['absensi']['zoom']; ?>"><?= strtoupper($data['absensi']['zoom']); ?></option>
                </optgroup>
                <optgroup label="Options">
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </optgroup>
            </select>
        </div>
    <?php endif; ?>
    <button type="submit" class="btn btn-primary mt-5" onclick="return confirm('Are You Sure Want To Update It?')">Submit</button>
</form>

<?= $this->endSection(); ?>