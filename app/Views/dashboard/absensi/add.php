<?= $this->extend('dashboard/bootstraper'); ?>
<?= $this->section('content'); ?>
<h1 data-aos="fade-right" data-aos-duration="500" data-aos-delay="300">Add Absensi</h1>


<?php
if ($validation->hasError('pembimbing') || $validation->hasError('children') || $validation->hasError('quiz') || $validation->hasError('video') || $validation->hasError('picture')) {
    echo "
    <script>
        demo.dangerNotification('top', 'right', '<b>Failed Add Absensi</b><br>Check Your Input');
    </script>
    ";
}

if ($validation->hasError('video')) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            ' . $validation->getError('video') . '
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <i class="tim-icons icon-simple-remove"></i>
            </button>
         </div>';
    echo  "<script>
    Swal.fire({
    icon: 'error',
    title: 'Failed !',
    text: 'If The Error Because The Limit Of File Size Just Contact Me!', 
  })</script>";
}

if ($validation->hasError('picture')) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            ' . $validation->getError('picture') . '
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <i class="tim-icons icon-simple-remove"></i>
            </button>
          </div>';
    echo  "<script>
    Swal.fire({
    icon: 'error',
    title: 'Failed !',
    text: 'If The Error Because The Limit Of File Size Just Forward The File To My WhatshApp!', 
  })</script>";
}

if (session()->getFlashData('success_add')) {
    echo "<script>
        Swal.fire({
        icon: 'success',
        title: 'Success !',
        text: '" . session()->getFlashData('success_add') . "', 
      })</script>";
}


?>

<form action="<?= base_url('/absensi/insert'); ?>" method="POST" enctype="multipart/form-data">

    <?= csrf_field(); ?>
    <div class="form-group form-check" data-aos="fade-right" data-aos-duration="500" data-aos-delay="500">
        <label for="pembimbing-select" class="white-fonts">Pembimbing Name</label>
        <select name="pembimbing" id="pembimbing-select" class="form-control grey-fonts <?= ($validation->hasError('pembimbing')) ? 'is-invalid' : ''; ?>" required>
            <option value="">Select Pembimbing Name</option>
            <?php foreach ($pembimbings as $pembimbing) : ?>
                <option value="<?= $pembimbing['id_pembimbing']; ?>">
                    <?= $pembimbing['name_pembimbing']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <div class="invalid-feedback ">
            <?= $validation->getError('pembimbing'); ?>
        </div>
    </div>

    <div class="form-group form-check" data-aos="fade-right" data-aos-duration="500" data-aos-delay="700">
        <label for="children-select" class="white-fonts ">Children Name</label>
        <select name="children" id="children-select" class="form-control grey-fonts <?= ($validation->hasError('children')) ? 'is-invalid' : ''; ?>" required>

        </select>
        <div class="invalid-feedback ">
            <?= $validation->getError('children'); ?>
        </div>
    </div>

    <?php if ($quiz) : ?>
        <div class="form-group form-check" data-aos="fade-right" data-aos-duration="500" data-aos-delay="900">
            <label for="quiz-select" class="white-fonts">Children Quiz</label>
            <select name="quiz" id="quiz-select" class="form-control grey-fonts <?= ($validation->hasError('quiz')) ? 'is-invalid' : ''; ?>" required>
                <option value="">Select Children Quiz</option>
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select>
            <div class="invalid-feedback ">
                <?= $validation->getError('quiz'); ?>
            </div>
        </div>
    <?php endif; ?>
    <?php if ($zoom) : ?>
        <div class="form-group form-check" data-aos="fade-right" data-aos-duration="500" data-aos-delay="900">
            <label for="zoom-select" class="white-fonts">Children Zoom</label>
            <select name="zoom" id="zoom-select" class="form-control grey-fonts <?= ($validation->hasError('zoom')) ? 'is-invalid' : ''; ?>" required>
                <option value="">Select Children Zoom</option>
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select>
            <div class="invalid-feedback">
                <?= $validation->getError('zoom'); ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="d-flex justify-content-center mt-5">
        <div class="row text-center">
            <div class="col " data-aos="fade-right" data-aos-duration="500" data-aos-delay="1000">
                <div class="form-group">
                    <label for="images">
                        <div class="card text-center " id='image' style="width: 31.5rem;">
                            <div class="card-body ">
                                <img src="https://kesagami.com/wp-content/plugins/complete-gallery-manager/images/gallery_icon@2x.png" width="200px" height="200px" class="" alt="add picture">
                                <input type="file" hidden id="images" accept="image/*" name='picture'>
                                <h4 class="white-fonts mt-3 mb-2" id="image-name">Pick An Image</h4>
                            </div>
                        </div>
                    </label>
                </div>
            </div>
            <div class="col " data-aos="fade-left" data-aos-duration="500" data-aos-delay="1000">
                <div class="form-group">
                    <label for="videos">
                        <div class="card " id="video" style="width: 31.5rem;">
                            <div class="card-body ">
                                <img src="https://www.freeiconspng.com/uploads/movie-icon-3.png" width="200px" height="200px" alt="add picture" class="">
                                <input type="file" hidden id="videos" accept="video/*" name="video">
                                <h4 class="white-fonts mt-3 mb-2" id="video-name">Pick An Video</h4>
                            </div>
                        </div>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center">
        <button type="submit" class="btn btn-primary mt-3">Submit</button>
    </div>
</form>



<script src="<?= base_url('/assets/js/logics/absensi.js'); ?>"></script>
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {

            var reader = new FileReader();

            reader.onload = function(e) {
                $('#image').css('background-image', 'url(' + e.target.result + ')');
                $('#image').css('background-size', 'contain');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#images").change(function() {
        readURL(this);
        const file = $(this).val();
        var filename = file.split(/[\\/]/g).pop().split('.')[0];
        $('#image-name').html(filename);
    });

    $('#videos').on('change', function() {
        const file = $(this).val();
        var filename = file.split(/[\\/]/g).pop().split('.')[0];
        $('#video-name').html(filename);
    });
</script>
<?= $this->endSection(); ?>