<?= $this->extend('dashboard/bootstraper'); ?>
<?= $this->section('content'); ?>
<h1 data-aos="fade-right" data-aos-duration="500" data-aos-delay="500">All Settings</h1>

<h5 class="d-inline mr-5">Enable Quiz Absensi:</h5>
<label class="switch ml-5">
    <?php if ($quiz) : ?>
        <input type="checkbox" id="togBtn" checked>
    <?php else : ?>
        <input type="checkbox" id="togBtn">
    <?php endif; ?>
    <span class="slider round"></span>


</label>
<script>
    var switchStatus = false;
    $("#togBtn").on('change', function() {
        if ($(this).is(':checked')) {
            switchStatus = $(this).is(':checked');
            $.ajax({
                url: "/settings",
                type: "POST",
                data: {
                    'status': switchStatus,
                },
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                },
                dataType: "json",
                success: function(data) {
                    if (data.success) {
                        demo.successNotification('top', 'right', '<b>Success !</b><br> ' + data.success);
                    } else {
                        demo.dangerNotification('top', 'right', '<b>Success !</b><br> ' + data.failed);

                    }
                }
            });
        } else {
            switchStatus = $(this).is(':checked');
            $.ajax({
                url: "/settings",
                type: "POST",
                data: {
                    'status': switchStatus,
                },
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                },
                dataType: "json",
                success: function(data) {
                    if (data.success) {
                        demo.warningNotification('top', 'right', '<b>Success !</b><br> ' + data.success);
                    } else {
                        demo.dangerNotification('top', 'right', '<b>Success !</b><br> ' + data.failed);

                    }
                }
            });
        }
    });
</script>
<?= $this->endSection(); ?>