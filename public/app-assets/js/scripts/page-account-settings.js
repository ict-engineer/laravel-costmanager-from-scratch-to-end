/* Account Settings */
/* ----------------*/
$(document).ready(function () {
  
  // music select init
  var musicselect = $("#musicselect2").select2({
    dropdownAutoWidth: true,
    width: '100%'
  });
  // movies select init
  var moviesselect = $("#moviesselect2").select2({
    dropdownAutoWidth: true,
    width: '100%'
  });
  // language select init
  var languageselect = $("#languageselect2").select2({
    dropdownAutoWidth: true,
    width: '100%'
  });
  /*  UI - Alerts */
  $(".card-alert .close").click(function () {
    $(this)
      .closest(".card-alert")
      .fadeOut("slow");
  });
  
  // upload button converting into file button
  $("#select-files").on("click", function () {
    $("#upfile").click();
  })

  $("#select-logo-files").on("click", function (e) {
      e.preventDefault();
    $("#upfileLogo").click();
  })
});