$("#month").hide();
$("#btn").hide();
$("#year-select").on("change", function () {
  if ($(this).val() === "Select Year") {
    $("#month").hide();
    return false;
  }

  $("#month").show();

  $.ajax({
    url: "/children/trace/getMonth/" + $(this).val(),
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

  let uri = "/children/trace/" + $("#year-select").val() + "/" + $(this).val();

  $("#btn").attr("href", uri);
});
