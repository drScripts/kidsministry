<?= $this->extend('dashboard/bootstraper'); ?>
<?= $this->section('content'); ?>

<?php if (!in_groups('pusat')) : ?>
    <div class="form-group form-check" data-aos="fade-right" data-aos-duration="500" data-aos-delay="500">
        <label for="year-select" class="white-fonts">Select Year</label>
        <select id="year-select" class="form-control grey-fonts">
            <option>Select Year</option>
            <?php foreach ($data as $d) : ?>
                <option><?= $d; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div id='month' class="form-group form-check" data-aos="fade-right" data-aos-duration="500" data-aos-delay="500">
        <label for="month-select" class="white-fonts">Select month</label>
        <select id="month-select" class="form-control grey-fonts">

        </select>
    </div>
    <a href="" class="btn btn-primary" id='btn'>Calculate</a>
<?php else : ?>
    <div class="form-group form-check" data-aos="fade-right" data-aos-duration="500" data-aos-delay="500">
        <label for="cabang-select" class="white-fonts">Select Cabang</label>
        <select id="cabang-select" class="form-control grey-fonts">
            <option>Select Cabang</option>
            <?php foreach ($data as $d) : ?>
                <option value="<?= $d['id_cabang']; ?>"><?= $d['nama_cabang']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div id='year' class="form-group form-check" data-aos="fade-right" data-aos-duration="500" data-aos-delay="500">
        <label for="year-select" class="white-fonts">Select year</label>
        <select id="year-select" class="form-control grey-fonts">

        </select>
    </div>
    <div id='month' class="form-group form-check" data-aos="fade-right" data-aos-duration="500" data-aos-delay="500">
        <label for="month-select" class="white-fonts">Select month</label>
        <select id="month-select" class="form-control grey-fonts">

        </select>
    </div>

    <a href="" class="btn btn-primary" id='btn'>Calculate</a>
<?php endif; ?>

<?php if (in_groups('pusat')) : ?>
    <script src="<?= base_url('assets/js/logics/trace.js'); ?>"></script>
<?php else : ?>
    <script src="<?= base_url('assets/js/logics/admin_trace.js'); ?>"></script>
<?php endif; ?>
<?= $this->endSection(); ?>