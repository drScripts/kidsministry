<?= $this->extend('dashboard/bootstraper'); ?>
<?= $this->section('content'); ?>

 

<div class="d-flex justify-content-between">
    <div class="p-2 bd-highlight">
        <div class="row">
            <div class="col-md">
                 
            </div>
        </div>
    </div>
    <!-- search button -->
    <div class="p-2 bd-highlight"> 
            <div class="input-group mb-3">
                <select id="select-year" class="form-control grey-fonts">
                    <option value="all">Show All</option>
                    <?php foreach($years as $year): ?>
                        <option value="<?= $year; ?>"><?= $year; ?></option>
                    <?php endforeach; ?>
                </select>
            </div> 
    </div>
    <!-- search button end -->
</div>

<table class="table table-bordered">
    <thead>
        <tr>
            <th class="text-center">#</th>
            <th class="text-center">Month</th> 
            <th class="text-center">Year</th> 
            <th class="text-center">Link</th>
        </tr>
    </thead>
    <tbody id="body-table-history">
        <?php $no = 1; ?>
    

        <?php if(count($datas) == 0): ?>
            <tr>
                <td colspan="8" class="text-center">Data Not Found</td>
            </tr>
        <?php else: ?>
            <?php foreach($datas as $data): ?>
            <tr>
                <td class="text-center">
                    <?= $no++; ?>
                </td>

                <td class="text-center">
                    <?= $data['month']; ?>
                </td>  

                <td class="text-center">
                    <?= $data['year']; ?>
                </td> 

                 
                <td class="td-actions text-center">
                    <a href="<?= base_url("/export"); ?>/<?= $data['month']."/".$data['year'] ?> " rel="tooltip" class="mr-3 btn btn-success btn-sm btn-round btn-icon">
                        <i class="far fa-file-excel"></i>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    
    </tbody>

</table>
 
<div id="link-history"> 
</div>
 
<script src="<?= base_url('/assets/js/logics/absensi.js'); ?>"></script>
<!-- pagination --> 
<?= $this->endSection(); ?>