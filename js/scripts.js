/*GESTION DE L'APPARITION ET DISPARITION DE LA MODALE DE CONTACT*/

jQuery(document).ready(function ($) {
  // Ouvrir la modale au clic sur le lien de contact
  $(".contact-modal-link").on("click", function (e) {
    e.preventDefault();
    $("#modal-contact").fadeIn();
  });

  // Fermer la modale au clic sur le bouton de fermeture
  $(".modal-close").on("click", function () {
    $("#modal-contact").fadeOut();
  });

  // Fermer la modale au clic en dehors de la modale
  $(document).on("click", function (e) {
    if (
      !$(e.target).closest(".modal-content").length &&
      !$(e.target).is(".contact-modal-link")
    ) {
      $("#modal-contact").fadeOut();
    }
  });
});
