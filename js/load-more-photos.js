// Attends que le document soit prêt
jQuery(document).ready(function ($) {
  // Initialiser Select2 sur les sélecteurs
  $("#category-filter, #format-filter, #order-filter").select2();

  var page = 1;
  var loading = false;

  // Fonction pour charger les photos
  function loadPhotos(reset = false) {
    if (loading) return; // Vérification si une requête AJAX est déjà en cours
    loading = true;

    var category = $("#category-filter").val();
    var format = $("#format-filter").val();
    var order = $("#order-filter").val();

    $.ajax({
      url: mota_params.ajax_url,
      type: "POST",
      data: {
        action: "filter_photos",
        category: category,
        format: format,
        order: order,
        page: page,
      },
      success: function (response) {
        if (response.success) {
          if (reset) {
            $("#photo-gallery").html(response.data);
            page = 2;
          } else {
            $("#photo-gallery").append(response.data);
            page++;
          }
        } else {
          console.error(response.data);
        }
        loading = false;
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error: ", status, error);
        loading = false;
      },
    });
  }

  // Gérer les changements sur les éléments de filtre
  $("#category-filter, #format-filter, #order-filter").change(function () {
    page = 1;
    loadPhotos(true);
  });

  // Gérer le clic sur le bouton "Appliquer"
  $("#apply-filters").on("click", function () {
    page = 1;
    loadPhotos(true);
  });

  // Gérer le clic sur le bouton "Charger plus"
  $("#load-more .load-more-button").on("click", function (e) {
    e.preventDefault();
    loadPhotos();
  });

  // Charger les photos initiales
  loadPhotos(true);
});
