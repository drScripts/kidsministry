<?= $this->include('template/header'); ?>
<div class="wrapper">
  <?= $this->include('template/sidebar'); ?>
  <div class="main-panel">
    <!-- Navbar -->
    <?= $this->include('template/navbar'); ?>
    <!-- End Navbar -->
    <!-- content -->
    <div class="content">
      <?= $this->renderSection('content'); ?>
     
    </div>
    <!-- content end -->
  </div>
  <?= $this->include('template/footer'); ?>
</div> 
<?= $this->include('template/footers'); ?>