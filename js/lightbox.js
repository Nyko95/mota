// Attend que le DOM soit chargé avant d'exécuter le code
document.addEventListener(
  "DOMContentLoaded",
  function () // Sélectionne les éléments nécessaires pour la lightbox
  {
    console.log("test");
    const fullscreenIcons = document.querySelectorAll(".fullscreen");
    const lightbox = document.getElementById("lightbox");
    const closeButton = lightbox.querySelector(".cross");
    const prevButton = lightbox.querySelector(".prev");
    const nextButton = lightbox.querySelector(".next");
    const lightboxImage = lightbox.querySelector(".lightbox-image");
    const lightboxReference = lightbox.querySelector(
      ".lightbox-info .reference"
    );
    const lightboxCategory = lightbox.querySelector(".lightbox-info .category");

    //Variables pour Gérer les Images
    // Initialise un tableau vide pour stocker les informations sur les images
    let images = [];
    // Initialise l'index de l'image actuellement affichée à 0
    let currentIndex = 0;

    // Fonction pour ouvrir la lightbox
    function openLightbox(event) {
      event.preventDefault();

      // Mise à jour du tableau d'images et de l'index courant
      images = Array.from(document.querySelectorAll(".fullscreen")).map(
        (img) => img.parentElement.dataset
      );
      currentIndex = Array.from(fullscreenIcons).indexOf(event.target);

      updateLightboxContent(images[currentIndex]);
      lightbox.classList.add("active"); //Ajout de la classe "active"
    }

    // Fonction pour mettre à jour le contenu de la lightbox
    function updateLightboxContent(data) {
      lightboxImage.src = data.imageUrl;
      lightboxReference.textContent = "Référence : " + data.reference;
      lightboxCategory.textContent = "Catégorie : " + data.category;
    }

    // Fonction pour fermer la lightbox
    function closeLightbox() {
      lightbox.classList.remove("active");
    }

    // Fonction pour afficher la photo suivante
    function nextPhoto() {
      currentIndex = (currentIndex + 1) % images.length;
      updateLightboxContent(images[currentIndex]);
    }

    // Fonction pour afficher la photo précédente
    function prevPhoto() {
      currentIndex = (currentIndex - 1 + images.length) % images.length;
      updateLightboxContent(images[currentIndex]);
    }

    // Ajouter des écouteurs d'événements
    fullscreenIcons.forEach((icon) => {
      icon.addEventListener("click", openLightbox);
    });
    closeButton.addEventListener("click", closeLightbox);
    prevButton.addEventListener("click", prevPhoto);
    nextButton.addEventListener("click", nextPhoto);

    // Fermer la lightbox en cliquant à l'extérieur de l'image
    lightbox.addEventListener("click", (e) => {
      if (e.target === lightbox) {
        closeLightbox();
      }
    });
  }
);
