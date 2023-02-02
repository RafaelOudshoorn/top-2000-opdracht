$(document).ready(function () {
  if ($("#search_artist").val().length == 0) {
    $("#search_song").prop("disabled", true);
  } else {
    $("#search_song").prop("disabled", false);
  }
  $("#search_artist").keyup(function () {
    if ($("#search_artist").val().length == 0) {
      $("#search_song").prop("disabled", true);
    } else {
      $("#search_song").prop("disabled", false);
    }
    var Search = $("#search_artist").val();

    if (Search != "") {
      $.ajax({
        url: "../private/managers/search.php",
        method: "POST",
        data: { search: Search },
        success: function (data) {
          $("#content").html(data);
        },
      });
    } else {
      $("#content").html("");
    }

    $(document).on("click", "a", function () {
      $("#Search").val($(this).text());
      $("#content").html("");
    });
  });

  $("#search_song").keyup(function () {
    if ($("#search_artist").val().length == 0) {
      $("#search_song").prop("disabled", true);
    }else {
      $("#search_song").prop("disabled", false);
    }
    var searchTrack = $("#search_song").val();
    var Search = $("#search_artist").val();

    if (searchTrack != "") {
      $.ajax({
        url: "../private/managers/search.php",
        method: "POST",
        data: { song: searchTrack, search: Search },
        success: function (data) {
          $("#content_2").html(data);
        },
      });
    } else {
      $("#content_2").html("");
    }

    $(document).on("click", "a", function () {
      $("#Search").val($(this).text());
      $("#content_2").html("");
    });
  });
});
