// =========================================================
// servicios.js adaptado al nuevo HTML con comentarios
// =========================================================

// ---------------------------------------------------------
// 1. DEFINICIÓN DE DATOS
// ---------------------------------------------------------

/*
  Array de objetos 'servicios':
  Cada objeto representa un servicio con las siguientes propiedades:
    - id: identificador único
    - titulo: nombre del servicio
    - descripcion: texto breve que aparece en la tarjeta
    - precio: coste del servicio en formato string
    - imagen: ruta relativa a la imagen del servicio
    - detalles: texto completo que se mostrará en el modal
    - incluye: lista de elementos incluidos en el servicio
*/
const servicios = [
  {
    id: 1,
    titulo: "Corte de pelo",
    descripcion: "Corte tradicional con tijeras/máquina y acabado perfecto.",
    precio: "8,50€",
    imagen: "../img/servicios/servicio1.png",
    detalles: "Nuestro corte de pelo clásico incluye lavado, corte con tijeras, degradado personalizado y fijación con cera.",
    incluye: "Lavado + Corte con tijeras + Degradado + Peinado"
  },
  {
    id: 2,
    titulo: "Arreglo de barba",
    descripcion: "Perfilado y tratamiento completo para tu barba.",
    precio: "7€",
    imagen: "../img/servicios/barba.png",
    detalles: "Recortamos, perfilamos con precisión a navaja y aplicamos aceite nutritivo para suavizar y proteger la piel.",
    incluye: "Recorte + Perfilado a navaja + Aceite nutritivo"
  },
  {
    id: 3,
    titulo: "Corte & Barba",
    descripcion: "Combo especial de corte de pelo y arreglo de barba.",
    precio: "13€",
    imagen: "../img/servicios/corte&barba.png",
    detalles: "Disfruta de un servicio completo: lavado, corte, degradado y perfilado de barba con masaje facial relajante.",
    incluye: "Lavado + Corte + Perfilado de barba + Masaje facial"
  },
  {
    id: 4,
    titulo: "Corte de pelo para jubilados",
    descripcion: "Degradado preciso y cómodo para mayores.",
    precio: "6,50€",
    imagen: "../img/servicios/jubilado.png",
    detalles: "Diseñado para pieles sensibles: corte con máquina suave, acabado limpio y asesoramiento de estilo.",
    incluye: "Corte con máquina + Acabado + Asesoramiento"
  },
  {
    id: 5,
    titulo: "Perfilado de cejas",
    descripcion: "Cuchilla y pinza para una mirada definida.",
    precio: "6€",
    imagen: "../img/servicios/cejas.jpg",
    detalles: "Perfilamos con cuchilla de precisión y nitidez, retiramos vello sobrante con pinza y aplicamos bálsamo calmante.",
    incluye: "Cuchilla + Pinza + Bálsamo calmante"
  },
  {
    id: 6,
    titulo: "Limpieza facial con efecto lifting",
    descripcion: "Revitaliza tu piel y relaja tu mente.",
    precio: "15€",
    imagen: "../img/servicios/limpiezafacial.avif",
    detalles: "Incluye exfoliación, masaje con rodillo de jade y mascarilla reafirmante que deja la piel radiante.",
    incluye: "Exfoliación + Masaje de jade + Mascarilla reafirmante"
  }
];

/*
  Array de objetos 'testimonios':
  Cada objeto representa la opinión de un cliente con:
    - id: identificador único
    - nombre: nombre del cliente
    - comentario: texto del testimonio
    - imagen: ruta relativa a la foto del cliente
*/
const testimonios = [
  { id: 1, nombre: "Carlos Martínez", comentario: "El mejor lugar para un corte de pelo en la ciudad. Profesionales y ambiente increíble.", imagen: "../img/servicios/opinion1.jpg" },
  { id: 2, nombre: "Alejandro López", comentario: "Siempre salgo satisfecho. El fade que me hacen es perfecto y dura semanas.", imagen: "../img/servicios/opinion2.webp" },
  { id: 3, nombre: "Miguel Sánchez", comentario: "Excelente servicio y atención. El tratamiento de barba es espectacular.", imagen: "../img/servicios/opinion3.jpg" },
  { id: 4, nombre: "Luis Gutiérrez", comentario: "Me encanta su atención al detalle. ¡Mi cabello nunca había lucido tan bien!", imagen: "../img/servicios/opinion4.jpg" },
  { id: 5, nombre: "Raúl Torres", comentario: "El ambiente es inmejorable y los resultados siempre superan mis expectativas.", imagen: "../img/servicios/opinion5.png" },
  { id: 6, nombre: "Juan Fernández", comentario: "Profesionales y amables. El trato fue excelente y el corte espectacular.", imagen: "../img/servicios/opinion6.jpg" }
];

// ---------------------------------------------------------
// 2. EJECUCIÓN AL CARGAR EL DOCUMENTO
// ---------------------------------------------------------

/*
  Se espera a que el DOM esté completamente cargado
  para empezar a crear e insertar los elementos dinámicos.
*/
document.addEventListener('DOMContentLoaded', () => {
  // -------------------------------------------------------
  // Generación dinámica de tarjetas de servicios
  // -------------------------------------------------------
  // 2.1. Selección del contenedor donde irán las tarjetas
  const contenedorServicios = document.querySelector('.grid-servicios');

  // 2.2. Iteración sobre cada servicio del array
  servicios.forEach(servicio => {
    // 2.2.1. Creación de un elemento DIV para la tarjeta
    const tarjeta = document.createElement('div');
    tarjeta.className = 'servicio-card';

    // 2.2.2. Definición del HTML interno de la tarjeta
    tarjeta.innerHTML = `
      <div class="servicio-img-container">
        <img src="${servicio.imagen}" alt="${servicio.titulo}" class="servicio-img">
      </div>
      <h3 class="servicio-title">${servicio.titulo}</h3>
      <p class="servicio-desc">${servicio.descripcion}</p>
      <div class="servicio-footer">
        <span class="servicio-precio">${servicio.precio}</span>
        <!-- Botón que abrirá el modal con más información -->
        <button class="servicio-info-btn" data-id="${servicio.id}">
          Más información
        </button>
      </div>
    `;

    // 2.2.3. Inserción de la tarjeta en el DOM
    contenedorServicios.appendChild(tarjeta);
  });

  // -------------------------------------------------------
  // Generación dinámica de tarjetas de testimonios
  // -------------------------------------------------------
  // 3.1. Selección del contenedor de testimonios
  const contenedorTestimonios = document.querySelector('.grid-testimonios');

  // 3.2. Iteración sobre cada testimonio del array
  testimonios.forEach(testimonio => {
    // 3.2.1. Creación de la tarjeta de testimonio
    const tarjeta = document.createElement('div');
    tarjeta.className = 'testimonio-card';

    // 3.2.2. Construcción del contenido HTML de la tarjeta
    tarjeta.innerHTML = `
      <div class="testimonio-header">
        <div class="testimonio-img-container">
          <img src="${testimonio.imagen}" alt="${testimonio.nombre}" class="testimonio-img">
        </div>
        <div class="testimonio-info">
          <h3>${testimonio.nombre}</h3>
          <div class="testimonio-stars">★★★★★</div>
        </div>
      </div>
      <p class="testimonio-text">"${testimonio.comentario}"</p>
    `;

    // 3.2.3. Inserción de la tarjeta en el contenedor
    contenedorTestimonios.appendChild(tarjeta);
  });

  // -------------------------------------------------------
  // Configuración del modal de información de servicio
  // -------------------------------------------------------
  /*
    Se obtienen referencias a los elementos del modal:
      - modalInfoServicio: contenedor principal que se muestra/oculta
      - tituloModal: elemento <h2> para el título
      - descripcionModal: párrafo para la descripción completa
      - duracionModal: elemento span donde se muestra la duración
      - incluyeModal: elemento span con la lista de lo que incluye
      - botonCerrarModal: botón para cerrar el modal
  */
  const modalInfoServicio = document.getElementById('modal-informacion-servicio');
  const tituloModal       = document.getElementById('titulo-modal');
  const descripcionModal  = document.getElementById('descripcion-modal');
  const duracionModal     = document.getElementById('duracion-modal');
  const incluyeModal      = document.getElementById('incluye-modal');
  const botonCerrarModal  = document.getElementById('boton-cerrar-modal');

  // -------------------------------------------------------
  // Apertura del modal al pulsar "Más información"
  // -------------------------------------------------------
  /*
    Se añaden listeners a todos los botones con clase
    'servicio-info-btn'. Al hacer click:
      1. Se encuentra el objeto de servicio correspondiente al data-id
      2. Se actualizan los contenidos del modal con los datos del servicio
      3. Se muestra el modal añadiendo la clase 'open'
  */
  document.querySelectorAll('.servicio-info-btn').forEach(boton => {
    boton.addEventListener('click', () => {
      const servicioSeleccionado = servicios.find(s => s.id == boton.dataset.id);
      // Rellenar título, detalles, duración e incluye
      tituloModal.textContent      = servicioSeleccionado.titulo;
      descripcionModal.textContent = servicioSeleccionado.detalles;
      duracionModal.textContent    = '30 minutos';  // Valor fijo o podría venir del objeto
      incluyeModal.textContent     = servicioSeleccionado.incluye;
      // Mostrar el modal
      modalInfoServicio.classList.add('open');
    });
  });

  // -------------------------------------------------------
  // Cierre del modal
  // -------------------------------------------------------
  /*
    1. Botón de cierre: al pulsar se quita la clase 'open'
    2. Click fuera del contenido: si el target es el overlay, también cierra
  */
  botonCerrarModal.addEventListener('click', () => {
    modalInfoServicio.classList.remove('open');
  });
  modalInfoServicio.addEventListener('click', event => {
    if (event.target === modalInfoServicio) {
      modalInfoServicio.classList.remove('open');
    }
  });
});
