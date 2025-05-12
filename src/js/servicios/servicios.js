// Datos de servicios
const servicios = [
    { id: 1, titulo: "Corte de pelo", descripcion: "Corte tradicional con tijeras/máquina y acabado perfecto para un look elegante y atemporal.", precio: "8,50€", imagen: "../img/servicios/servicio1.png" },
    { id: 2, titulo: "Arreglo de barba", descripcion: "Recorte, perfilado y tratamiento completo para una barba perfectamente definida.", precio: "7€", imagen: "../img/servicios/barba.png" },
    { id: 3, titulo: "Corte & Barba", descripcion: "Combinación de nuestro corte clásico con un servicio completo de barba.", precio: "40€", imagen: "../img/servicios/corte&barba.png" },
    { id: 4, titulo: "Corte de pelo para jubilados", descripcion: "Técnica de degradado preciso con máquina para un estilo moderno y definido.", precio: "6,50€", imagen: "../img/servicios/jubilado.png" },
    { id: 5, titulo: "Perfilado de cejas", descripcion: "Perfilamiento de cejas con cuchilla para dar un estilo más definido.", precio: "35€", imagen: "../img/servicios/cejas.jpg" },
    { id: 6, titulo: "Limpieza facial con efecto lifting", descripcion: "Tratamiento revitalizante para el cuero cabelludo y el cabello.", precio: "15€", imagen: "../img/servicios/limpiezafacial.avif" }
];

// Datos de testimonios
const testimonios = [
    { id: 1, nombre: "Carlos Martínez", comentario: "El mejor lugar para un corte de pelo en la ciudad. Profesionales y ambiente increíble.", imagen: "placeholder.jpg" },
    { id: 2, nombre: "Alejandro López", comentario: "Siempre salgo satisfecho. El fade que me hacen es perfecto y dura semanas.", imagen: "placeholder.jpg" },
    { id: 3, nombre: "Miguel Sánchez", comentario: "Excelente servicio y atención. El tratamiento de barba es espectacular.", imagen: "placeholder.jpg" }
];

// Genera las tarjetas de servicios y las inserta en el DOM
function generarServiciosCards() {
    const serviciosContainer = document.querySelector('.servicios-grid');
    servicios.forEach(servicio => {
        const card = document.createElement('div');
        card.className = 'servicio-card';
        card.innerHTML = `
            <div class="servicio-img-container">
                <img src="${servicio.imagen}" alt="${servicio.titulo}" class="servicio-img">
            </div>
            <h3 class="servicio-title">${servicio.titulo}</h3>
            <p class="servicio-desc">${servicio.descripcion}</p>
            <div class="servicio-footer">
                <span class="servicio-precio">${servicio.precio}</span>
                <a href="reservas.html" class="servicio-btn">Reservar</a>
            </div>
        `;
        serviciosContainer.appendChild(card);
    });
}

// Genera las tarjetas de testimonios y las inserta en el DOM
function generarTestimoniosCards() {
    const testimoniosContainer = document.querySelector('.testimonios-grid');
    testimonios.forEach(testimonio => {
        const card = document.createElement('div');
        card.className = 'testimonio-card';
        card.innerHTML = `
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
        testimoniosContainer.appendChild(card);
    });
}


// Inicialización al cargar el DOM
document.addEventListener('DOMContentLoaded', () => {
    generarServiciosCards();
    generarTestimoniosCards();
});
