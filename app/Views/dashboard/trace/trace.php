<?= $this->extend('dashboard/bootstraper'); ?>
<?= $this->section('content'); ?>


<table id="dtBasicExample" class="cell-border compact stripe" data-aos="zoom-in" data-aos-duration="500" data-aos-delay="900">
    <thead>
        <tr class="white-fonts">
            <th class="text-center">#</th>
            <th>Children Name</th>
            <th>Name Pembimbing</th>
            <th class="text-center">Jumlah</th>
            <th class="text-center">Status</th>
            <th class="text-center">Actions</th>
        </tr>
    </thead>
    <tbody id="body-table">
        <?php
        $no = 1;
        foreach ($data as $d) : ?>
            <tr>
                <td class="text-center"><?= $no++; ?></td>
                <td><?= $d['children']['children_name']; ?></td>
                <td><?= $d['children']['name_pembimbing']; ?></td>
                <td class="text-center"><?= $d['jumlah']; ?></td>
                <td class="text-center"><?= ($d['jumlah'] <= 2) ? '<span class="badge badge-pill badge-danger">Malas</span>' : '<span class="badge badge-pill badge-success">Rajin</span>'; ?></td>
                <td class="td-actions text-center">
                    <?php if ($d['jumlah'] == 0) : ?>
                        <button type="button" class="btn btn-danger btn-sm btn-round btn-icon"> <i class="fas fa-times"></i></button>
                    <?php else : ?>
                        <a href="<?= base_url('children/trace/details') . '/' . $d['children']['id_children'] . '/' . $month . '/' . $year; ?>" rel="tooltip" class="btn btn-success btn-sm btn-round btn-icon">
                            <i class="fas fa-search"></i>
                        </a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach ?>
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