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
              </div>
            </div>
            <div class="card-body" data-aos="zoom-in" data-aos-duration="500" data-aos-delay="900">
              <div class="chart-area">
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
                    <label id="0">
                      <select id="month" class="form-control card-select">
                        <?php foreach ($month as $m) : ?>
                          <option><?= $m; ?></option>
                        <?php endforeach; ?>
                        <option>hai</option>
                      </select>
                    </label>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body" data-aos="zoom-in" data-aos-duration="500" data-aos-delay="900">
              <div class="chart-area">
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


  <script>
    gradientChartOptionsConfigurationWithTooltipPurple = {
      maintainAspectRatio: false,
      legend: {
        display: false,
      },

      tooltips: {
        backgroundColor: "#f5f5f5",
        titleFontColor: "#333",
        bodyFontColor: "#666",
        bodySpacing: 4,
        xPadding: 12,
        mode: "nearest",
        intersect: 0,
        position: "nearest",
      },
      responsive: true,
      scales: {
        yAxes: [{
          barPercentage: 1.6,
          gridLines: {
            drawBorder: false,
            color: "rgba(29,140,248,0.0)",
            zeroLineColor: "transparent",
          },
          ticks: {
            suggestedMin: 0,
            suggestedMax: 350,
            padding: 20,
            fontColor: "#9a9a9a",
          },
        }, ],

        xAxes: [{
          barPercentage: 1.6,
          gridLines: {
            drawBorder: false,
            color: "rgba(225,78,202,0.1)",
            zeroLineColor: "transparent",
          },
          ticks: {
            padding: 20,
            fontColor: "#9a9a9a",
          },
        }, ],
      },
    };

    var chart_labels = [];
    var chart_data = [];
    $.ajax({
      url: "/chart",
      headers: {
        "X-Requested-With": "XMLHttpRequest"
      },
      dataType: "json",
      success: function(data) {

        $.each(data, function(i, datas) {
          chart_labels.push(datas.bulan);
          chart_data.push(datas.jumlah);
        });


        var ctx = document.getElementById('chartBig1').getContext('2d');


        var ctx = document.getElementById("chartBig1").getContext("2d");

        var gradientStroke = ctx.createLinearGradient(0, 230, 0, 50);

        gradientStroke.addColorStop(1, "rgba(72,72,176,0.1)");
        gradientStroke.addColorStop(0.4, "rgba(72,72,176,0.0)");
        gradientStroke.addColorStop(0, "rgba(119,52,169,0)"); //purple colors
        var config = {
          type: "line",
          data: {
            labels: chart_labels,
            datasets: [{
              label: "Jumlah Absensi",
              fill: true,
              backgroundColor: gradientStroke,
              borderColor: "#d346b1",
              borderWidth: 2,
              borderDash: [],
              borderDashOffset: 0.0,
              pointBackgroundColor: "#d346b1",
              pointBorderColor: "rgba(255,255,255,0)",
              pointHoverBackgroundColor: "#d346b1",
              pointBorderWidth: 20,
              pointHoverRadius: 4,
              pointHoverBorderWidth: 15,
              pointRadius: 4,
              data: chart_data,
            }, ],
          },
          options: gradientChartOptionsConfigurationWithTooltipPurple,
        };
        var myChartData = new Chart(ctx, config);

      }
    });
  </script>

  <script>
    gradient2 = {
      maintainAspectRatio: false,
      legend: {
        display: false,
      },

      tooltips: {
        backgroundColor: "#f5f5f5",
        titleFontColor: "#333",
        bodyFontColor: "#666",
        bodySpacing: 4,
        xPadding: 12,
        mode: "nearest",
        intersect: 0,
        position: "nearest",
      },
      responsive: true,
      scales: {
        yAxes: [{
          barPercentage: 1.6,
          gridLines: {
            drawBorder: false,
            color: "rgba(29,140,248,0.0)",
            zeroLineColor: "transparent",
          },
          ticks: {
            suggestedMin: 0,
            suggestedMax: 200,
            padding: 20,
            fontColor: "#9a9a9a",
          },
        }, ],

        xAxes: [{
          barPercentage: 1.6,
          gridLines: {
            drawBorder: false,
            color: "rgba(225,78,202,0.1)",
            zeroLineColor: "transparent",
          },
          ticks: {
            padding: 20,
            fontColor: "#9a9a9a",
          },
        }, ],
      },
    };
    let month = $('#month').val();

    var chart_labels_month = [];
    var chart_data_month = [];
    $.ajax({
      url: "/chart/" + month,
      headers: {
        "X-Requested-With": "XMLHttpRequest"
      },
      dataType: "json",
      success: function(data) {

        $.each(data, function(i, datas) {
          chart_labels_month.push(datas.week);
          chart_data_month.push(datas.jumlah);
        });


        var ctxs = document.getElementById('chartBig2').getContext('2d');


        var ctxs = document.getElementById("chartBig2").getContext("2d");

        var gradientStrokes = ctxs.createLinearGradient(0, 230, 0, 50);

        gradientStrokes.addColorStop(1, "rgba(72,72,176,0.1)");
        gradientStrokes.addColorStop(0.4, "rgba(72,72,176,0.0)");
        gradientStrokes.addColorStop(0, "rgba(119,52,169,0)"); //purple colors
        var configs = {
          type: "line",
          data: {
            labels: chart_labels_month,
            datasets: [{
              label: "Jumlah Absensi Mingguan",
              fill: true,
              backgroundColor: gradientStrokes,
              borderColor: "#d346b1",
              borderWidth: 2,
              borderDash: [],
              borderDashOffset: 0.0,
              pointBackgroundColor: "#d346b1",
              pointBorderColor: "rgba(255,255,255,0)",
              pointHoverBackgroundColor: "#d346b1",
              pointBorderWidth: 20,
              pointHoverRadius: 4,
              pointHoverBorderWidth: 15,
              pointRadius: 4,
              data: chart_data_month,
            }, ],
          },
          options: gradient2,
        };
        var myChartData = new Chart(ctxs, configs);

      }
    });



    $('#month').on('change', function() {
      month = $(this).val();
      
      
      chart_labels_month = [];
      chart_data_month = [];

      $.ajax({
        url: "/chart/" + month,
        headers: {
          "X-Requested-With": "XMLHttpRequest"
        },
        dataType: "json",
        success: function(data) {

          $.each(data, function(i, datas) {
            chart_labels_month.push(datas.week);
            chart_data_month.push(datas.jumlah);
          });


          var ctxs = document.getElementById('chartBig2').getContext('2d');


          var ctxs = document.getElementById("chartBig2").getContext("2d");

          var gradientStrokes = ctxs.createLinearGradient(0, 230, 0, 50);

          gradientStrokes.addColorStop(1, "rgba(72,72,176,0.1)");
          gradientStrokes.addColorStop(0.4, "rgba(72,72,176,0.0)");
          gradientStrokes.addColorStop(0, "rgba(119,52,169,0)"); //purple colors
          var configs = {
            type: "line",
            data: {
              labels: chart_labels_month,
              datasets: [{
                label: "Jumlah Absensi Mingguan",
                fill: true,
                backgroundColor: gradientStrokes,
                borderColor: "#d346b1",
                borderWidth: 2,
                borderDash: [],
                borderDashOffset: 0.0,
                pointBackgroundColor: "#d346b1",
                pointBorderColor: "rgba(255,255,255,0)",
                pointHoverBackgroundColor: "#d346b1",
                pointBorderWidth: 20,
                pointHoverRadius: 4,
                pointHoverBorderWidth: 15,
                pointRadius: 4,
                data: chart_data_month,
              }, ],
            },
            options: gradient2,
          };
          var myChartData = new Chart(ctxs, configs);
        }
      });
    });
  </script>
  <?= $this->include('template/footers'); ?>