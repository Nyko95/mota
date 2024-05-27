jQuery(document).ready(function ($) {
  var page = 2;
  $("#load-more").on("click", function () {
    var button = $(this);
    var postID = button.data("post-id");

    $.ajax({
      url: mota_params.ajax_url,
      type: "POST",
      data: {
        action: "load_more_photos", // Utilisez le même nom d'action que celui déclaré dans le fichier functions.php
        page: page,
        post_id: postID,
      },
      success: function (response) {
        if (response) {
          $(".related-photos-grid").append(response);
          page++;
        } else {
          button.text("Charger plus").prop("disabled", true);
        }
      },
    });
  });
});
