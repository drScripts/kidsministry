<?= $this->extend('dashboard/bootstraper'); ?>
<?= $this->section('content'); ?>
<h1 data-aos="fade-right" data-aos-duration="500" data-aos-delay="500">All Settings</h1>

<div class="row">
    <div class="col-12">
        <table>
            <thead>
                <tr>
                    <th class=" mr-5 white-fonts">Enable Quiz Absensi:</th>
                    <th>
                        <label class="switch ml-5">
                            <?php if ($quiz) : ?>
                                <input type="checkbox" id="togBtn" checked>
                            <?php else : ?>
                                <input type="checkbox" id="togBtn">
                            <?php endif; ?>
                            <span class="slider round"></span>
                        </label>
                    </th>
                </tr>
                <tr>
                    <th class=" mr-5 white-fonts">Enable Zoom Absensi:</th>
                    <th>
                        <label class="switch ml-5">
                            <?php if ($zoom) : ?>
                                <input type="checkbox" id="zoomBtn" checked>
                            <?php else : ?>
                                <input type="checkbox" id="zoomBtn">
                            <?php endif; ?>
                            <span class="slider round"></span>
                        </label>
                    </th>
                </tr>
                <tr>
                    <th class=" mr-5 white-fonts">Enable ABA Absensi:</th>
                    <th>
                        <label class="switch ml-5">
                            <?php if ($aba) : ?>
                                <input type="checkbox" id="abaBtn" checked>
                            <?php else : ?>
                                <input type="checkbox" id="abaBtn">
                            <?php endif; ?>
                            <span class="slider round"></span>
                        </label>
                    </th>
                </tr>
                <tr>
                    <th class=" mr-5 white-fonts">Enable Komsel Absensi:</th>
                    <th>
                        <label class="switch ml-5">
                            <?php if ($komsel) : ?>
                                <input type="checkbox" id="komselBtn" checked>
                            <?php else : ?>
                                <input type="checkbox" id="komselBtn">
                            <?php endif; ?>
                            <span class="slider round"></span>
                        </label>
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<script>
    var switchStatus = false;
    $("#togBtn").on('change', function() {
        if ($(this).is(':checked')) {
            switchStatus = $(this).is(':checked');
            $.ajax({
                url: "/settings/quiz",
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
                url: "/settings/quiz",
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

    var switchStatusZoom = false;
    $("#zoomBtn").on('change', function() {
        if ($(this).is(':checked')) {
            switchStatusZoom = $(this).is(':checked');
            $.ajax({
                url: "/settings/zoom",
                type: "POST",
                data: {
                    'status': switchStatusZoom,
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
            switchStatusZoom = $(this).is(':checked');
            $.ajax({
                url: "/settings/zoom",
                type: "POST",
                data: {
                    'status': switchStatusZoom,
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

    let switchStatusAba = false;
    $("#abaBtn").on('change', function() {
        if ($(this).is(':checked')) {
            switchStatusAba = $(this).is(':checked');
            $.ajax({
                url: "/settings/aba",
                type: "POST",
                data: {
                    'status': switchStatusAba,
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
            switchStatusAba = $(this).is(':checked');
            $.ajax({
                url: "/settings/aba",
                type: "POST",
                data: {
                    'status': switchStatusAba,
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

    let switchStatusKomsel = false;
    $("#komselBtn").on('change', function() {
        if ($(this).is(':checked')) {
            switchStatusKomsel = $(this).is(':checked');
            $.ajax({
                url: "/settings/komsel",
                type: "POST",
                data: {
                    'status': switchStatusKomsel,
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
            switchStatusKomsel = $(this).is(':checked');
            $.ajax({
                url: "/settings/komsel",
                type: "POST",
                data: {
                    'status': switchStatusKomsel,
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