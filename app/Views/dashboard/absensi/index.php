<?= $this->extend('dashboard/bootstraper'); ?>
<?= $this->section('content'); ?>


<?php 

if(session()->getFlashData('success_add')){
   echo "
     <script>
         demo.successNotification('top', 'right', '<b>Success !</b><br> ". session()->getFlashData('success_add') ."');
     </script>
     ";
}
if (session()->getFlashData('success_deleted')) {
    echo "
     <script>
         demo.warningNotification('top', 'right', '<b>Warning !</b><br> ". session()->getFlashData('success_deleted') ."');
     </script>
     ";
}

if(session()->getFlashData('success_update')){
    echo "
     <script>
         demo.successNotification('top', 'right', '<b>Success !</b><br> ". session()->getFlashData('success_update') ."');
     </script>
     ";
}
?>

<div class="d-flex justify-content-between">
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
                    <button class="btn btn-sm white-fonts" type="button" id="button-addon2"><i
                            class="fas fa-search"></i></button>
                </div>
            </div> 
    </div>
    <!-- search button end -->
</div>

<table class="table table-bordered" data-aos="zoom-in" data-aos-duration="500" data-aos-delay="300">
    <thead>
        <tr>
            <th class="text-center">#</th>
            <th>Children Name</th> 
            <th>Pembimbing Name</th> 
            <th class="text-center">Video</th> 
            <th class="text-center">Image</th> 
            <th class="text-center">Quiz</th> 
            <th class="text-center">Sunday Date</th> 
            <th class="text-center">Actions</th> 
        </tr>
    </thead>
    <tbody id="body-table">
        <?php $no = 1 + (7 * ($current_page - 1)); ?>
    

        <?php if(count($absensis) == 0): ?>
            <tr>
                <td colspan="8" class="text-center">Data Not Found</td>
            </tr>
        <?php else: ?>
            <?php foreach($absensis as $absen): ?>
            <tr>
                <td class="text-center">
                    <?= $no++; ?>
                </td>

                <td>
                    <?= $absen['children_name']; ?>
                </td>  

                <td>
                    <?= $absen['name_pembimbing']; ?>
                </td> 

                <td class="text-center">
                    <?= $absen['video']; ?>
                </td>  

                <td class="text-center">
                    <?= $absen['image']; ?>
                </td>

                <td class="text-center">
                    <?= $absen['quiz']; ?>
                </td>

                <td class="text-center">
                    <?= $absen['sunday_date']; ?>
                </td>

                <td class="td-actions text-center">
                    <a href="<?= base_url('absensi/edit') . '/' . $absen['id_absensi']; ?>" rel="tooltip" class="mr-3 btn btn-success btn-sm btn-round btn-icon">
                        <i class="tim-icons icon-settings"></i>
                    </a>
                    <form action="<?= base_url("absensi").'/' . $absen['id_absensi'] ; ?>" method="POST" class="d-inline">
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
<?= $pager->links('absensi','custom'); ?>
</div>

<script src="<?= base_url('/assets/js/logics/absensi.js'); ?>"></script>

<!-- pagination --> 
<?= $this->endSection(); ?>