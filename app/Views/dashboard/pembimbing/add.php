<?= $this->extend('dashboard/bootstraper'); ?>
<?= $this->section('content'); ?>
<h1 data-aos="fade-right" data-aos-duration="500" data-aos-delay="500">Add Pembimbing</h1>


<?php 
if($validation->hasError('pembimbing_name')){ 
    echo "
    <script>
        demo.dangerNotification('top', 'right', '<b>Failed Add Pembimbing</b><br>Check Your Input');
    </script>
    ";
};

?>

<form action="<?= base_url('/pembimbing/insert'); ?>" method="POST">
    <?= csrf_field(); ?>
    <div class="form-group form-check" data-aos="fade-right" data-aos-duration="500" data-aos-delay="700">
        <label for="pembimbing" class="white-fonts">Pembimbing Name</label>
        <input type="text" name="pembimbing_name"
            class="<?= ($validation->hasError('pembimbing_name')) ? 'is-invalid' : ''; ?> form-control"
            placeholder="Input Children Name" id="pembimbing" value="<?= old('pembimbing_name'); ?>" />
        <div class="invalid-feedback ">
            <?= $validation->getError('pembimbing_name'); ?>
        </div>
    </div>
    <button type="submit" class="btn btn-primary mt-5" data-aos="fade-right" data-aos-duration="500" data-aos-delay="900">Submit</button>
</form>


<?= $this->endSection(); ?>