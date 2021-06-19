<?= $this->extend('dashboard/bootstraper'); ?>
<?= $this->section('content'); ?>

<?php
if (session()->getFlashData('success_delete')) {
    echo "<script>
        Swal.fire({
        icon: 'success',
        title: 'Success !',
        text: '" . session()->getFlashData('success_delete') . "', 
      })</script>";
}

?>

<table class="table table-bordered" data-aos="zoom-in" data-aos-duration="500" data-aos-delay="300">
    <thead>
        <tr>
            <th class="text-center">No</th>
            <th>ID</th>
            <th>Children Name</th>
            <th>Pembimbing</th>
            <th class="text-center">Cabang</th>
            <th class="text-center">Yang Menghapus</th>
            <th class="text-center">Tanggal Dihapus</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody id="body-table">
        <?php $no = 1 + (7 * ($current_page - 1)); ?>
        <?php if (count($datas) == 0) : ?>
            <tr>
                <td colspan="8" class="text-center">Data Not Found</td>
            </tr>
        <?php else : ?>
            <?php foreach ($datas as $data) : ?>

                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $data['id_absensi']; ?></td>
                    <td><?= $data['children_name']; ?></td>
                    <td><?= $data['name_pembimbing']; ?></td>
                    <td class="text-center"><?= $data['nama_cabang']; ?></td>
                    <td class="text-center"><?= $data['username'] . ' - ' . $data['email']; ?></td>
                    <?php if (isset($data['childrenDeleted'])) : ?>
                        <td class="text-center"><?= date('d M Y', strtotime($data['childrenDeleted'])); ?></td>
                    <?php else : ?>
                        <td class="text-center"><?= date('d M Y', strtotime($data['absensiDeleted'])); ?></td>
                    <?php endif ?>
                    <td>
                        <form action="<?= base_url('/pusat/tracking/') . '/' . $data['id_absensi']; ?>" method="POST" class="d-inline">
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


<div id="link">
    <?= $pager->links('tracking', 'custom'); ?>
</div>

<!-- pagination
<?= $this->endSection(); ?>