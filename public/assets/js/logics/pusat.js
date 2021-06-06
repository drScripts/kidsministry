function optionPusatYear(max) {
  return {
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
      yAxes: [
        {
          barPercentage: 1.6,
          gridLines: {
            drawBorder: false,
            color: "rgba(29,140,248,0.0)",
            zeroLineColor: "transparent",
          },
          ticks: {
            suggestedMin: 0,
            suggestedMax: max,
            padding: 20,
            fontColor: "#9a9a9a",
          },
        },
      ],

      xAxes: [
        {
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
        },
      ],
    },
  };
}

const pusat = {
  initAllCountly: (cabang = null) => {
    var chart_labels = [];
    var chart_data = [];
    var uri =
      cabang == null || cabang == "See All Result"
        ? "/pusat/getChartYear"
        : "/pusat/getChartYear/" + cabang;
    $.ajax({
      url: uri,
      headers: {
        "X-Requested-With": "XMLHttpRequest",
      },
      dataType: "json",
      success: function (data) {
        $.each(data, function (i, datas) {
          chart_labels.push(datas.bulan);
          chart_data.push(datas.jumlah);
        });

        var ctx = document.getElementById("chartBig1").getContext("2d");

        var gradientStroke = ctx.createLinearGradient(0, 230, 0, 50);

        gradientStroke.addColorStop(1, "rgba(72,72,176,0.1)");
        gradientStroke.addColorStop(0.4, "rgba(72,72,176,0.0)");
        gradientStroke.addColorStop(0, "rgba(119,52,169,0)"); //purple colors
        var config = {
          type: "line",
          data: {
            labels: chart_labels,
            datasets: [
              {
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
              },
            ],
          },
          options: optionPusatYear(350),
        };
        var myChartData = new Chart(ctx, config);
      },
    });
  },
  initChartMonthly: (month, cabang = null) => {
    var chart_labels = [];
    var chart_data = [];
    var uri =
      cabang == "See All Result"
        ? "/pusat/getChartMonth/" + month
        : "/pusat/getChartMonth/" + month + "/" + cabang;

    $.ajax({
      url: uri,
      headers: {
        "X-Requested-With": "XMLHttpRequest",
      },
      dataType: "json",
      success: function (data) {
        $.each(data, function (i, datas) {
          chart_labels.push(datas.minggu);
          chart_data.push(datas.jumlah);
        });

        var ctx = document.getElementById("chartBig2").getContext("2d");

        var gradientStroke = ctx.createLinearGradient(0, 230, 0, 50);

        gradientStroke.addColorStop(1, "rgba(72,72,176,0.1)");
        gradientStroke.addColorStop(0.4, "rgba(72,72,176,0.0)");
        gradientStroke.addColorStop(0, "rgba(119,52,169,0)"); //purple colors
        var config = {
          type: "line",
          data: {
            labels: chart_labels,
            datasets: [
              {
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
              },
            ],
          },
          options: optionPusatYear(200),
        };
        var myChartData = new Chart(ctx, config);
      },
    });
  },
  pusatChildrenOptions: () => {
    const defaultTableValue = $("#body-table").html();
    const defaultLinkValue = $("#link").html();
    const defaultCabang = $("#cabang").html();

    $("#search-input").on("input propertychange", function () {
      if ($(this).val() === "") {
        $("#link").html("");
        $("#body-table").html("");
        $("#link").append(defaultLinkValue);
        $("#body-table").append(defaultTableValue);
        $("#cabang").html("");
        $("#cabang").append(defaultCabang);
      }
    });

    $("#search-input").on("change", function () {
      if ($(this).val() !== "") {
        $("#link").html("");
        $("#body-table").html("");
        let value = $(this).val();

        $("#link").append(`
        <div class="d-flex justify-content-center">
          <nav aria-label="Page navigation example">
            <ul class="pagination pages">
            
            </ul>
          </nav>
        </div>
        `);

        let url = "";
        if ($("#cabang").val() === "Show All Region") {
          url = "/pusat/getAllChildren";
        } else {
          url = "/pusat/getChildrenCabang/" + $("#cabang").val();
        }

        $.ajax({
          url: url,
          headers: { "X-Requested-With": "XMLHttpRequest" },
          dataType: "json",
          success: function (data) {
            if (data.length === 0) {
              $("#body-table").html("");
              $("#body-table").append(
                `
                  <tr>
                    <td colspan='6' class='text-center'>Data Not Found</td>
                  </tr>
                `
              );
            } else {
              let number = 1;
              var jumlah = 0;
              $("#body-table").html("");
              $.each(data, function (i, datas) {
                let name = datas.children_name
                  .toLowerCase()
                  .includes(value.toLowerCase());
                let code = datas.code
                  .toLowerCase()
                  .includes(value.toLowerCase());

                let pembimbing = datas.name_pembimbing
                  .toLowerCase()
                  .includes(value.toLowerCase());
                let cabang = datas.nama_cabang
                  .toLowerCase()
                  .includes(value.toLowerCase());

                if (name || code || pembimbing || cabang) {
                  $("#body-table").append(
                    `
                  <tr>
                    <td class="text-center">
                        ` +
                      number +
                      `
                    </td>
                    <td>
                        ` +
                      datas.children_name +
                      `
                    </td>
                    <td class="text-center">
                        ` +
                      datas.code +
                      `
                    </td>
                    <td >
                        ` +
                      datas.name_pembimbing +
                      `
                    </td>
                    <td class="text-center">
                    ` +
                      datas.nama_cabang +
                      `
                    </td>
                    <td class="td-actions text-center">
                      <a href="/children/details/` +
                      datas.id_children +
                      `" rel="tooltip" class="btn btn-success btn-sm btn-round btn-icon">
                          <i class="fas fa-search"></i>
                      </a>
                    </td>
                  </tr>
                  `
                  );
                  number++;
                  jumlah++;
                }
              });

              if (jumlah === 0) {
                $("#body-table").html("");
                $("#body-table").append(
                  `
                <tr>
                  <td colspan='6' class='text-center'>Data Not Found</td>
                </tr>
              `
                );
              }

              // pagination
              var trnum = 0;
              var maxRows = 7;
              var totalRows = $("#body-table tr").length;
              $("#body-table tr").each(function () {
                trnum++;
                if (trnum > maxRows) {
                  $(this).hide();
                }

                if (trnum < maxRows) {
                  $(this).show();
                }
              });

              if (totalRows > maxRows) {
                var pageNum = Math.ceil(totalRows / maxRows);
                for (var i = 1; i <= pageNum; i++) {
                  $(".pages")
                    .append(
                      `
                    <li class="page-item" data-page="` +
                        i +
                        `"> 
                      <span class="page-link">` +
                        i +
                        `
                        <span class="sr-only">(current)</span>
                      </span>
                    </li>
                  `
                    )
                    .show();
                }
              }

              $(".pages li:first-child").addClass("active");
              $(".pages li").on("click", function () {
                var pagenum = $(this).attr("data-page");
                var trIndex = 0;
                $(".pages li").removeClass("active");
                $(this).addClass("active");
                $("#body-table tr").each(function () {
                  trIndex++;
                  if (
                    trIndex > maxRows * pagenum ||
                    trIndex <= maxRows * pagenum - maxRows
                  ) {
                    $(this).hide();
                  } else {
                    $(this).show();
                  }
                });
              });
            }
          },
        });
      }
    });

    $("#cabang").on("change", function () {
      $("#search-input").val("");
      let cabang = $(this).val();
      if (cabang === "Show All Region") {
        $("#body-table").html("");
        $("#body-table").append(defaultTableValue);
        $("#link").html("");
        $("#link").append(defaultLinkValue);
      } else {
        $("#link").html("");
        $("#link").append(`
        <div class="d-flex justify-content-center">
          <nav aria-label="Page navigation example">
            <ul class="pagination pages">
            
            </ul>
          </nav>
        </div>
        `);

        const url = "/pusat/getChildrenCabang/" + cabang;
        $.ajax({
          url: url,
          headers: { "X-Requested-With": "XMLHttpRequest" },
          dataType: "json",
          success: function (data) {
            if (data.length === 0) {
              $("#body-table").html("");
              $("#body-table").append(
                `
                  <tr>
                    <td colspan='6' class='text-center'>Data Not Found</td>
                  </tr>
                `
              );
            } else {
              let number = 1;
              var jumlah = 0;
              $("#body-table").html("");

              $.each(data, function (i, datas) {
                $("#body-table").append(
                  `
                  <tr>
                    <td class="text-center">
                        ` +
                    number +
                    `
                    </td>
                    <td>
                        ` +
                    datas.children_name +
                    `
                    </td>
                    <td class="text-center">
                        ` +
                    datas.code +
                    `
                    </td>
                    <td >
                        ` +
                    datas.name_pembimbing +
                    `
                    </td> 
                    <td class="text-center">
                    ` +
                    datas.nama_cabang +
                    `
                    </td> 
                    <td class="td-actions text-center">
                      <a href="/children/details/` +
                    datas.id_children +
                    `" rel="tooltip" class="btn btn-success btn-sm btn-round btn-icon">
                          <i class="fas fa-search"></i>
                      </a>
                    </td>
                  </tr>
                  `
                );
                number++;
                jumlah++;
              });
              if (jumlah === 0) {
                $("#body-table").html("");
                $("#body-table").append(
                  `
                <tr>
                  <td colspan='6' class='text-center'>Data Not Found</td>
                </tr>
              `
                );
              }

              // pagination
              var trnum = 0;
              var maxRows = 7;
              var totalRows = $("#body-table tr").length;
              $("#body-table tr").each(function () {
                trnum++;
                if (trnum > maxRows) {
                  $(this).hide();
                }

                if (trnum < maxRows) {
                  $(this).show();
                }
              });

              if (totalRows > maxRows) {
                var pageNum = Math.ceil(totalRows / maxRows);
                for (var i = 1; i <= pageNum; i++) {
                  $(".pages")
                    .append(
                      `
                    <li class="page-item" data-page="` +
                        i +
                        `"> 
                      <span class="page-link">` +
                        i +
                        `
                        <span class="sr-only">(current)</span>
                      </span>
                    </li>
                  `
                    )
                    .show();
                }
              }

              $(".pages li:first-child").addClass("active");
              $(".pages li").on("click", function () {
                var pagenum = $(this).attr("data-page");
                var trIndex = 0;
                $(".pages li").removeClass("active");
                $(this).addClass("active");
                $("#body-table tr").each(function () {
                  trIndex++;
                  if (
                    trIndex > maxRows * pagenum ||
                    trIndex <= maxRows * pagenum - maxRows
                  ) {
                    $(this).hide();
                  } else {
                    $(this).show();
                  }
                });
              });
            }
          },
        });
      }
    });
  },
  pusatPembimbingOptions: () => {
    const defaultTableValue = $("#body-table").html();
    const defaultLinkValue = $("#link").html();
    const defaultCabang = $("#cabang").html();

    $("#search-input").on("input propertychange", function () {
      if ($(this).val() === "") {
        $("#link").html("");
        $("#body-table").html("");
        $("#link").append(defaultLinkValue);
        $("#body-table").append(defaultTableValue);
        $("#cabang").html("");
        $("#cabang").append(defaultCabang);
      }
    });

    $("#search-input").on("change", function () {
      if ($(this).val() !== "") {
        $("#link").html("");
        $("#body-table").html("");
        let value = $(this).val();

        $("#link").append(`
        <div class="d-flex justify-content-center">
          <nav aria-label="Page navigation example">
            <ul class="pagination pages">
            
            </ul>
          </nav>
        </div>
        `);

        let url = "";
        if ($("#cabang").val() === "Show All Region") {
          url = "/pusat/getPembimbing";
        } else {
          url = "/pusat/getPembimbing/" + $("#cabang").val();
        }

        $.ajax({
          url: url,
          headers: { "X-Requested-With": "XMLHttpRequest" },
          dataType: "json",
          success: function (data) {
            if (data.length === 0) {
              $("#body-table").html("");
              $("#body-table").append(
                `
                  <tr>
                    <td colspan='6' class='text-center'>Data Not Found</td>
                  </tr>
                `
              );
            } else {
              let number = 1;
              var jumlah = 0;
              $("#body-table").html("");
              $.each(data, function (i, datas) {
                let name = datas.name_pembimbing
                  .toLowerCase()
                  .includes(value.toLowerCase());
                let cabang = datas.nama_cabang
                  .toLowerCase()
                  .includes(value.toLowerCase());

                if (name || cabang) {
                  $("#body-table").append(
                    `
                  <tr>
                    <td class="text-center">
                        ` +
                      datas.id_pembimbing +
                      `
                    </td>
                    <td>
                        ` +
                      datas.name_pembimbing +
                      `
                    </td>
                    <td class="text-center">
                        ` +
                      datas.nama_cabang +
                      `
                    </td> 
                  </tr>
                  `
                  );
                  number++;
                  jumlah++;
                }
              });

              if (jumlah === 0) {
                $("#body-table").html("");
                $("#body-table").append(
                  `
                <tr>
                  <td colspan='6' class='text-center'>Data Not Found</td>
                </tr>
              `
                );
              }

              // pagination
              var trnum = 0;
              var maxRows = 7;
              var totalRows = $("#body-table tr").length;
              $("#body-table tr").each(function () {
                trnum++;
                if (trnum > maxRows) {
                  $(this).hide();
                }

                if (trnum < maxRows) {
                  $(this).show();
                }
              });

              if (totalRows > maxRows) {
                var pageNum = Math.ceil(totalRows / maxRows);
                for (var i = 1; i <= pageNum; i++) {
                  $(".pages")
                    .append(
                      `
                    <li class="page-item" data-page="` +
                        i +
                        `"> 
                      <span class="page-link">` +
                        i +
                        `
                        <span class="sr-only">(current)</span>
                      </span>
                    </li>
                  `
                    )
                    .show();
                }
              }

              $(".pages li:first-child").addClass("active");
              $(".pages li").on("click", function () {
                var pagenum = $(this).attr("data-page");
                var trIndex = 0;
                $(".pages li").removeClass("active");
                $(this).addClass("active");
                $("#body-table tr").each(function () {
                  trIndex++;
                  if (
                    trIndex > maxRows * pagenum ||
                    trIndex <= maxRows * pagenum - maxRows
                  ) {
                    $(this).hide();
                  } else {
                    $(this).show();
                  }
                });
              });
            }
          },
        });
      }
    });

    $("#cabang").on("change", function () {
      $("#search-input").val("");
      let cabang = $(this).val();
      if (cabang === "Show All Region") {
        $("#body-table").html("");
        $("#body-table").append(defaultTableValue);
        $("#link").html("");
        $("#link").append(defaultLinkValue);
      } else {
        $("#link").html("");
        $("#link").append(`
        <div class="d-flex justify-content-center">
          <nav aria-label="Page navigation example">
            <ul class="pagination pages">
            
            </ul>
          </nav>
        </div>
        `);

        const url = "/pusat/getPembimbing/" + $("#cabang").val();
        $.ajax({
          url: url,
          headers: { "X-Requested-With": "XMLHttpRequest" },
          dataType: "json",
          success: function (data) {
            if (data.length === 0) {
              $("#body-table").html("");
              $("#body-table").append(
                `
                  <tr>
                    <td colspan='6' class='text-center'>Data Not Found</td>
                  </tr>
                `
              );
            } else {
              let number = 1;
              var jumlah = 0;
              $("#body-table").html("");

              $.each(data, function (i, datas) {
                $("#body-table").append(
                  `
                  <tr>
                    <td class="text-center">
                        ` +
                    number +
                    `
                    </td>
                    <td>
                        ` +
                    datas.name_pembimbing +
                    `
                    </td>
                    <td class="text-center">
                        ` +
                    datas.nama_cabang +
                    `
                    </td>  
                  </tr>
                  `
                );
                number++;
                jumlah++;
              });
              if (jumlah === 0) {
                $("#body-table").html("");
                $("#body-table").append(
                  `
                <tr>
                  <td colspan='6' class='text-center'>Data Not Found</td>
                </tr>
              `
                );
              }

              // pagination
              var trnum = 0;
              var maxRows = 7;
              var totalRows = $("#body-table tr").length;
              $("#body-table tr").each(function () {
                trnum++;
                if (trnum > maxRows) {
                  $(this).hide();
                }

                if (trnum < maxRows) {
                  $(this).show();
                }
              });

              if (totalRows > maxRows) {
                var pageNum = Math.ceil(totalRows / maxRows);
                for (var i = 1; i <= pageNum; i++) {
                  $(".pages")
                    .append(
                      `
                    <li class="page-item" data-page="` +
                        i +
                        `"> 
                      <span class="page-link">` +
                        i +
                        `
                        <span class="sr-only">(current)</span>
                      </span>
                    </li>
                  `
                    )
                    .show();
                }
              }

              $(".pages li:first-child").addClass("active");
              $(".pages li").on("click", function () {
                var pagenum = $(this).attr("data-page");
                var trIndex = 0;
                $(".pages li").removeClass("active");
                $(this).addClass("active");
                $("#body-table tr").each(function () {
                  trIndex++;
                  if (
                    trIndex > maxRows * pagenum ||
                    trIndex <= maxRows * pagenum - maxRows
                  ) {
                    $(this).hide();
                  } else {
                    $(this).show();
                  }
                });
              });
            }
          },
        });
      }
    });
  },
  pusatAbsensiOptions: () => {
    const defaultTableValue = $("#body-table").html();
    const defaultLinkValue = $("#link").html();
    const defaultCabang = $("#cabang").html();
    const defaultSunday = $("#sunday").html();

    $("#search-input").on("input propertychange", function () {
      if ($(this).val() === "") {
        $("#link").html("");
        $("#body-table").html("");
        $("#link").append(defaultLinkValue);
        $("#body-table").append(defaultTableValue);
        $("#cabang").html("");
        $("#cabang").append(defaultCabang);
      }
    });

    $("#cabang").on("change", function () {
      const sunday = $("#sunday");

      if ($(this).val() !== "Show All Region") {
        sunday.html("");
        sunday.append(`
        <option>Show All Date</option>
      `);

        // ajax option sunday date
        $.ajax({
          url: "/pusat/getSundayDate/" + $(this).val(),
          headers: { "X-Requested-With": "XMLHttpRequest" },
          dataType: "json",
          success: function (data) {
            $.each(data, function (i, datas) {
              sunday.append(
                `
              <option>` +
                  datas +
                  `</option>
              `
              );
            });
          },
        });

        // ajax cabang
        $("#search-input").val("");

        $("#link").html("");
        $("#link").append(`
            <div class="d-flex justify-content-center">
              <nav aria-label="Page navigation example">
                <ul class="pagination pages">
                
                </ul>
              </nav>
            </div>
            `);

        $.ajax({
          url: "pusat/getAbsensi/" + $(this).val(),
          headers: { "X-Requested-With": "XMLHttpRequest" },
          dataType: "json",
          success: function (data) {
            if (data.length === 0) {
              $("#body-table").html("");
              $("#body-table").append(
                `
                      <tr>
                        <td colspan='6' class='text-center'>Data Not Found</td>
                      </tr>
                    `
              );
            } else {
              let number = 1;
              var jumlah = 0;
              $("#body-table").html("");

              $.each(data, function (i, datas) {
                $("#body-table").append(
                  `
                      <tr>
                        <td class="text-center">
                            ` +
                    number +
                    `
                        </td>
                        <td>
                            ` +
                    datas.children_name +
                    `
                        </td>
                        <td class="text-center">
                            ` +
                    datas.nama_cabang +
                    `
                        </td>  
                        </td>
                        <td class="text-center">
                            ` +
                    datas.sunday_date +
                    `
                        </td> 
                        <td class="td-actions text-center">
                            <a href="/absensi/details/` +
                    datas.id_absensi +
                    `" rel="tooltip" class="btn btn-success btn-sm btn-round btn-icon">
                                <i class="fas fa-search"></i>
                            </a>
                        </td>
                      </tr>
                      `
                );
                number++;
                jumlah++;
              });
              if (jumlah === 0) {
                $("#body-table").html("");
                $("#body-table").append(
                  `
                    <tr>
                      <td colspan='6' class='text-center'>Data Not Found</td>
                    </tr>
                  `
                );
              }

              // pagination
              var trnum = 0;
              var maxRows = 7;
              var totalRows = $("#body-table tr").length;
              $("#body-table tr").each(function () {
                trnum++;
                if (trnum > maxRows) {
                  $(this).hide();
                }

                if (trnum < maxRows) {
                  $(this).show();
                }
              });

              if (totalRows > maxRows) {
                var pageNum = Math.ceil(totalRows / maxRows);
                for (var i = 1; i <= pageNum; i++) {
                  $(".pages")
                    .append(
                      `
                        <li class="page-item" data-page="` +
                        i +
                        `"> 
                          <span class="page-link">` +
                        i +
                        `
                            <span class="sr-only">(current)</span>
                          </span>
                        </li>
                      `
                    )
                    .show();
                }
              }

              $(".pages li:first-child").addClass("active");
              $(".pages li").on("click", function () {
                var pagenum = $(this).attr("data-page");
                var trIndex = 0;
                $(".pages li").removeClass("active");
                $(this).addClass("active");
                $("#body-table tr").each(function () {
                  trIndex++;
                  if (
                    trIndex > maxRows * pagenum ||
                    trIndex <= maxRows * pagenum - maxRows
                  ) {
                    $(this).hide();
                  } else {
                    $(this).show();
                  }
                });
              });
            }
          },
        });
      } else {
        sunday.html("");
        sunday.append(defaultSunday);
        $("#body-table").html("");
        $("#body-table").append(defaultTableValue);
        $("#link").html("");
        $("#link").append(defaultLinkValue);
        $("#search-input").val("");
      }
    });

    $("#sunday").on("change", function () {
      if ($(this).val() === "Show All Date") {
        location.reload();
      } else {
        if ($("#cabang").val() === "Show All Region") {
          $("#link").html("");
          $("#link").append(`
              <div class="d-flex justify-content-center">
                <nav aria-label="Page navigation example">
                  <ul class="pagination pages">
                  
                  </ul>
                </nav>
              </div>
              `);

          const url = "/pusat/getAbsensi/null/" + $(this).val();
          $.ajax({
            url: url,
            headers: { "X-Requested-With": "XMLHttpRequest" },
            dataType: "json",
            success: function (data) {
              if (data.length === 0) {
                $("#body-table").html("");
                $("#body-table").append(
                  `
                        <tr>
                          <td colspan='6' class='text-center'>Data Not Found</td>
                        </tr>
                      `
                );
              } else {
                let number = 1;
                var jumlah = 0;
                $("#body-table").html("");

                $.each(data, function (i, datas) {
                  $("#body-table").append(
                    `
                        <tr>
                          <td class="text-center">
                              ` +
                      number +
                      `
                          </td>
                          <td>
                              ` +
                      datas.children_name +
                      `
                          </td>
                          <td class="text-center">
                              ` +
                      datas.nama_cabang +
                      `
                          </td>  
                          </td>
                          <td class="text-center">
                              ` +
                      datas.sunday_date +
                      `
                          </td> 
                          <td class="td-actions text-center">
                              <a href="/absensi/details/` +
                      datas.id_absensi +
                      `" rel="tooltip" class="btn btn-success btn-sm btn-round btn-icon">
                                  <i class="fas fa-search"></i>
                              </a>
                          </td>
                        </tr>
                        `
                  );
                  number++;
                  jumlah++;
                });
                if (jumlah === 0) {
                  $("#body-table").html("");
                  $("#body-table").append(
                    `
                      <tr>
                        <td colspan='6' class='text-center'>Data Not Found</td>
                      </tr>
                    `
                  );
                }

                // pagination
                var trnum = 0;
                var maxRows = 7;
                var totalRows = $("#body-table tr").length;
                $("#body-table tr").each(function () {
                  trnum++;
                  if (trnum > maxRows) {
                    $(this).hide();
                  }

                  if (trnum < maxRows) {
                    $(this).show();
                  }
                });

                if (totalRows > maxRows) {
                  var pageNum = Math.ceil(totalRows / maxRows);
                  for (var i = 1; i <= pageNum; i++) {
                    $(".pages")
                      .append(
                        `
                          <li class="page-item" data-page="` +
                          i +
                          `"> 
                            <span class="page-link">` +
                          i +
                          `
                              <span class="sr-only">(current)</span>
                            </span>
                          </li>
                        `
                      )
                      .show();
                  }
                }

                $(".pages li:first-child").addClass("active");
                $(".pages li").on("click", function () {
                  var pagenum = $(this).attr("data-page");
                  var trIndex = 0;
                  $(".pages li").removeClass("active");
                  $(this).addClass("active");
                  $("#body-table tr").each(function () {
                    trIndex++;
                    if (
                      trIndex > maxRows * pagenum ||
                      trIndex <= maxRows * pagenum - maxRows
                    ) {
                      $(this).hide();
                    } else {
                      $(this).show();
                    }
                  });
                });
              }
            },
          });
        } else {
          $("#link").html("");
          $("#link").append(`
              <div class="d-flex justify-content-center">
                <nav aria-label="Page navigation example">
                  <ul class="pagination pages">
                  
                  </ul>
                </nav>
              </div>
              `);

          const url =
            "/pusat/getAbsensi/" + $("#cabang").val() + "/" + $(this).val();
          $.ajax({
            url: url,
            headers: { "X-Requested-With": "XMLHttpRequest" },
            dataType: "json",
            success: function (data) {
              if (data.length === 0) {
                $("#body-table").html("");
                $("#body-table").append(
                  `
                        <tr>
                          <td colspan='6' class='text-center'>Data Not Found</td>
                        </tr>
                      `
                );
              } else {
                let number = 1;
                var jumlah = 0;
                $("#body-table").html("");

                $.each(data, function (i, datas) {
                  $("#body-table").append(
                    `
                        <tr>
                          <td class="text-center">
                              ` +
                      number +
                      `
                          </td>
                          <td>
                              ` +
                      datas.children_name +
                      `
                          </td>
                          <td class="text-center">
                              ` +
                      datas.nama_cabang +
                      `
                          </td>  
                          </td>
                          <td class="text-center">
                              ` +
                      datas.sunday_date +
                      `
                          </td> 
                          <td class="td-actions text-center">
                              <a href="/absensi/details/` +
                      datas.id_absensi +
                      `" rel="tooltip" class="btn btn-success btn-sm btn-round btn-icon">
                                  <i class="fas fa-search"></i>
                              </a>
                          </td>
                        </tr>
                        `
                  );
                  number++;
                  jumlah++;
                });
                if (jumlah === 0) {
                  $("#body-table").html("");
                  $("#body-table").append(
                    `
                      <tr>
                        <td colspan='6' class='text-center'>Data Not Found</td>
                      </tr>
                    `
                  );
                }

                // pagination
                var trnum = 0;
                var maxRows = 7;
                var totalRows = $("#body-table tr").length;
                $("#body-table tr").each(function () {
                  trnum++;
                  if (trnum > maxRows) {
                    $(this).hide();
                  }

                  if (trnum < maxRows) {
                    $(this).show();
                  }
                });

                if (totalRows > maxRows) {
                  var pageNum = Math.ceil(totalRows / maxRows);
                  for (var i = 1; i <= pageNum; i++) {
                    $(".pages")
                      .append(
                        `
                          <li class="page-item" data-page="` +
                          i +
                          `"> 
                            <span class="page-link">` +
                          i +
                          `
                              <span class="sr-only">(current)</span>
                            </span>
                          </li>
                        `
                      )
                      .show();
                  }
                }

                $(".pages li:first-child").addClass("active");
                $(".pages li").on("click", function () {
                  var pagenum = $(this).attr("data-page");
                  var trIndex = 0;
                  $(".pages li").removeClass("active");
                  $(this).addClass("active");
                  $("#body-table tr").each(function () {
                    trIndex++;
                    if (
                      trIndex > maxRows * pagenum ||
                      trIndex <= maxRows * pagenum - maxRows
                    ) {
                      $(this).hide();
                    } else {
                      $(this).show();
                    }
                  });
                });
              }
            },
          });
        }
      }
    });

    $("#search-input").on("input propertychange", function () {
      if ($(this).val() === "") {
        $("#link").html("");
        $("#body-table").html("");
        $("#link").append(defaultLinkValue);
        $("#body-table").append(defaultTableValue);
        $("#cabang").html("");
        $("#cabang").append(defaultCabang);
        $("#sunday").html("");
        $("#sunday").append(defaultSunday);
      }
    });

    $("#search-input").on("change", function () {
      if ($(this).val() !== "") {
        $("#link").html("");
        $("#body-table").html("");
        let value = $(this).val();

        $("#link").append(`
        <div class="d-flex justify-content-center">
          <nav aria-label="Page navigation example">
            <ul class="pagination pages">
            
            </ul>
          </nav>
        </div>
        `);

        let url = "";
        if (
          $("#cabang").val() === "Show All Region" &&
          $("#sunday").val() === "Show All Date"
        ) {
          url = "/pusat/getAbsensi";
        } else if (
          $("#cabang").val() !== "Show All Region" &&
          $("#sunday").val() === "Show All Date"
        ) {
          url = "/pusat/getAbsensi/" + $("#cabang").val();
        } else if (
          $("#cabang").val() === "Show All Region" &&
          $("#sunday").val() !== "Show All Date"
        ) {
          url = "/pusat/getAbsensi/null/" + $("#sunday").val();
        } else {
          url =
            "/pusat/getAbsensi/" +
            $("#cabang").val() +
            "/" +
            $("#sunday").val();
        }
        $.ajax({
          url: url,
          headers: { "X-Requested-With": "XMLHttpRequest" },
          dataType: "json",
          success: function (data) {
            if (data.length === 0) {
              $("#body-table").html("");
              $("#body-table").append(
                `
                  <tr>
                    <td colspan='6' class='text-center'>Data Not Found</td>
                  </tr>
                `
              );
            } else {
              let number = 1;
              var jumlah = 0;
              $("#body-table").html("");
              $.each(data, function (i, datas) {
                let name = datas.children_name
                  .toLowerCase()
                  .includes(value.toLowerCase());
                let cabang = datas.nama_cabang
                  .toLowerCase()
                  .includes(value.toLowerCase());

                if (name || cabang) {
                  $("#body-table").append(
                    `
                  <tr>
                    <td class="text-center">
                        ` +
                      number +
                      `
                    </td>
                    <td>
                        ` +
                      datas.children_name +
                      `
                    </td>
                    <td class="text-center">
                        ` +
                      datas.nama_cabang +
                      `
                    </td> 
                    <td class="text-center">
                        ` +
                      datas.sunday_date +
                      `
                    </td>
                    <td class="td-actions text-center">
                            <a href="/absensi/details/` +
                      datas.id_absensi +
                      `" rel="tooltip" class="btn btn-success btn-sm btn-round btn-icon">
                                <i class="fas fa-search"></i>
                            </a>
                        </td>
                  </tr>
                  `
                  );
                  number++;
                  jumlah++;
                }
              });

              if (jumlah === 0) {
                $("#body-table").html("");
                $("#body-table").append(
                  `
                <tr>
                  <td colspan='6' class='text-center'>Data Not Found</td>
                </tr>
              `
                );
              }

              // pagination
              var trnum = 0;
              var maxRows = 7;
              var totalRows = $("#body-table tr").length;
              $("#body-table tr").each(function () {
                trnum++;
                if (trnum > maxRows) {
                  $(this).hide();
                }

                if (trnum < maxRows) {
                  $(this).show();
                }
              });

              if (totalRows > maxRows) {
                var pageNum = Math.ceil(totalRows / maxRows);
                for (var i = 1; i <= pageNum; i++) {
                  $(".pages")
                    .append(
                      `
                    <li class="page-item" data-page="` +
                        i +
                        `"> 
                      <span class="page-link">` +
                        i +
                        `
                        <span class="sr-only">(current)</span>
                      </span>
                    </li>
                  `
                    )
                    .show();
                }
              }

              $(".pages li:first-child").addClass("active");
              $(".pages li").on("click", function () {
                var pagenum = $(this).attr("data-page");
                var trIndex = 0;
                $(".pages li").removeClass("active");
                $(this).addClass("active");
                $("#body-table tr").each(function () {
                  trIndex++;
                  if (
                    trIndex > maxRows * pagenum ||
                    trIndex <= maxRows * pagenum - maxRows
                  ) {
                    $(this).hide();
                  } else {
                    $(this).show();
                  }
                });
              });
            }
          },
        });
      }
    });
  },
  pusatHistoryAbsensiPagination: () => {
    $(document).ready(function () {
      $("#link-history").append(`
      <div class="d-flex justify-content-center">
        <nav aria-label="Page navigation example">
          <ul class="pagination pages">
          
          </ul>
        </nav>
      </div>
      `);

      // pagination
      var trnum = 0;
      var maxRows = 7;
      var totalRows = $("#body-table-history tr").length;
      $("#body-table-history tr").each(function () {
        trnum++;
        if (trnum > maxRows) {
          $(this).hide();
        }

        if (trnum < maxRows) {
          $(this).show();
        }
      });

      if (totalRows > maxRows) {
        var pageNum = Math.ceil(totalRows / maxRows);
        for (var i = 1; i <= pageNum; i++) {
          $(".pages")
            .append(
              `
        <li class="page-item" data-page="` +
                i +
                `">
          <span class="page-link">` +
                i +
                `
            <span class="sr-only">(current)</span>
          </span>
        </li>
      `
            )
            .show();
        }
      }

      $(".pages li:first-child").addClass("active");
      $(".pages li").on("click", function () {
        var pagenum = $(this).attr("data-page");
        var trIndex = 0;
        $(".pages li").removeClass("active");
        $(this).addClass("active");
        $("#body-table-history tr").each(function () {
          trIndex++;
          if (
            trIndex > maxRows * pagenum ||
            trIndex <= maxRows * pagenum - maxRows
          ) {
            $(this).hide();
          } else {
            $(this).show();
          }
        });
      });
    });
  },
  pusatHistoryCabangOption: () => {
    const defaultTableValue = $("#body-table-history").html();
    const defaultLinkValue = $("#link-history").html();
    $("#cabang").on("change", function () {
      let value = $(this).val();
      if (value !== "Show All Region") {
        $.ajax({
          url: "/pusat/getHistorys/" + value,
          headers: { "X-Requested-With": "XMLHttpRequest" },
          dataType: "json",
          success: function (data) {
            if (data.length === 0) {
              $("#body-table-history").html("");
              $("#body-table-history").append(
                `
                      <tr>
                        <td colspan='6' class='text-center'>Data Not Found</td>
                      </tr>
                    `
              );
            } else {
              let number = 1;
              var jumlah = 0;
              $("#body-table-history").html("");

              $.each(data, function (i, datas) {
                const splitin = datas.split("-");
                const month = splitin[0];
                const year = splitin[1];
                const cabang = splitin[2];

                $("#body-table-history").append(
                  `
                      <tr>
                        <td class="text-center">
                            ` +
                    number +
                    `
                        </td>
                        <td>
                            ` +
                    month +
                    `
                        </td>
                        <td class="text-center">
                            ` +
                    year +
                    `
                        </td>  
                        </td>
                        <td class="text-center">
                            ` +
                    cabang +
                    `
                        </td> 
                        <td class="td-actions text-center">
                        <a href="pusat/export/` +
                    month +
                    `/` +
                    year +
                    `/` +
                    cabang +
                    `" rel="tooltip" class="mr-3 btn btn-success btn-sm btn-round btn-icon">
                            <i class="far fa-file-excel"></i>
                        </a>
                    </td>
                      </tr>
                      `
                );
                number++;
                jumlah++;
              });
              if (jumlah === 0) {
                $("#body-table-history").html("");
                $("#body-table-history").append(
                  `
                    <tr>
                      <td colspan='6' class='text-center'>Data Not Found</td>
                    </tr>
                  `
                );
              }

              // pagination
              var trnum = 0;
              var maxRows = 7;
              var totalRows = $("#body-table-history tr").length;
              $("#body-table-history tr").each(function () {
                trnum++;
                if (trnum > maxRows) {
                  $(this).hide();
                }

                if (trnum < maxRows) {
                  $(this).show();
                }
              });

              if (totalRows > maxRows) {
                var pageNum = Math.ceil(totalRows / maxRows);
                for (var i = 1; i <= pageNum; i++) {
                  $(".pages")
                    .append(
                      `
                        <li class="page-item" data-page="` +
                        i +
                        `"> 
                          <span class="page-link">` +
                        i +
                        `
                            <span class="sr-only">(current)</span>
                          </span>
                        </li>
                      `
                    )
                    .show();
                }
              }

              $(".pages li:first-child").addClass("active");
              $(".pages li").on("click", function () {
                var pagenum = $(this).attr("data-page");
                var trIndex = 0;
                $(".pages li").removeClass("active");
                $(this).addClass("active");
                $("#body-table tr").each(function () {
                  trIndex++;
                  if (
                    trIndex > maxRows * pagenum ||
                    trIndex <= maxRows * pagenum - maxRows
                  ) {
                    $(this).hide();
                  } else {
                    $(this).show();
                  }
                });
              });
            }
          },
        });
      } else {
        $("#body-table-history").html("");
        $("#link-history").html("");
        $("#body-table-history").append(defaultTableValue);
        $("#link-history").append(defaultLinkValue);
      }
    });
  },
};
