<?= $this->extend('dashboard/bootstraper'); ?>
<?= $this->section('content'); ?>

<h2>Detail's Record <?= $children_name; ?></h2>

<table class="table table-bordered" data-aos="zoom-in" data-aos-duration="500" data-aos-delay="900">
    <thead>
        <tr>
            <th class="text-center">#</th>
            <th>Children Name</th>
            <th>Name Pembimbing</th>
            <th class="text-center">Sunday Date</th>
        </tr>
    </thead>
    <tbody id="body-table">
        <?php
        $no = 1;
        foreach ($data as $d) : ?>
            <tr>
                <td class="text-center"><?= $no++; ?></td>
                <td><?= $d['children_name']; ?></td>
                <td><?= $d['name_pembimbing']; ?></td>
                <td class="text-center"><?= $d['sunday_date']; ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
<?= $this->endSection(); ?>