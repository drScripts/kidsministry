<?= $this->extend('dashboard/bootstraper'); ?>
<?= $this->section('content'); ?>


<?php

if (session()->getFlashData('success_update')) {
    echo "
     <script>
         demo.successNotification('top', 'right', '<b>Success !</b><br> " . session()->getFlashData('success_update') . "');
     </script>
     ";
}

if (session()->getFlashData('success_deleted')) {
    echo "
     <script>
         demo.successNotification('top', 'right', '<b>Success !</b><br> " . session()->getFlashData('success_deleted') . "');
     </script>
     ";
}
?>

<div class="d-flex">
    <div class="p-2 bd-highlight" data-aos="fade-left" data-aos-duration="500" data-aos-delay="300">
        <div class="input-group mb-3">
            <form action="<?= base_url("team/refresh"); ?>" method="POST" class="d-inline">
                <?= csrf_field(); ?>
                <input type="hidden" name="_method" value="PUT">
                <button type="submit" rel="tooltip" onclick="return confirm('Are You Sure Want To Refresh ?');" class="btn btn-info btn-sm btn-round btn-icon">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </form>
        </div>
    </div>
    <!-- search button -->
    <div class="p-2 ml-auto bd-highlight" data-aos="fade-left" data-aos-duration="500" data-aos-delay="300">
        <div class="input-group mb-3">
            <input type="text" id="search-input" class="form-control" placeholder="Search User's">
            <div class="input-group-append">
                <button class="btn btn-sm white-fonts" type="button" id="button-addon2"><i class="fas fa-search"></i></button>
            </div>
        </div>
    </div>
    <!-- search button end -->
</div>

<table class="table table-bordered" id="dtBasicExample" data-aos="zoom-in" data-aos-duration="500" data-aos-delay="300">
    <thead>
        <tr>
            <th class="text-center">No</th>
            <th>Username</th>
            <th>Email</th>
            <th class="text-center">Cabang</th>
            <th class="text-center">Roles</th>
            <th class="text-center"> Actions</th>
        </tr>
    </thead>
    <tbody id="body-table">
        <?php $no = 1; ?>
        <?php if (count($team) == 0) : ?>
            <tr>
                <td colspan="6" class="text-center">Data Not Found</td>
            </tr>
        <?php else : ?>
            <?php foreach ($team as $t) : ?>
                <tr>
                    <td class="text-center"><?= $no++; ?></td>
                    <td><?= $t->toArray()['username'] ?></td>
                    <td><?= $t->toArray()['email'] ?></td>
                    <td class="text-center"><?= $t->toArray()['nama_cabang'] ?></td>
                    <td class="text-center"><?= $t->toArray()['name'] ?></td>
                    <td class="td-actions text-center">
                        <a href="<?= base_url('team/edit') . '/' . $t->toArray()['userid']; ?>" rel="tooltip" class="mr-3 btn btn-success btn-sm btn-round btn-icon">
                            <i class="tim-icons icon-settings"></i>
                        </a>
                        <form action="<?= base_url("team") . '/' . $t->toArray()['userid']; ?>" method="POST" class="d-inline">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" rel="tooltip" onclick="return confirm('Are You Sure Want To Delete ?');" class="btn btn-danger btn-sm btn-round btn-icon">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<script src="<?= base_url('assets/js/core/jquery.dataTables.min.js'); ?>"></script>
<script>
    $('#dtBasicExample').DataTable();
    $('#dtBasicExample_length').addClass('white-fonts');
    $('#dtBasicExample_filter label input').addClass('white-fonts');
    $('#dtBasicExample_filter').addClass('white-fonts');
    $('#dtBasicExample_info').addClass('white-fonts');
    $("#dtBasicExample_paginate").addClass('white-fonts');
</script>
<?= $this->endSection(); ?>