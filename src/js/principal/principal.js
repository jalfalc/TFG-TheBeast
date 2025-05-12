document.addEventListener('DOMContentLoaded', () => {
    const slideEl       = document.querySelector('.carousel-slides');
    const prevBtn       = document.querySelector('.carousel-btn.prev');
    const nextBtn       = document.querySelector('.carousel-btn.next');
    const dotsContainer = document.querySelector('.carousel-dots');

    // 1. Rutas de tus 4 imágenes
    const images = [
      '../img/principal/carousel1.jpg',
      '../img/principal/carousel2.jpg',
      '../img/principal/carousel3.jpg',
      '../img/principal/carousel4.jpg'
    ];
    // 2. Precarga para que no parpadeen
    images.forEach(src => { new Image().src = src; });

    let current = 0;
    let intervalId;

    // 3. Generar puntos de navegación
    images.forEach((_, i) => {
      const btn = document.createElement('button');
      btn.addEventListener('click', () => goToSlide(i));
      dotsContainer.appendChild(btn);
    });
    const dots = Array.from(dotsContainer.children);

    function updateUI() {
      // Fade OUT solo la capa de slides
      slideEl.style.opacity = 0;
      setTimeout(() => {
        // Cambiar imagen y Fade IN
        slideEl.style.backgroundImage = `url('${images[current]}')`;
        slideEl.style.opacity = 1;
      }, 500);
      // Activar punto correspondiente
      dots.forEach((d,i) => d.classList.toggle('active', i === current));
    }

    function nextSlide() {
      current = (current + 1) % images.length;
      updateUI();
    }
    function prevSlide() {
      current = (current - 1 + images.length) % images.length;
      updateUI();
    }
    function goToSlide(idx) {
      current = idx;
      updateUI();
      resetInterval();
    }
    function resetInterval() {
      clearInterval(intervalId);
      intervalId = setInterval(nextSlide, 4000);
    }

    // Listeners de botones
    nextBtn.addEventListener('click', () => { nextSlide(); resetInterval(); });
    prevBtn.addEventListener('click', () => { prevSlide(); resetInterval(); });

    // Inicializar carousel
    updateUI();
    intervalId = setInterval(nextSlide, 4000);
  });