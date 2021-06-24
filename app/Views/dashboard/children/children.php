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
    <div class="p-2 bd-highlight ml-3">
        <div class="row">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle font-weight-lighter" type="button" id="dropdownMenuButton" data-toggle="dropdown">
                    Class Actions
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <?php if (in_groups('superadmin')) : ?>
                        <a class="dropdown-item" href="<?= base_url('/children/addClass'); ?>"> <i class="fas fa-plus-circle"></i> Add Data Kelas</a>
                    <?php endif; ?>
                    <button type="button" data-toggle="modal" data-target="#dataKelas" class="dropdown-item"> <i class="fas fa-eye"></i> View Data Kelas</button>
                </div>
            </div>
        </div>
    </div>
    <div class="p-2 bd-highlight">
        <div class="row">
            <div class="col-md" data-aos="fade-right" data-aos-duration="500" data-aos-delay="900">
                <a href="<?= base_url('/children/trace'); ?>" class="btn-sm btn">
                    <p><i class="fab fa-searchengin"></i> Trace</p>
                </a>
            </div>
        </div>
    </div>
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
        <div class="ml-3 p-2 bd-highlight">
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
            <th class="text-center">Tanggal Lahir</th>
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
                    <td class="text-center">
                        <?= ($child['tanggal_lahir'] == null) ? 'Belum Di Atur' : $child['tanggal_lahir']; ?>
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
<!-- Modal -->
<div class="modal fade" id="dataKelas" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">List Class</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ol>
                    <?php foreach ($class as $c) : ?>
                        <li class="black-fonts"><?= $c['nama_kelas']; ?></li>
                    <?php endforeach; ?>
                </ol>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php if (!in_groups('pusat')) : ?>
    <script src="<?= base_url(); ?>/assets/js/logics/children.js"></script>
<?php else : ?>
    <script src="<?= base_url('/assets/js/logics/pusat.js'); ?>"></script>
    <script>
        pusat.pusatChildrenOptions();
    </script>
<?php endif; ?>

<?= $this->endSection(); ?>