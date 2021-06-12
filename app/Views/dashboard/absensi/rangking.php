<?= $this->extend('dashboard/bootstraper'); ?>
<?= $this->section('content'); ?>
<h1 data-aos="fade-right" data-aos-duration="500" data-aos-delay="500">Get Ranking</h1>


<?php if (in_groups('pusat')) : ?>
    <div class="form-group form-check" data-aos="fade-right" data-aos-duration="500" data-aos-delay="700">
        <label for="cabang" class="white-fonts">Select Cabang Name</label>
        <select class="form-control" id="cabang">
            <option>Select Cabang Name</option>
            <?php foreach ($cabang as $c) : ?>
                <option value="<?= $c['id_cabang']; ?>"><?= $c['nama_cabang']; ?></option>
            <?php endforeach ?>
        </select>
    </div>
    <div class="form-group form-check" data-aos="fade-right" data-aos-duration="500" data-aos-delay="700">
        <label for="year" class="white-fonts">Select Year</label>
        <select class="form-control" id="year">
            <option>Please Select Cabang Name First</option>
        </select>
    </div>
    <div class="form-group form-check" id="start-field" data-aos="fade-right" data-aos-duration="500" data-aos-delay="700">
        <label for="start" class="white-fonts">Select Start Date</label>
        <select class="form-control" id="start">
            <option>Please Select Year First</option>
        </select>
    </div>
    <div class="form-group form-check" id="end-field" data-aos="fade-right" data-aos-duration="500" data-aos-delay="700">
        <label for="end" class="white-fonts">Select End Date</label>
        <select class="form-control" id="end">
            <option>Please Select Year First</option>
        </select>
    </div>
<?php endif; ?>

<a id="button" class="btn btn-primary mt-5 white-fonts" data-aos="fade-right" data-aos-duration="500" data-aos-delay="900">Submit</a>

<script src="<?= base_url('assets/js/logics/ranking.js'); ?>"></script>
<script>
    rangking.pusat();
</script>

<?= $this->endSection(); ?>