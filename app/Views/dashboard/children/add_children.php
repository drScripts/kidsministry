<?= $this->extend('dashboard/bootstraper'); ?>
<?= $this->section('content'); ?>
<h1 data-aos="zoom-in" data-aos-duration="500">Add Children</h1>
 

<?php 
if($validation->hasError('children_name') || $validation->hasError('code') || $validation->hasError('role') || $validation->hasError('pembimbing')){ 
    echo "
    <script>
        demo.dangerNotification('top', 'right', '<b>Failed Add Chldren</b><br>Check Your Input');
    </script>
    ";
};

?>
<form class="mt-5" action="<?= base_url('children/insert'); ?>" method="POST">
    <?= csrf_field(); ?>
    <div class="form-group" data-aos="fade-right" data-aos-duration="500" data-aos-delay="300">
        <label for="children-name" class="white-fonts">Children Name</label>
        <input type="text" name="children_name"
            class="<?= ($validation->hasError('children_name')) ? 'is-invalid' : ''; ?> form-control"
            placeholder="Input Children Name" id="children-name" value="<?= old('children_name'); ?>"/>
        <div class="invalid-feedback ">
            <?= $validation->getError('children_name'); ?>
        </div>
    </div>
    <div class="form-group" data-aos="fade-right" data-aos-duration="500" data-aos-delay="500">
        <label for="children-code" class="white-fonts">Children Code</label>
        <input type="text" class="form-control <?= ($validation->hasError('code')) ? 'is-invalid':''; ?>" placeholder="Input Children Code" name="code" id="children-code" value="<?= old('code'); ?>" />
        <div class="invalid-feedback ">
           <?= $validation->getError('code'); ?>
        </div>  
    </div>
    <div class="form-group form-check" data-aos="fade-right" data-aos-duration="500" data-aos-delay="700">
        <label for="role" class="white-fonts" class="white-fonts">Children Role</label>
        <select name="role" id="role" class="form-control grey-fonts <?= ($validation->hasError('role')) ? 'is-invalid':''; ?>">
            <option value="">Select Children Role</option>
            <option value="Batibali">Batita/Balita</option>
            <option value="Teens">Teens</option>
            <option value="Madya">Madya</option>
            <option value="Pratama">Pratama</option>
        </select>
        <div class="invalid-feedback ">
           <?= $validation->getError('role'); ?>
        </div>  
    </div>
    <div class="form-group form-check" data-aos="fade-right" data-aos-duration="500" data-aos-delay="900">
        <label for="pembimbing" class="white-fonts">Pembimbings</label>
        <select name="pembimbing" id="pembimbing" class="form-control grey-fonts <?= ($validation->hasError('pembimbing')) ? 'is-invalid':''; ?>">
            <option value="">Select Children Pembimbing</option>
            <?php foreach($pembimbings as $pembimbing): ?>
            <option value="<?= $pembimbing['id_pembimbing']; ?>">
                <?= $pembimbing['name_pembimbing']; ?>
            </option>
            <?php endforeach; ?>
        </select>
        <div class="invalid-feedback ">
            <?= $validation->getError('pembimbing'); ?>
        </div>  
    </div>
    <button type="submit" class="btn btn-primary mt-5" data-aos="fade-right" data-aos-duration="500" data-aos-delay="1100">Submit</button>
</form>

<?= $this->endSection(); ?>