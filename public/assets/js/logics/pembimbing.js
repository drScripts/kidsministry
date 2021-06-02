$(document).ready(function () {
  const defaultTableValue = $("#body-table").html();
  const defaultLinkValue = $("#link").html();

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
        url: "/pembimbing/search",
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
            var jumlah = 0;
            var number = 1;
            $("#body-table").html("");
            $.each(data, function (i, datas) {
              let pembimbing = datas.name_pembimbing
                .toLowerCase()
                .includes(value.toLowerCase());

              if (pembimbing) {
                console.log("hai");
                $("#body-table").append(
                  `
                    <tr>
                      <td class="text-center">
                          ` +
                    number +
                    `
                      </td> 
                      <td >
                          ` +
                    datas.name_pembimbing +
                    `
                      </td>  
                      <td class="td-actions text-center">
                      <a href="/pembimbing/edit/` +
                    datas.id_pembimbing +
                    `" rel="tooltip" class="mr-3 btn btn-success btn-sm btn-round btn-icon">
                        <i class="tim-icons icon-settings"></i>
                      </a>
                  <form action="/pembimbing/` +
                    datas.id_pembimbing +
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
});
