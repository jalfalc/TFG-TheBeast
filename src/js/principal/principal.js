/**
 * Se inicia cuando el DOM está completamente cargado.
 * Aquí se configura y arranca el carrusel de imágenes.
 */
document.addEventListener('DOMContentLoaded', () => {
  // Selecciona el elemento que mostrará las imágenes de fondo
  const slideEl       = document.querySelector('.carousel-slides');
  // Contenedor donde se crearán los botones (puntos) de navegación
  const dotsContainer = document.querySelector('.carousel-dots');

  // 1) Lista de rutas de las imágenes que formarán el carrusel
  const images = [
    '../img/principal/carousel1.jpg',
    '../img/principal/carousel2.jpg',
    '../img/principal/carousel3.jpg',
    '../img/principal/carousel4.jpg'
  ];

  // 2) Precarga cada imagen creando un objeto Image
  //    de este modo se evitan parpadeos al cambiar de slide.
  images.forEach(src => {
    const img = new Image();
    img.src = src;
  });

  let current = 0;    // Índice de la imagen actualmente visible
  let intervalId;     // Referencia al temporizador de autoplay

  // 3) Generación dinámica de los puntos de navegación:
  //    por cada imagen se añade un botón que al hacer click
  //    llamará a goToSlide(indice).
  images.forEach((_, i) => {
    const btn = document.createElement('button');
    btn.addEventListener('click', () => goToSlide(i));
    dotsContainer.appendChild(btn);
  });
  // Convierte los botones a un array para gestionar la clase 'active'
  const dots = Array.from(dotsContainer.children);

  /**
   * updateUI:
   *  - Aplica un fade out a la capa de slides.
   *  - Tras 500ms, cambia la imagen de fondo y hace fade in.
   *  - Actualiza la clase 'active' en el punto correspondiente.
   */
  function updateUI() {
    slideEl.style.opacity = 0; // Inicia fade out
    setTimeout(() => {
      slideEl.style.backgroundImage = `url('${images[current]}')`;
      slideEl.style.opacity = 1;  // Inicia fade in
    }, 500);

    // Marca el punto activo, desmarca los demás
    dots.forEach((dot, idx) => {
      dot.classList.toggle('active', idx === current);
    });
  }

  /**
   * nextSlide:
   *  - Incrementa el índice (con wrap-around).
   *  - Llama a updateUI para reflejar el cambio.
   */
  function nextSlide() {
    current = (current + 1) % images.length;
    updateUI();
  }

  /**
   * goToSlide:
   *  - Establece current al índice deseado.
   *  - Actualiza la UI y reinicia el temporizador de autoplay.
   */
  function goToSlide(idx) {
    current = idx;
    updateUI();
    resetInterval();
  }

  /**
   * resetInterval:
   *  - Limpia el intervalo anterior.
   *  - Inicia uno nuevo para llamar a nextSlide cada 4 segundos.
   */
  function resetInterval() {
    clearInterval(intervalId);
    intervalId = setInterval(nextSlide, 4000);
  }

  // 4) Inicializa el carrusel:
  //    - Muestra la primera imagen.
  //    - Arranca el autoplay cada 4 segundos.
  updateUI();
  intervalId = setInterval(nextSlide, 4000);
});