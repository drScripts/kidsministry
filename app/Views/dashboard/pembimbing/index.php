<?= $this->extend('dashboard/bootstraper'); ?>
<?= $this->section('content'); ?>


<?php
if (session()->getFlashData('success_add')) {
    echo "
     <script>
         demo.successNotification('top', 'right', '<b>Success !</b><br> " . session()->getFlashData('success_add') . "');
     </script>
     ";
} elseif (session()->getFlashData('success_delete')) {
    echo "
     <script>
         demo.warningNotification('top', 'right', '<b>Warning !</b><br> " . session()->getFlashData('success_delete') . "');
     </script>
     ";
} elseif (session()->getFlashData('success_update')) {
    echo "
     <script>
         demo.successNotification('top', 'right', '<b>Success !</b><br> " . session()->getFlashData('success_update') . "');
     </script>
     ";
}
?>

<div class="d-flex">
    <?php if (!in_groups('pusat')) : ?>
        <div class="p-2 bd-highlight">
            <div class="row">
                <div class="col-md" data-aos="fade-right" data-aos-duration="500" data-aos-delay="300">
                    <a href="<?= base_url('pembimbing/add'); ?>" class="btn-sm btn">
                        <p><i class="fas fa-user-plus mr-2"></i> Add Pembimbing</p>
                    </a>
                </div>
            </div>
        </div>
        <div class="p-2 bd-highlight ml-3">
            <div class="row">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle font-weight-lighter" type="button" id="dropdownMenuButton" data-toggle="dropdown">
                        Data Actions
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="<?= base_url('/pembimbing/export'); ?>"> <i class="fas fa-file-download"></i> Get Pembimbing Data</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- search button -->
        <div class="p-2 ml-auto bd-highlight" data-aos="fade-left" data-aos-duration="500" data-aos-delay="300">
            <div class="input-group mb-3">
                <input type="text" id="search-input" class="form-control" placeholder="Search Pembimbing">
                <div class="input-group-append">
                    <button class="btn btn-sm white-fonts" type="button" id="button-addon2"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </div>
        <!-- search button end -->
    <?php else : ?>
        <div class="p-2 ml-auto bd-highlight">
            <div class="input-group mb-3" data-aos="fade-left" data-aos-duration="500" data-aos-delay="1000">
                <select id="cabang" class="form-control">
                    <option>Show All Region</option>
                    <?php foreach ($cabangs as $cabang) : ?>
                        <option><?= $cabang; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <!-- search button -->
        <div class="p-2 bd-highlight" data-aos="fade-left" data-aos-duration="500" data-aos-delay="300">
            <div class="input-group mb-3">
                <input type="text" id="search-input" class="form-control" placeholder="Search Pembimbing">
                <div class="input-group-append">
                    <button class="btn btn-sm white-fonts" type="button" id="button-addon2"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </div>
        <!-- search button end -->
    <?php endif; ?>

</div>

<table class="table table-bordered" data-aos="zoom-in" data-aos-duration="500" data-aos-delay="300">
    <thead>
        <tr>
            <th class="text-center">Id</th>
            <th>Name</th>
            <?php if (in_groups('pusat')) : ?>
                <th class="text-center">Cabang</th>
            <?php else : ?>
                <th class="text-center">Actions</th>
            <?php endif; ?>

        </tr>
    </thead>
    <tbody id="body-table">
        <?php if (count($pembimbings) == 0) : ?>
            <tr>
                <td colspan="3" class="text-center">Data Not Found</td>
            </tr>
        <?php else : ?>
            <?php
            $no = 1 + (7 * ($current_page - 1));
            foreach ($pembimbings as $pembimbing) : ?>
                <tr>
                    <td class="text-center">
                        <?= $no++; ?>
                    </td>
                    <td>
                        <?= $pembimbing['name_pembimbing']; ?>
                    </td>
                    <?php if (!in_groups('pusat')) : ?>
                        <td class="td-actions text-center">
                            <a href="<?= base_url('pembimbing/edit') . '/' . $pembimbing['id_pembimbing']; ?>" rel="tooltip" class="mr-3 btn btn-success btn-sm btn-round btn-icon">
                                <i class="tim-icons icon-settings"></i>
                            </a>
                            <form action="<?= base_url("pembimbing") . '/' . $pembimbing['id_pembimbing']; ?>" method="POST" class="d-inline">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" rel="tooltip" onclick="return confirm('Are You Sure Want To Delete ?');" class="btn btn-danger btn-sm btn-round btn-icon">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    <?php else : ?>
                        <td class="text-center">
                            <?= $pembimbing['nama_cabang']; ?>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
<div id="link">
    <?= $pager->links('pembimbing', 'custom'); ?>
</div>


<?php if (!in_groups('pusat')) : ?>
    <!-- pagination -->
    <script src="<?= base_url('assets/js/logics/pembimbing.js'); ?>"></script>
<?php else : ?>
    <script src="<?= base_url('assets/js/logics/pusat.js'); ?>"></script>
    <script>
        pusat.pusatPembimbingOptions();
    </script>
<?php endif; ?>
<?= $this->endSection(); ?>