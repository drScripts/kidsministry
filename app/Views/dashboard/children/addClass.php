<?= $this->extend('dashboard/bootstraper'); ?>
<?= $this->section('content'); ?>
<h1 data-aos="fade-right" data-aos-duration="500" data-aos-delay="500">Add Class</h1>


<?php 

if (session()->getFlashData('success_add')) {
    echo "
        <script>
            demo.successNotification('top', 'right', '<b>Success !</b><br> " . session()->getFlashData('success_add') . "');
        </script>
        ";
}

if($validation->hasError('class_name')){ 
    echo "
    <script>
        demo.dangerNotification('top', 'right', '<b>Failed Add Class</b><br>Check Your Input');
    </script>
    ";
};

?>

<form action="<?= base_url('/children/class'); ?>" method="POST">
    <?= csrf_field(); ?>
    <div class="form-group form-check" data-aos="fade-right" data-aos-duration="500" data-aos-delay="700">
        <label for="class" class="white-fonts">Class Name</label>
        <input type="text" name="class_name"
            class="<?= ($validation->hasError('class_name')) ? 'is-invalid' : ''; ?> form-control"
            placeholder="Input Class Name" id="class" value="<?= old('class_name'); ?>" />
        <div class="invalid-feedback ">
            <?= $validation->getError('class_name'); ?>
        </div>
    </div>
    <button type="submit" class="btn btn-primary mt-5" data-aos="fade-right" data-aos-duration="500" data-aos-delay="900">Submit</button>
</form>


<?= $this->endSection(); ?>