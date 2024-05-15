/*OUVERTURE DE LA MODALE SUR LE LIEN "CONTACT" ET FERMETURE*/

jQuery(document).ready(function ($) {
  // Ouvrir la modale au clic sur le lien "Contact" dans le header
  $(".menu-item-17").on("click", function (e) {
    e.preventDefault();
    e.stopPropagation(); // Empêche la propagation de l'événement de clic
    $("#modal-contact").fadeIn();
  });

  // Fermer la modale au clic sur le bouton de fermeture
  $(".modal-close").on("click", function () {
    $(".modal").fadeOut();
  });

  // Fermer la modale au clic en dehors de celle-ci
  $(document).on("click", function (e) {
    if (
      !$(e.target).closest(".modal-content").length &&
      !$(e.target).is(".menu-item-17")
    ) {
      $(".modal").fadeOut();
    }
  });
});
