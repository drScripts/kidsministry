<?= $this->extend('dashboard/bootstraper'); ?>
<?= $this->section('content'); ?>
<h1 data-aos="fade-right" data-aos-duration="500" data-aos-delay="500">Get Ranking</h1>


<form action="<?= base_url('rank') ?>" method="POST">
    <?= csrf_field() ?>

    <?php if (in_groups('pusat')) : ?>
        <div class="form-group form-check" data-aos="fade-right" data-aos-duration="500" data-aos-delay="700">
            <label for="cabang" class="white-fonts">Select Cabang Name</label>
            <select name='cabang' class="form-control" id="cabang">
                <option>Select Cabang Name</option>
                <?php foreach ($cabang as $c) : ?>
                    <option value="<?= $c['id_cabang']; ?>"><?= $c['nama_cabang']; ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="form-group form-check" data-aos="fade-right" data-aos-duration="500" data-aos-delay="700">
            <label for="year" class="white-fonts">Select Year</label>
            <select name='year' class="form-control" id="year">
                <option>Please Select Cabang Name First</option>
            </select>
        </div>
        <div class="form-group form-check" id="start-field" data-aos="fade-right" data-aos-duration="500" data-aos-delay="700">
            <label for="start" class="white-fonts">Select Start Date</label>
            <select name='start' class="form-control" id="start">
                <option>Please Select Year First</option>
            </select>
        </div>
        <div class="form-group form-check" id="end-field" data-aos="fade-right" data-aos-duration="500" data-aos-delay="700">
            <label for="end" class="white-fonts">Select End Date</label>
            <select name='end' class="form-control" id="end">
                <option>Please Select Year First</option>
            </select>
        </div>
        <div id="ranking-field">
            <label class="white-fonts" data-aos="fade-right" data-aos-duration="500" data-aos-delay="700">Pemilihan Type Ranking Report</label>
            <div class="container">
                <div class="form-group form-check" id="end-field" data-aos="fade-right" data-aos-duration="500" data-aos-delay="700">
                    <input class="form-check-input" type="radio" name="kelasRadio" id="class1" value="semuaKelas" checked>
                    <label class="form-check-label white-fonts" for="class1">
                        Ranking Keseluruhan Kelas
                    </label>
                </div>
                <div class="form-group form-check" id="end-field" data-aos="fade-right" data-aos-duration="500" data-aos-delay="700">
                    <input class="form-check-input" type="radio" name="kelasRadio" id="class2" value="pembagian">
                    <label class="form-check-label white-fonts" for="class2">
                        Dibagi Per Kelas
                    </label>
                </div>
                <div class="form-group form-check" id="end-field" data-aos="fade-right" data-aos-duration="500" data-aos-delay="700">
                    <input class="form-check-input" type="radio" name="kelasRadio" id="class3" value="costum">
                    <div id="btn">
                        <label class="form-check-label white-fonts d-inline" for="class3">
                            Costum Penggabungan Kelas
                        </label>
                        <a href="javascript:void(0)" class="btn btn-primary btn-sm" id="addClass">+</a>
                        <a href="javascript:void(0)" class="btn btn-primary btn-sm" id="removeClass">-</a>
                    </div>
                    <div class="mt-3" id="pemilihan-kelas">
                        <div class="row" id="row-kelas">
                            <div class="col-3" id="col">
                                <select id='first' class="form-control" name="kelas[]" disabled>
                                    <option>Select Class Name</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <button type="submit" id="button" class="btn btn-primary mt-5 white-fonts" data-aos="fade-right" data-aos-duration="500" data-aos-delay="900">Submit</button>

</form>


<script src="<?= base_url('assets/js/logics/ranking.js'); ?>"></script>
<script>
    rangking.pusat();
</script>

<?= $this->endSection(); ?>