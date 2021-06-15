<?= $this->extend('dashboard/bootstraper'); ?>
<?= $this->section('content'); ?>


<?php

if (session()->getFlashData('success_add')) {
    echo "
     <script>
         demo.successNotification('top', 'right', '<b>Success !</b><br> " . session()->getFlashData('success_add') . "');
     </script>
     ";
}
if (session()->getFlashData('success_deleted')) {
    echo "
     <script>
         demo.warningNotification('top', 'right', '<b>Warning !</b><br> " . session()->getFlashData('success_deleted') . "');
     </script>
     ";
}

if (session()->getFlashData('success_update')) {
    echo "
     <script>
         demo.successNotification('top', 'right', '<b>Success !</b><br> " . session()->getFlashData('success_update') . "');
     </script>
     ";
}
?>

<div class="d-flex justify-content-between">
    <?php if (!in_groups('pusat')) : ?>
        <div class="p-2 bd-highlight">
            <div class="row">
                <div class="col-md" data-aos="fade-right" data-aos-duration="500" data-aos-delay="300">
                    <a href="<?= base_url('absensi/add'); ?>" class="btn-sm btn">
                        <p><i class="far fa-calendar-alt mr-2"></i> Add Absensi</p>
                    </a>
                </div>
            </div>
        </div>
        <!-- search button -->
        <div class="p-2 bd-highlight" data-aos="fade-left" data-aos-duration="500" data-aos-delay="300">
            <div class="input-group mb-3">
                <input type="text" id="search-input" class="form-control" placeholder="Search Absensi">
                <div class="input-group-append">
                    <button class="btn btn-sm white-fonts" type="button" id="button-addon2"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </div>
        <!-- search button end -->
    <?php else : ?>
        <div class="p-2 bd-highlight">
            <div class="row">
                <div class="col-md" data-aos="fade-right" data-aos-duration="500" data-aos-delay="300">
                    <a href="<?= base_url('/pusat/tracking'); ?>" class="btn-sm btn">
                        <p><i class="fas fa-calendar-times"></i> Tracking Absensi</p>
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
                <select id="sunday" class="form-control">
                    <option>Show All Date</option>
                    <?php foreach ($sunday_dates as $sunday_date) : ?>
                        <option><?= $sunday_date; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <!-- search button -->
        <div class="p-2 bd-highlight" data-aos="fade-left" data-aos-duration="500" data-aos-delay="300">
            <div class="input-group mb-3">
                <input type="text" id="search-input" class="form-control" placeholder="Search Absensi">
                <div class="input-group-append">
                    <button class="btn btn-sm white-fonts" type="button" id="button-addon2"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </div>
        <!-- search button end -->
    <?php endif ?>
</div>

<table class="table table-bordered" data-aos="zoom-in" data-aos-duration="500" data-aos-delay="300">
    <thead>
        <tr>
            <th class="text-center">#</th>
            <th>Children Name</th>
            <?php if (!in_groups('pusat')) : ?>
                <th>Pembimbing Name</th>
                <th class="text-center">Video</th>
                <th class="text-center">Image</th>
                <?php if ($quiz) : ?>
                    <th class="text-center">Quiz</th>
                <?php endif; ?>
                <?php if ($zoom) : ?>
                    <th class="text-center">Zoom</th>
                <?php endif; ?>
                <th class="text-center">Sunday Date</th>
            <?php else : ?>
                <th class="text-center">Cabang</th>
                <th class="text-center">Sunday Date</th>
            <?php endif; ?>
            <th class="text-center">Actions</th>
        </tr>
    </thead>
    <tbody id="body-table">
        <?php $no = 1 + (7 * ($current_page - 1)); ?>

        <?php if (count($absensis) == 0) : ?>
            <tr>
                <td colspan="8" class="text-center">Data Not Found</td>
            </tr>
        <?php else : ?>
            <?php foreach ($absensis as $absen) : ?>
                <tr>
                    <td class="text-center">
                        <?= $no++; ?>
                    </td>

                    <td>
                        <?= $absen['children_name']; ?>
                    </td>

                    <?php if (!in_groups('pusat')) : ?>
                        <td>
                            <?= $absen['name_pembimbing']; ?>
                        </td>

                        <td class="text-center">
                            <?= $absen['video']; ?>
                        </td>

                        <td class="text-center">
                            <?= $absen['image']; ?>
                        </td>

                        <?php if ($quiz) : ?>
                            <td class="text-center">
                                <?= $absen['quiz']; ?>
                            </td>
                        <?php endif; ?>
                        <?php if ($zoom) : ?>
                            <td class="text-center">
                                <?= $absen['zoom']; ?>
                            </td>
                        <?php endif; ?>
                        <td class="text-center">
                            <?= $absen['sunday_date']; ?>
                        </td>

                        <td class="td-actions text-center">
                            <a href="<?= base_url('absensi/edit') . '/' . $absen['id_absensi']; ?>" rel="tooltip" class="mr-3 btn btn-success btn-sm btn-round btn-icon">
                                <i class="tim-icons icon-settings"></i>
                            </a>
                            <form action="<?= base_url("absensi") . '/' . $absen['id_absensi']; ?>" method="POST" class="d-inline">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" rel="tooltip" onclick="return confirm('Are You Sure Want To Delete ?');" class="btn btn-danger btn-sm btn-round btn-icon">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    <?php else : ?>
                        <td class="text-center">
                            <?= $absen['nama_cabang']; ?>
                        </td>
                        <td class='text-center'>
                            <?= $absen['sunday_date']; ?>
                        </td>
                        <td class="td-actions text-center">
                            <a href="<?= base_url('absensi/details') . '/' . $absen['id_absensi']; ?>" rel="tooltip" class="btn btn-success btn-sm btn-round btn-icon">
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
    <?= $pager->links('absensi', 'custom'); ?>
</div>

<?php if (!in_groups('pusat')) : ?>
    <script src="<?= base_url('/assets/js/logics/absensi.js'); ?>"></script>
<?php else : ?>
    <script src="<?= base_url('/assets/js/logics/pusat.js'); ?>"></script>
    <script>
        pusat.pusatAbsensiOptions();
    </script>
<?php endif; ?>
<!-- pagination -->
<?= $this->endSection(); ?>