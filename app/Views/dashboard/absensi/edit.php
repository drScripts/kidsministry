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

<form class="mt-5" action="<?= base_url('absensi/update') . '/' . $id; ?>" method="POST" enctype="multipart/form-data">
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
        <div class="row">
            <div class="col-md-6 align-self-center">
                <div class="input-group mb-3">
                    <div class="custom-file">
                        <input type="file" id="foto" class="custom-file-input" name="foto" accept="image/*" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                        <label id="labelFot" class="custom-file-label" for="inputGroupFile01"><?= $dataFoto['name'] == null ? 'Choose An Image' : $dataFoto['name']; ?></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group" data-aos="fade-right" data-aos-duration="500" data-aos-delay="900">
        <label for="video" class="white-fonts">Video</label>
        <div class="row">
            <div class="col-md-6 align-self-center">
                <div class="input-group mb-3">
                    <div class="custom-file">
                        <input type="file" name="video" id="video" class="custom-file-input" accept="video/*" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                        <label id='labelVid' class="custom-file-label" for="inputGroupFile01"><?= $dataVideo['name'] == null ? 'Choose An Video' : $dataVideo['name']; ?></label>
                    </div>
                </div>
            </div>
        </div>
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
            <label for="zoom" class="white-fonts">Zoom</label>
            <select name="zoom" id="zoom" class="form-control grey-fonts">
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
    <?php if ($komsel) : ?>
        <div class="form-group" data-aos="fade-right" data-aos-duration="500" data-aos-delay="1100">
            <label for="komsel" class="white-fonts">Komsel</label>
            <select name="komsel" id="komsel" class="form-control grey-fonts">
                <optgroup label='Default Value'>
                    <option value="<?= $data['absensi']['komsel']; ?>"><?= strtoupper($data['absensi']['komsel']); ?></option>
                </optgroup>
                <optgroup label="Options">
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </optgroup>
            </select>
        </div>
    <?php endif; ?>
    <?php if ($aba) : ?>
        <div class="form-group form-check" data-aos="fade-right" data-aos-duration="500">
            <label for="zoom-select" class="white-fonts">ABA</label>
            <div class="container">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="aba" id="1" value="1" <?= ($data['absensi']['aba'] == 1) ? 'checked' : ''; ?>>
                                <label class="form-check-label white-fonts" for="1">
                                    1
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="aba" id="2" value="2" <?= ($data['absensi']['aba'] == 2) ? 'checked' : ''; ?>>
                                <label class="form-check-label white-fonts" for="2">
                                    2
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="aba" id="3" value="3" <?= ($data['absensi']['aba'] == 3) ? 'checked' : ''; ?>>
                                <label class="form-check-label white-fonts" for="3">
                                    3
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="aba" id="4" value="4" <?= ($data['absensi']['aba'] == 4) ? 'checked' : ''; ?>>
                                <label class="form-check-label white-fonts" for="4">
                                    4
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="aba" id="5" value="5" <?= ($data['absensi']['aba'] == 5) ? 'checked' : ''; ?>>
                                <label class="form-check-label white-fonts" for="5">
                                    5
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="aba" id="6" value="6" <?= ($data['absensi']['aba'] == 6) ? 'checked' : ''; ?>>
                                <label class="form-check-label white-fonts" for="6">
                                    6
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="aba" id="7" value="7" <?= ($data['absensi']['aba'] == 7) ? 'checked' : ''; ?>>
                                <label class="form-check-label white-fonts" for="7">
                                    7
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <button type="submit" class="btn btn-primary mt-5" onclick="return confirm('Are You Sure Want To Update It?')">Submit</button>
</form>


<script>
    $('#foto').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $('#labelFot').html(fileName);
    });
    $('#video').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $('#labelVid').html(fileName);
    });
</script>

<?php if (!$update) : ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'The Google Api Token is Expired! Please Contact The Admin',
            confirmButtonText: 'Refresh',
            showCancelButton: true,
            allowOutsideClick: false,
            cancelButtonText: 'Back',
        }).then((result) => {
            if (result.isConfirmed) {
                location.reload();
            } else {
                window.history.back();
                return false;
            }
        });
    </script>
<?php endif; ?>

<?= $this->endSection(); ?>