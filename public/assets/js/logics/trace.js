$(document).ready(function () {
  $("#year").hide();
  $("#month").hide();
  $("#btn").hide();

  $("#cabang-select").on("change", function () {
    if ($(this).val() === "Select Cabang") {
      $("#year").hide();
      return false;
    }

    $("#year").show();

    let uri = "/children/trace/getYear/" + $(this).val();

    $.ajax({
      url: uri,
      headers: { "X-Requested-With": "XMLHttpRequest" },
      dataType: "json",
      success: function (data) {
        if (data.length == 0) {
          $("#year-select").html("<option>No Absensi History</option>");
        } else {
          $("#year-select").html("<option>Select Year</option>");
          $.each(data, function (i, datas) {
            $("#year-select").append(
              `
                    <option>` +
                datas +
                `</option>
                `
            );
          });
        }
      },
    });
  });
  $("#year-select").on("change", function () {
    if ($(this).val() === "Select Year") {
      $("#month").hide();
      return false;
    }

    $("#month").show();

    $.ajax({
      url:
        "/children/trace/getMonth/" +
        $(this).val() +
        "/" +
        $("#cabang-select").val(),
      headers: { "X-Requested-With": "XMLHttpRequest" },
      dataType: "json",
      success: function (data) {
        if (data.length == 0) {
          $("#month-select").html("<option>No Absensi History</option>");
        } else {
          $("#month-select").html("<option>Select Month</option>");
          $.each(data, function (i, datas) {
            $("#month-select").append(
              `
                    <option>` +
                datas +
                `</option>
                `
            );
          });
        }
      },
    });
  });
  $("#month-select").on("change", function () {
    if ($(this).val() === "Select Month") {
      $("#btn").hide();
      return false;
    }

    $("#btn").show();

    let uri =
      "/children/trace/" +
      $("#year-select").val() +
      "/" +
      $(this).val() +
      "/" +
      $("#cabang-select").val();

    $("#btn").attr("href", uri);
  });
});
