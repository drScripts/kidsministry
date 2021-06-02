<?= $this->extend('dashboard/bootstraper'); ?>
<?= $this->section('content'); ?>


<?php 
if(session()->getFlashData('success_add')){
   echo "
     <script>
         demo.successNotification('top', 'right', '<b>Success !</b><br> ". session()->getFlashData('success_add') ."');
     </script>
     ";
} elseif (session()->getFlashData('success_delete')) {
    echo "
     <script>
         demo.warningNotification('top', 'right', '<b>Warning !</b><br> ". session()->getFlashData('success_delete') ."');
     </script>
     ";
}elseif (session()->getFlashData('success_update')){
    echo "
     <script>
         demo.successNotification('top', 'right', '<b>Success !</b><br> ". session()->getFlashData('success_update') ."');
     </script>
     ";
}
?>

<div class="d-flex">
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
                    <a class="dropdown-item" href="<?= base_url('/pembimbing/export'); ?>"> <i class="fas fa-download"></i> Get Pembimbing Data</a>
                    <a class="dropdown-item" href="#"><i class="fas fa-upload"></i> Import Pembimbing Data</a>
                </div>
            </div>
        </div>
    </div>
    <!-- search button -->
    <div class="p-2 ml-auto bd-highlight" data-aos="fade-left" data-aos-duration="500" data-aos-delay="300"> 
            <div class="input-group mb-3">
                <input type="text" id="search-input" class="form-control" placeholder="Search Children">
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
            <th class="text-center">Id</th>
            <th>Name</th> 
            <th class="text-center">Actions</th> 
        </tr>
    </thead>
    <tbody id="body-table">
        <?php if(count($pembimbings) == 0): ?>
            <tr>
                <td colspan="3" class="text-center">Data Not Found</td>
            </tr>
        <?php else: ?>
            <?php foreach($pembimbings as $pembimbing): ?>
            <tr>
                <td class="text-center">
                    <?= $pembimbing['id_pembimbing']; ?>
                </td>
                <td>
                    <?= $pembimbing['name_pembimbing']; ?>
                </td>   
                <td class="td-actions text-center">
                    <a href="<?= base_url('pembimbing/edit') . '/' . $pembimbing['id_pembimbing']; ?>" rel="tooltip" class="mr-3 btn btn-success btn-sm btn-round btn-icon">
                        <i class="tim-icons icon-settings"></i>
                    </a>
                    <form action="<?= base_url("pembimbing").'/' . $pembimbing['id_pembimbing'] ; ?>" method="POST" class="d-inline">
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
<?= $pager->links('pembimbing','custom'); ?>
</div>
<!-- pagination -->
<script src="<?= base_url('assets/js/logics/pembimbing.js'); ?>"></script>
<?= $this->endSection(); ?>