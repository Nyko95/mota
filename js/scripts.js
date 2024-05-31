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
  // Ouverture de la modale de contact au clic sur le bouton "Contact" dans les articles
  $(".open-contact-modal").on("click", function (e) {
    e.preventDefault();
    e.stopPropagation(); // Empêche la propagation de l'événement de clic

    // Récupérer la référence de la photo
    var photoReference = $(this).data("reference");
    // Préremplir le champ "RÉF. PHOTO"
    $("#referencePhoto").val(photoReference);

    // Ouvrir la modale de contact
    $("#modal-contact").fadeIn();
  });

  // Fermeture de la modale au clic sur le bouton de fermeture
  $(".modal-close").on("click", function () {
    $("#modal-contact").fadeOut();
  });

  // Fermeture de la modale au clic en dehors de celle-ci
  $(document).on("click", function (e) {
    if (
      !$(e.target).closest(".modal-content").length &&
      !$(e.target).is(".open-contact-modal-article")
    ) {
      $("#modal-contact").fadeOut();
    }
  });
});

//JS POUR MINIATURES

jQuery(document).ready(function ($) {
  // Au survol de la flèche de gauche
  $(".prev-photo-link").hover(
    function () {
      // Afficher la miniature correspondante
      $(this).find(".thumbnail-preview").css("opacity", 1);
    },
    function () {
      // Cacher la miniature lorsque le survol est terminé
      $(this).find(".thumbnail-preview").css("opacity", 0);
    }
  );

  // Au survol de la flèche de droite
  $(".next-photo-link").hover(
    function () {
      // Afficher la miniature correspondante
      $(this).find(".thumbnail-preview").css("opacity", 1);
    },
    function () {
      // Cacher la miniature lorsque le survol est terminé
      $(this).find(".thumbnail-preview").css("opacity", 0);
    }
  );
});

//AJOUT D'UNE CLASSE POUR CIBLER LE DERNIER ELEMENT DANS LE FOOTER POUR LA VERSION RESPONSIVE

jQuery(document).ready(function ($) {
  // Sélectionne le dernier élément de la liste du menu de pied de page et lui ajoute une classe
  $("#footer-menu li:last-child a").addClass("last-link");
});
