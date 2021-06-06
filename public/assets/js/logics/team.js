let defaultOptions = $("#cabang").html();
$("#groups").on("change", function () {
  if ($(this).val() == 3) {
    $("#cabang").html("");

    let idPusat = "";
    $.ajax({
      url: "/team/cabang",
      headers: {
        "X-Requested-With": "XMLHttpRequest",
      },
      dataType: "json",
      success: function (data) {
        $.each(data, function (i, datas) {
          if (datas.nama_cabang === "pusat") {
            idPusat = datas.id_cabang;
          }
        });
        $("#cabang").html(
          `<optgroup label="All Options">
                                <option value="">Select Cabang</option>
                                <option value="` +
            idPusat +
            `">Pusat</option>
                            </optgroup>`
        );
      },
    });
  } else {
    console.log(defaultOptions);
    $("#cabang").html("");
    $("#cabang").html(defaultOptions);
  }
});
