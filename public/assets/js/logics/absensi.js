$(document).ready(function () {
  const defaultTableValue = $("#body-table").html();
  const defaultLinkValue = $("#link").html();
  const defaultSelect =
    '<option value="">Select Pembimbing Name First</option>';
  // searching
  $("#children-select").append(defaultSelect);

  $("#search-input").on("input propertychange", function () {
    if ($(this).val() === "") {
      $("#link").html("");
      $("#body-table").html("");
      $("#link").append(defaultLinkValue);
      $("#body-table").append(defaultTableValue);
    }
  });

  $("#search-input").on("change", function () {
    $("#link").html("");
    $("#body-table").html("");
    let value = $(this).val();

    if (value == "") {
      $("#link").html("");
      $("#body-table").html("");
      $("#link").append(defaultLinkValue);
      $("#body-table").append(defaultTableValue);
    } else {
      $("#link").append(`
        <div class="d-flex justify-content-center">
          <nav aria-label="Page navigation example">
            <ul class="pagination pages">
            
            </ul>
          </nav>
        </div>
        `);

      $.ajax({
        url: "/absensi/search",
        headers: { "X-Requested-With": "XMLHttpRequest" },
        dataType: "json",
        success: function (data) {
          if (data.length === 0) {
            $("#body-table").html("");
            $("#body-table").append(
              `
                    <tr>
                      <td colspan='8' class='text-center'>Data Not Found</td>
                    </tr>
                  `
            );
          } else {
            var number = 1;
            var jumlah = 0;
            $("#body-table").html("");
            $.each(data, function (i, datas) {
              let name = datas.children_name
                .toLowerCase()
                .includes(value.toLowerCase());
              let code = datas.code.toLowerCase().includes(value.toLowerCase());
              let month = datas.month
                .toLowerCase()
                .includes(value.toLowerCase());
              let pembimbing = datas.name_pembimbing
                .toLowerCase()
                .includes(value.toLowerCase());
              let role = datas.role.toLowerCase().includes(value.toLowerCase());
              let sundayDate = datas.sunday_date
                .toLowerCase()
                .includes(value.toLowerCase());

              if (name || code || month || pembimbing || role || sundayDate) {
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
                      <td>
                          ` +
                    datas.name_pembimbing +
                    `
                      </td>
                      <td class="text-center">
                          ` +
                    datas.video +
                    `
                      </td>
                      <td>
                      ` +
                    datas.image +
                    `
                      </td>
                      <td>
                      ` +
                    datas.quiz +
                    `
                      </td>
                      <td class="text-center">
                      ` +
                    datas.sunday_date +
                    `
                      </td>
                      <td class="td-actions text-center">
                      <a href="/absensi/edit/` +
                    datas.id_absensi +
                    `" rel="tooltip" class="mr-3 btn btn-success btn-sm btn-round btn-icon">
                          <i class="tim-icons icon-settings"></i>
                        </a>
                        <form action="/absensi/` +
                    datas.id_absensi +
                    `" method="POST" class="d-inline">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" rel="tooltip" onclick="return confirm('Are You Sure Want To Delete ?');" class="btn btn-danger btn-sm btn-round btn-icon">
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </form>
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
                    <td colspan='8' class='text-center'>Data Not Found</td>
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

  // get data by selected id
  $("#pembimbing-select").on("change", function () {
    const id = $(this).val();
    if (id === "") {
      $("#children-select").html(defaultSelect);
    } else {
      $("#children-select").html(
        '<option value="">Select Children Name</option>'
      );

      $.ajax({
        url: "/absensi/getChildPembimbing/" + id,
        headers: { "X-Requested-With": "XMLHttpRequest" },
        dataType: "json",
        success: function (datas) {
          $.each(datas, function (i, data) {
            $("#children-select").append(
              '<option value="' +
                data.id_children +
                '">' +
                data.children_name +
                "</option>"
            );
          });
        },
      });
    }
  });

  // pagination history
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
  var maxRows = 6;
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

  $("#select-year").on("change", function () {
    let value = $(this).val();
    var number = 1;
    if (value === "all") {
      $("#body-table-history").html("");
      $("#link-history").html("");
      $.ajax({
        url: "/history/searchall",
        headers: { "X-Requested-With": "XMLHttpRequest" },
        dataType: "json",
        success: function (data) {
          $.each(data, function (i, datas) {
            $("#body-table-history").append(
              `
              <tr>
                <td class="text-center">
                    ` +
                number +
                `
                </td>
                <td class="text-center">
                    ` +
                datas.month +
                `
                </td>
                <td class="text-center">
                    ` +
                datas.year +
                `
                </td>
                 
                <td class="td-actions text-center">
                    
                <a href=" " rel="tooltip" class="mr-3 btn btn-success btn-sm btn-round btn-icon">
                  <i class="far fa-file-excel"></i>
                </a>
                </td>
              </tr>
              `
            );

            number++;
          });

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
          var maxRows = 6;
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
        },
      });
    } else {
      var number = 1;
      $("#body-table-history").html("");
      $("#link-history").html("");
      $.ajax({
        url: "/history/search/" + value,
        headers: { "X-Requested-With": "XMLHttpRequest" },
        dataType: "json",
        success: function (data) {
          $.each(data, function (i, datas) {
            $("#body-table-history").append(
              `
              <tr>
                <td class="text-center">
                    ` +
                number +
                `
                </td>
                <td class="text-center">
                    ` +
                datas.month +
                `
                </td>
                <td class="text-center">
                    ` +
                datas.year +
                `
                </td>
                 
                <td class="td-actions text-center">
                    
                <a href="/export/` +
                datas.month +
                `/` +
                datas.year +
                `" rel="tooltip" class="mr-3 btn btn-success btn-sm btn-round btn-icon">
                        <i class="far fa-file-excel"></i>
                    </a>
                </td>
              </tr>
              `
            );

            number++;
          });

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
          var maxRows = 6;
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
        },
      });
    }
  });
});
