<?= $this->extend('dashboard/bootstraper'); ?>
<?= $this->section('content'); ?>


<table class="table table-bordered" data-aos="zoom-in" data-aos-duration="500" data-aos-delay="300">
    <thead>
        <tr>
            <th class="text-center">No</th>
            <th>Children Name</th>
            <th>Pembimbing</th>
            <th  class="text-center">Cabang</th>
            <th class="text-center">Yang Menghapus</th>
            <th  class="text-center">Tanggal Dihapus</th>
        </tr>
    </thead>
    <tbody id="body-table">
        <?php $no = 1 + (7 * ($current_page - 1)); ?>
        <?php if (count($datas) == 0) : ?>
            <tr>
                <td colspan="6" class="text-center">Data Not Found</td>
            </tr>
        <?php else : ?>
            <?php foreach ($datas as $data) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $data['children_name']; ?></td>
                    <td><?= $data['name_pembimbing']; ?></td>
                    <td  class="text-center"><?= $data['nama_cabang']; ?></td>
                    <td  class="text-center"><?= $data['username'] . ' - ' . $data['email']; ?></td>
                    <td  class="text-center"><?= date('d M Y',strtotime($data['childrenDeleted'])); ?></td>
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