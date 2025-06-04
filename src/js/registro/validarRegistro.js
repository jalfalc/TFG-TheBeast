// public/js/validateRegister.js
document.addEventListener('DOMContentLoaded', () => {
  // 1. Referencias al formulario y a los campos de contraseña
  const formulario   = document.getElementById('form-register');  // Formulario de registro
  const campoPwd     = document.getElementById('password');       // Primer campo de contraseña
  const campoPwdRep  = document.getElementById('password2');      // Campo de repetir contraseña

  // 2. Configuración de cada campo: id, validador y mensaje de error
  const camposConfig = [
    {
      id: 'nombre',
      validacion: v => v.length <= 20,
      mensaje: 'Debe tener como máximo 20 caracteres'
    },
    {
      id: 'apellidos',
      validacion: v => v.length <= 30,
      mensaje: 'Debe tener como máximo 30 caracteres'
    },
    {
      id: 'telefono',
      validacion: v => /^[0-9]{9}$/.test(v),
      mensaje: 'Solo números, 9 dígitos'
    },
    {
      id: 'mail',
      validacion: v => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v),
      mensaje: 'Email inválido'
    },
    {
      id: 'password',
      validacion: v => v.length >= 8,           // ejemplo: mínimo 6 caracteres
      mensaje: 'Debe tener al menos 8 caracteres'
    },
    {
      id: 'password2',
      validacion: () => true,                  // validación especial más abajo
      mensaje: ''                              // no usado
    }
  ];

  // 3. Al pulsar "Registrar", validamos todos los campos
  formulario.addEventListener('submit', event => {
    let formularioValido = true; // bandera general

    camposConfig.forEach(config => {
      // 3.1. Referencia al input y al span de error
      const input      = document.getElementById(config.id);
      const errorSpan  = document.getElementById(`error-${config.id}`);
      const valor      = input.value.trim(); // texto sin espacios delante/detrás
      let valido       = true;
      let textoError   = '';

      // 3.2. Si el campo está vacío → error obligatorio
      if (valor === '') {
        valido     = false;
        textoError = 'Campo obligatorio';

      } else if (config.id === 'password2') {
        // 3.3. Para repetir contraseña: primero coincidir con el primero
        if (valor !== campoPwd.value) {
          valido     = false;
          textoError = 'Las contraseñas no coinciden';
        }
      } else {
        // 3.4. Validación estándar: longitud / formato
        if (!config.validacion(valor)) {
          valido     = false;
          textoError = config.mensaje;
        }
      }

      // 3.5. Mostrar u ocultar mensaje de error
      if (!valido) {
        errorSpan.textContent = textoError;
        formularioValido = false;
      } else {
        errorSpan.textContent = '';
      }
    });

    // 4. Si hubo algún fallo, bloqueamos el envío del formulario
    if (!formularioValido) {
      event.preventDefault();
    }
  });
});
