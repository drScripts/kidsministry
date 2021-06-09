 <?= $this->extend('dashboard/bootstraper'); ?>
 <?= $this->section('content'); ?>
 <h1 data-aos="zoom-in" data-aos-duration="500">Childen Import Data</h1>

     <form class="text-center" action="<?= base_url('/children/import'); ?>" method="POST" enctype="multipart/form-data">
         <div class="form-group mt-5">
             <label for="excel">
                 <div class="card text-center " style="width: 35.5rem;height:15.5rem">
                     <div class="card-body">
                         <i class="fas fa-file-excel fa-10x mt-3" style="color: #1D6F42;"></i>
                         <input type="file" hidden id="excel" accept="application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" name='excel' required>
                         <h1 class="white-fonts mt-3 mb-3" id="name">Pick An Excel File</h1>
                     </div>
                 </div>
             </label>
         </div>
         <button type="submit" class="btn btn-success">Submit</button>
     </form>


<script>

$('#excel').on('change',function(){
    if($(this).val().split(/(\\|\/)/g).pop()){

        $('#name').html('').append($(this).val().split(/(\\|\/)/g).pop());
    }else{
        $('#name').html('').append('Pick An Excel File');

    }
})

</script>
 <?= $this->endSection(); ?>