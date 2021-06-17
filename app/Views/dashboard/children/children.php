<?= $this->extend('dashboard/bootstraper'); ?>
<?= $this->section('content'); ?>

<?php
if (session()->getFlashData('success_add')) {
    echo "
        <script>
            demo.successNotification('top', 'right', '<b>Success !</b><br> " . session()->getFlashData('success_add') . "');
        </script>
        ";
} elseif (session()->getFlashData('success_deleted')) {
    echo "
        <script>
            demo.warningNotification('top', 'right', '<b>Success !</b><br> " . session()->getFlashData('success_deleted') . "');
        </script>
        ";
} elseif (session()->getFlashData('success_update')) {
    echo "
        <script>
            demo.successNotification('top', 'right', '<b>Success !</b><br> " . session()->getFlashData('success_update') . "');
        </script>
        ";
}

if (session()->getFlashData('failed_import')) {
    echo "
        <script>
            demo.dangerNotification('top', 'right', '<b>Failed !</b><br> " . session()->getFlashData('failed_import') . "');
        </script>
        ";
} elseif (session()->getFlashData('success_import')) {
    echo "
        <script>
            demo.successNotification('top', 'right', '<b>Success !</b><br> " . session()->getFlashData('success_import') . "');
        </script>
        ";
}
?>

<div class="d-flex">
    <?php if (!in_groups('pusat')) : ?>
        <div class="p-2 bd-highlight">
            <div class="row">
                <div class="col-md" data-aos="fade-right" data-aos-duration="500" data-aos-delay="900">
                    <a href="<?= base_url('children/add'); ?>" class="btn-sm btn">
                        <p><i class="fas fa-user-plus mr-2"></i> Add Children</p>
                    </a>
                </div>
            </div>
        </div>
        <div class="p-2 bd-highlight ml-2 mr-2">
            <div class="row">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle font-weight-lighter" type="button" id="dropdownMenuButton" data-toggle="dropdown">
                        Data Actions
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="<?= base_url('/children/export'); ?>"> <i class="fas fa-download"></i> Get Children Data</a>
                        <?php if (in_groups('superadmin')) : ?>
                            <a class="dropdown-item" href="<?= base_url('/children/import'); ?>"><i class="fas fa-upload"></i> Import Children Data</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    <?php endif; ?>
    <?php if (in_groups('superadmin')) : ?>
        <div class="p-2 bd-highlight">
            <div class="row">
                <div class="col-md" data-aos="fade-right" data-aos-duration="500" data-aos-delay="900">
                    <a href="<?= base_url('/children/addClass'); ?>" class="btn-sm btn">
                        <p><i class="fas fa-user-plus mr-2"></i> Add Data Kelas</p>
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- search button -->
    <?php if (!in_groups('pusat')) : ?>
        <div class="p-2 ml-auto bd-highlight">
            <div class="input-group mb-3" data-aos="fade-left" data-aos-duration="500" data-aos-delay="1000">
                <input type="text" id="search-input" class="form-control" placeholder="Search Children">
                <div class="input-group-append">
                    <button class="btn btn-sm white-fonts" type="button" id="button-addon2"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </div>
    <?php else : ?>
        <div class="p-2 bd-highlight">
            <div class="row">
                <div class="col-md" data-aos="fade-right" data-aos-duration="500" data-aos-delay="900">
                    <a href="<?= base_url('/pusat/tracking/children'); ?>" class="btn-sm btn">
                        <p><i class="fas fa-user-times"></i> Children Tracking</p>
                    </a>
                </div>
            </div>
        </div>
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
        <div class="p-2 bd-highlight">
            <div class="input-group mb-3" data-aos="fade-left" data-aos-duration="500" data-aos-delay="1000">
                <input type="text" id="search-input" class="form-control" placeholder="Search Children">
                <div class="input-group-append">
                    <button class="btn btn-sm white-fonts" type="button" id="button-addon2"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <!-- search button end -->
</div>

<table class="table table-bordered" data-aos="zoom-in" data-aos-duration="500" data-aos-delay="900">
    <thead>
        <tr>
            <th class="text-center">#</th>
            <th>Name</th>
            <th class="text-center">Code</th>
            <th>Pembimbing</th>
            <?php if (!in_groups('pusat')) : ?>
                <th class="text-center">Role</th>
            <?php else : ?>
                <th>Region</th>
            <?php endif; ?>
            <th class="text-center">Actions</th>
        </tr>
    </thead>
    <tbody id="body-table">
        <?php $no = 1 + (7 * ($current_page - 1)); ?>
        <?php if (count($childrens) == 0) : ?>
            <tr>
                <td colspan="6" class="text-center">Data Not Found</td>
            </tr>
        <?php else : ?>
            <?php foreach ($childrens as $child) : ?>
                <tr>
                    <td class="text-center">
                        <?= $no++; ?>
                    </td>
                    <td>
                        <?= $child['children_name']; ?>
                    </td>
                    <td class="text-center">
                        <?= $child['code']; ?>
                    </td>
                    <td>
                        <?= $child['name_pembimbing']; ?>
                    </td>


                    <?php if (!in_groups('pusat')) : ?>
                        <td class="text-center"><?= $child['nama_kelas']; ?></td>
                        <td class="td-actions text-center">
                            <a href="<?= base_url('children/edit') . '/' . $child['id_children']; ?>" rel="tooltip" class="mr-3 btn btn-success btn-sm btn-round btn-icon">
                                <i class="tim-icons icon-settings"></i>
                            </a>
                            <form action="<?= base_url('children') . '/' . $child['id_children'] ?>" method="POST" class="d-inline">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" rel="tooltip" onclick="return confirm('Are You Sure Want To Delete ?');" class="btn btn-danger btn-sm btn-round btn-icon">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    <?php else : ?>
                        <td class="text-center">
                            <?= $child['nama_cabang']; ?>
                        </td>
                        <td class="td-actions text-center">
                            <a href="<?= base_url('children/details') . '/' . $child['id_children']; ?>" rel="tooltip" class="btn btn-success btn-sm btn-round btn-icon">
                                <i class="fas fa-search"></i>
                            </a>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
<div id="link">
    <?= $pager->links('children', 'custom'); ?>
</div>
<!-- pagination -->

<?php if (!in_groups('pusat')) : ?>
    <script src="<?= base_url(); ?>/assets/js/logics/children.js"></script>
<?php else : ?>
    <script src="<?= base_url('/assets/js/logics/pusat.js'); ?>"></script>
    <script>
        pusat.pusatChildrenOptions();
    </script>
<?php endif; ?>

<?= $this->endSection(); ?>