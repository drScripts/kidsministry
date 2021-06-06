<?= $this->extend('dashboard/bootstraper'); ?>
<?= $this->section('content'); ?> 
<h1 data-aos="zoom-in" data-aos-duration="500">Childen Detail's</h1>

  <div class="container mt-3 ml-3 mr-2 ml-2">
    <h4 class="white-fonts">Nama Anak : <?= $childs['children_name']; ?></h4>
    <h4 class="white-fonts">Kelas : <?= $childs['role']; ?></h4>
    <h4 class="white-fonts">Kode Anak : <?= $childs['code']; ?></h4>
    <h4 class="white-fonts">Pembimbing : <?= $childs['name_pembimbing']; ?></h4>
    <h4 class="white-fonts">Cabang : <?= $childs['nama_cabang']; ?></h4>
    <h4 class="white-fonts">Di Tambahkan Oleh : <?= $childs['username']; ?> - <?= $childs['email']; ?></h4>
    <?php if($childs['childrenUpdate'] != null): ?>
        <h4 class="white-fonts">Di Update Oleh : <?= $childs['username']; ?> - <?= $childs['email']; ?></h4>
    <?php  endif; ?>
    <h4 class="white-fonts">Di Tambahkan Pada : <?= date('d M Y',strtotime($childs['childrenCreated'])); ?></h4>
    <?php if($childs['childrenUpdated'] != $childs['childrenCreated']): ?> 
    <h4 class="white-fonts">Di Update Pada : <?= date('d M Y',strtotime($childs['childrenUpdated'])); ?></h4>
    <?php endif; ?>

  </div>


<?= $this->endSection(); ?>
