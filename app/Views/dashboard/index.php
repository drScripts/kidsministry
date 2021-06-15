<?= $this->include('template/header'); ?>
<div class="wrapper">
  <?= $this->include('template/sidebar'); ?>

  <div class="main-panel">
    <!-- Navbar -->
    <?= $this->include('template/navbar'); ?>
    <!-- End Navbar -->
    <!-- content -->
    <div class="content">
      <div class="row">
        <div class="col-12">
          <div class="card card-chart" data-aos="zoom-in" data-aos-duration="500" data-aos-delay="300">
            <div class="card-header">
              <div class="row">
                <div class="col-sm-6 text-left">
                  <h5 class="card-category" data-aos="fade-left" data-aos-duration="500" data-aos-delay="600">Total
                    Absensi </h5>
                  <h2 class="card-title" data-aos="fade-left" data-aos-duration="500" data-aos-delay="700">Absensi Tahun
                    <?= date("Y"); ?>
                  </h2>
                </div>
                <?php if (in_groups('pusat')) : ?>
                  <div class="col-sm-6" data-aos="fade-left" data-aos-duration="500" data-aos-delay="800">
                    <div class="btn-group btn-group-toggle float-right" data-toggle="buttons">
                      <label id="1" class="ml-2">
                        <select id="cabang" class="form-control card-select">
                          <option>See All Result</option>
                          <?php foreach ($cabangs as $cabang) : ?>
                            <option><?= $cabang; ?></option>
                          <?php endforeach; ?>
                        </select>
                      </label>
                    </div>
                  </div>
                <?php endif; ?>
              </div>
            </div>
            <div class="card-body" data-aos="zoom-in" data-aos-duration="500" data-aos-delay="900">
              <div class="chart-area" id="canvas1">
                <canvas id="chartBig1"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card card-chart" data-aos="zoom-in" data-aos-duration="500" data-aos-delay="300">
            <div class="card-header ">
              <div class="row">
                <div class="col-sm-6 text-left">
                  <h5 class="card-category" data-aos="fade-left" data-aos-duration="500" data-aos-delay="600">Total Absensi</h5>
                  <h2 class="card-title" data-aos="fade-left" data-aos-duration="500" data-aos-delay="700">Mingguan</h2>
                </div>
                <div class="col-sm-6" data-aos="fade-left" data-aos-duration="500" data-aos-delay="800">
                  <div class="btn-group btn-group-toggle float-right" data-toggle="buttons">
                    <?php if (in_groups('pusat')) : ?>
                      <label id="1" class="ml-2">
                        <select id="cabang1" class="form-control card-select">
                          <option>See All Result</option>
                          <?php foreach ($cabangs as $cabang) : ?>
                            <option><?= $cabang; ?></option>
                          <?php endforeach; ?>
                        </select>
                      </label>
                    <?php endif; ?>
                    <label id="0" class="ml-2">
                      <select id="month" class="form-control card-select">
                        <?php foreach ($month as $m) : ?>
                          <option><?= $m; ?></option>
                        <?php endforeach; ?>
                      </select>
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body" data-aos="zoom-in" data-aos-duration="500" data-aos-delay="900">
              <div class="chart-area" id="canvas2">
                <canvas id="chartBig2"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- content end -->
    </div>
    <?= $this->include('template/footer'); ?>
  </div>

  <?php if (!in_groups('pusat')) : ?>
    <script src="<?= base_url('assets/js/logics/index.js'); ?>"></script>
  <?php else : ?>
    <script src="<?= base_url('/assets/js/logics/pusat.js'); ?>"></script>
    <script>
      pusat.initAllCountly();
      $('#cabang').on('change', function() {
        $('#canvas1').html('');
        $('#canvas1').html(`
        <canvas id="chartBig1"></canvas>
        `);

        pusat.initAllCountly($(this).val());
      });


      let cabang = $('#cabang1').val();
      let month = $('#month').val();

      pusat.initChartMonthly(month, cabang);

      $('#cabang1').on('change', function() {
        $('#canvas2').html('');
        $('#canvas2').html(`
        <canvas id="chartBig2"></canvas>
        `);
        let cabang = $(this).val();

        pusat.updateMonthCabang($(this).val());


      });

      $('#month').on('change', function() {
        $('#canvas2').html('');
        $('#canvas2').html(`
        <canvas id="chartBig2"></canvas>
        `);

        let cabang = $('#cabang1').val();
        let month = $(this).val();

        pusat.initChartMonthly(month, cabang);
      });
    </script>
  <?php endif; ?>

  <?= $this->include('template/footers'); ?>