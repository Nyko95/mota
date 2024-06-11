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

  // Sélectionne le dernier élément de la liste du menu de pied de page et lui ajoute une classe
  $("#footer-menu li:last-child a").addClass("last-link");
});

// MENU BURGER
document.addEventListener("DOMContentLoaded", () => {
  const menuToggle = document.querySelector(".menu-toggle");
  const menuContainer = document.getElementById("primary-menu");

  menuToggle.addEventListener("click", () => {
    menuToggle.classList.toggle("open");
    menuContainer.classList.toggle("open");

    // Si l'élément "menuToggle" a la classe "open", ajoute la classe "cross"
    if (menuToggle.classList.contains("open")) {
      menuToggle.classList.add("cross");
      menuToggle.setAttribute("aria-expanded", "true");
    } else {
      // Sinon, supprime la classe "cross"
      menuToggle.classList.remove("cross");
      menuToggle.setAttribute("aria-expanded", "false");
    }
  });

  //INITIALISATION SELECT2 SUR LES SELECTEURS

  // Attends que le document soit prêt
  jQuery(document).ready(function ($) {
    // Vérifie la largeur de la fenêtre
    if ($(window).width() < 768) {
      // Si la largeur de l'écran est inférieure à 768px
      // Applique le plugin select2 aux éléments de filtre avec une largeur de 80%
      $("#category-filter, #format-filter, #order-filter").select2({
        width: "80%",
      });
    } else {
      // Sinon, applique le plugin select2 avec la largeur par défaut
      $("#category-filter, #format-filter, #order-filter").select2();
    }
    // Ajoute un écouteur d'événement sur l'événement "select2:selecting" pour tous les éléments select
    $("select").on("select2:selecting", function (e) {
      // Récupère le dropdown du select2 courant
      var $dropdown = $(this).parent().find(".select2-dropdown");
      // Change la couleur de fond du dropdown en rouge
      $dropdown.css("background-color", "#FE5858");
    });
  });
});
