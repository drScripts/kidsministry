const rangking = {
  pusat: () => {
    const defaultSelect = $("#first").html();

    let kelas = [];
    const date = [];
    $("#start-field").hide();
    $("#end-field").hide();
    $("#button").hide();
    $("#ranking-field").hide();
    $("#addClass").hide();
    $("#row-kelas").hide();
    $("#removeClass").hide();

    $("#cabang").on("change", function () {
      if ($(this).val() === "Select Cabang Name") {
        $("#year").html("<option>Please Select Cabang Name First</option>");
        return false;
      }

      const uri = "/rank/getYear/" + $(this).val();

      $.ajax({
        url: uri,
        headers: { "X-Requested-With": "XMLHttpRequest" },
        dataType: "json",
        success: function (data) {
          if (data.length == 0) {
            $("#year").html("<option>No Absensi History</option>");
          } else {
            $("#year").html("<option>Select Year Absensi</option>");
            $.each(data, function (i, datas) {
              $("#year").append(
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
      //
    });

    $("#year").on("change", function () {
      let cabang = $("#cabang").val();
      let year = $(this).val();

      if (year === "Select Year Absensi") {
        $("#start-field").hide();
        $("#end-field").hide();
        $("#button").hide();
        return false;
      }

      const uri = "/rank/getDate/" + cabang + "/" + year;

      $.ajax({
        url: uri,
        headers: { "X-Requested-With": "XMLHttpRequest" },
        dataType: "json",
        success: function (data) {
          $("#start-field").show();
          $("#start").html("<option>Select Start Date</option>");
          $.each(data, function (i, datas) {
            date.push(datas);
            $("#start").append(
              `
            <option>` +
                datas +
                `</option>
            `
            );
          });
        },
      });
    });

    $("#start").on("change", function () {
      if ($(this).val() === "Select Start Date") {
        $("#end-field").hide();
        $("#button").hide();
        return false;
      }

      let beforeSelected = 0;
      for (let index = 0; index < date.length; index++) {
        if (date[index] === $(this).val()) {
          beforeSelected = index;
        }
      }

      let endDate = [];

      for (let index = 0; index < date.length; index++) {
        if (index > beforeSelected) {
          endDate.push(date[index]);
        }
      }

      $("#end-field").show();
      $("#end").html(`<option>Select End Date</option>`);
      $.each(endDate, function (i, datas) {
        $("#end").append(`<option>` + datas + `</option>`);
      });
    });

    $("#end").on("change", function () {
      if ($(this).val() === "Select End Date") {
        $("#button").hide();
        $("#ranking-field").hide();
        return false;
      }

      $("#ranking-field").show();
      $("#button").show();

      let uri =
        "/rank/getKelas/" +
        $("#cabang").val() +
        "/" +
        $("#start").val() +
        "/" +
        $("#end").val();
      $.ajax({
        url: uri,
        headers: { "X-Requested-With": "XMLHttpRequest" },
        dataType: "json",
        success: function (datas) {
          $.each(datas, function (i, data) {
            kelas.push(
              `
              <option value='` +
                data +
                `'>${data}</option>
            `
            );
          });
        },
      });
    });

    $("#class3").on("change", function () {
      $("#addClass").show();
      $("#row-kelas").show();
      $("#first").attr("disabled", false);
      $("#first").html("");
      $("#first").append("<option value=''>pilih kelas</option>");
      $("#first").append(kelas);
    });

    $("#class2").on("change", function () {
      $("#addClass").hide();
      $("#row-kelas").hide();
      $("#first").attr("disabled", true);
    });

    $("#class1").on("change", function () {
      $("#addClass").hide();
      $("#row-kelas").hide();
      $("#first").attr("disabled", true);
    });

    $("#addClass").on("click", function () {
      let jumlah = $("#row-kelas #first").length;

      if (jumlah < kelas.length) {
        $("#row-kelas").append(
          `<div class="col-3" id="col">
          <select id='first' class="form-control" name="kelas[]">
              <option value=''>pilih kelas</option>
              ` +
            kelas +
            `
          </select>
      </div>`
        );
      }

      if (jumlah < kelas.length) {
        $(this).hide();
        $("#removeClass").show();
      }
    });

    $("#removeClass").on("click", function () {
      $("#row-kelas #col").last().remove();
      let jumlah = $("#row-kelas #first").length;
      if (jumlah === 1) {
        $(this).hide();
        $("#addClass").show();
      }
    });
  },
};
