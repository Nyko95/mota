// Exécute le script une fois que le contenu du document est complètement chargé
document.addEventListener("DOMContentLoaded", function () {
  // Sélectionne les éléments de la lightbox
  const lightbox = document.getElementById("lightbox");
  const closeButton = lightbox.querySelector(".cross");
  const prevButton = lightbox.querySelector(".prev");
  const nextButton = lightbox.querySelector(".next");
  const lightboxImage = lightbox.querySelector(".lightbox-image");
  const lightboxReference = lightbox.querySelector(".lightbox-info .reference");
  const lightboxCategory = lightbox.querySelector(".lightbox-info .category");

  // Initialise les variables pour stocker les images et l'index de l'image actuelle
  let images = [];
  let currentIndex = 0;

  // Fonction pour ouvrir la lightbox
  function openLightbox(event) {
    event.preventDefault();

    // Trouve le conteneur parent le plus proche avec les attributs de données nécessaires
    const fullscreenContainer = event.target.closest("span");
    if (!fullscreenContainer) {
      console.error("Aucun conteneur trouvé pour l'élément:", event.target);
      return;
    }

    // Récupère les attributs de données
    const imageUrl = fullscreenContainer.getAttribute("data-image-url");
    const reference = fullscreenContainer.getAttribute("data-reference");
    const category = fullscreenContainer.getAttribute("data-category");

    // Vérifie que tous les attributs de données sont présents
    if (!imageUrl || !reference || !category) {
      console.error("Les attributs de données sont manquants:", {
        imageUrl,
        reference,
        category,
      });
      return;
    }

    // Crée un tableau des images en parcourant tous les éléments .fullscreen
    images = Array.from(document.querySelectorAll(".fullscreen")).map(
      (icon) => {
        const container = icon.closest("span");
        return {
          imageUrl: container ? container.getAttribute("data-image-url") : null,
          reference: container
            ? container.getAttribute("data-reference")
            : null,
          category: container ? container.getAttribute("data-category") : null,
        };
      }
    );

    // Trouve l'index de l'image actuellement cliquée
    currentIndex = Array.from(document.querySelectorAll(".fullscreen")).indexOf(
      event.target
    );

    // Met à jour le contenu de la lightbox avec l'image cliquée
    updateLightboxContent(images[currentIndex]);

    // Affiche la lightbox
    lightbox.classList.add("active");
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

  // Fonction pour ajouter des écouteurs d'événements aux éléments .fullscreen
  function addEventListenersToFullscreenIcons() {
    document.querySelectorAll(".fullscreen").forEach((icon) => {
      // Ajoute l'écouteur d'événement au clic pour ouvrir la lightbox
      icon.addEventListener("click", openLightbox);
    });
  }

  // Initial setup: Ajoute des écouteurs d'événements aux icônes fullscreen existantes
  addEventListenersToFullscreenIcons();

  // Utilise MutationObserver pour surveiller les changements dans le DOM
  const observer = new MutationObserver(addEventListenersToFullscreenIcons);

  // Observe les changements dans le document pour ajouter des écouteurs aux nouveaux éléments .fullscreen
  observer.observe(document.body, { childList: true, subtree: true });

  // Ajoute des écouteurs d'événements aux boutons de contrôle de la lightbox
  closeButton.addEventListener("click", closeLightbox);
  prevButton.addEventListener("click", prevPhoto);
  nextButton.addEventListener("click", nextPhoto);

  // Ferme la lightbox si l'utilisateur clique à l'extérieur de l'image
  lightbox.addEventListener("click", (e) => {
    if (e.target === lightbox) {
      closeLightbox();
    }
  });
});
