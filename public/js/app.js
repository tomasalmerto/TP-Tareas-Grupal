import { router } from "./router.js";

// =========================================================================
// APLICACION DE MODO OSCURO 
// =========================================================================

const cargarTemaGuardado = () => {
  const temaGuardado = localStorage.getItem('theme') || 'light';
  document.documentElement.setAttribute('data-bs-theme', temaGuardado);
};

// Se ejecuta inmediatamente para evitar el "parpadeo" blanco al cargar
cargarTemaGuardado();

document.addEventListener('click', (e) => {
  if (e.target.closest('#btn-cambiar-tema')) {
    const html = document.documentElement;
    const nuevoTema = html.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
    
    html.setAttribute('data-bs-theme', nuevoTema);
    localStorage.setItem('theme', nuevoTema);
    
    // Notificación visual con Toastr
    if (typeof toastr !== 'undefined') {
      toastr.success(`Modo ${nuevoTema === 'dark' ? 'oscuro' : 'claro'} activado`);
    }
  }
});

document.addEventListener("DOMContentLoaded", () => {
  router.init();
});

//Inicializa el proyecto