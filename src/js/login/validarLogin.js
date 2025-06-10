document.addEventListener('DOMContentLoaded', () => {
  const form      = document.getElementById('form-login');
  const inputMail = document.getElementById('username');
  const inputPass = document.getElementById('password');
  const errorDiv  = document.getElementById('login-error');

  form.addEventListener('submit', (e) => {
    // Limpiamos mensaje previo
    errorDiv.textContent = '';

    const mail = inputMail.value.trim();
    const pass = inputPass.value.trim();

    // Determinar qué falta
    if (!mail && !pass) {
      e.preventDefault();
      errorDiv.textContent = 'Error: debe completar ambos campos';
      errorDiv.style.color = 'red';
      inputMail.focus();
    } else if (!mail) {
      e.preventDefault();
      errorDiv.textContent = 'Error: debe introducir el correo';
      errorDiv.style.color = 'red';
      inputMail.focus();
    } else if (!pass) {
      e.preventDefault();
      errorDiv.textContent = 'Error: debe introducir la contraseña';
      errorDiv.style.color = 'red';
      inputPass.focus();
    }
    // Si ambos están completos, el formulario se envía normalmente
  });
});
