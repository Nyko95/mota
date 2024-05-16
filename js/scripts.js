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

/* OUVERTURE DE LA MODALE DE CONTACT AU CLIC SUR LE BOUTON "CONTACT"*/

jQuery(document).ready(function ($) {
  // Ouvrir la modale de contact au clic sur le bouton "Contact"
  $(".open-contact-modal").on("click", function () {
    // Ouvre la modale de contact ici
  });
});

/*Pour recuperer la ref de la photo dynamiquement A MODIFIER PAR LA SUITE classe "reference-photo"*/

jQuery(document).ready(function ($) {
  // Ouvrir la modale de contact au clic sur le bouton "Contact"
  $(".open-contact-modal").on("click", function () {
    // Ouvre la modale de contact
    $("#modal-contact").fadeIn();

    // Récupère la référence de la photographie
    var referencePhoto = $(".reference-photo").text().trim(); // Récupère le texte dans l'élément avec la classe "reference-photo"

    // Injecte la référence de la photographie dans le champ "RÉF. PHOTO" de la modale
    $(".wpcf7-form-control-wrap").val(referencePhoto);
  });
});
