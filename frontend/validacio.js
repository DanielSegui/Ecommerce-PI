document.getElementById("formContacte").addEventListener("submit", function(event) {
  const nom = document.getElementById("nom").value.trim();
  const email = document.getElementById("email").value.trim();
  const telefon = document.getElementById("telefon").value.trim();
  const edat = document.getElementById("edat").value.trim();
  const consentiment = document.getElementById("consentiment").checked;

  // Validació del nom
  if (nom.length < 3) {
    alert("El nom ha de tindre almenys 3 caràcters.");
    event.preventDefault();
    return;
  }

  // Validació del correu amb regex simple
  const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!regexEmail.test(email)) {
    alert("El correu no és vàlid.");
    event.preventDefault();
    return;
  }

  // Validació del telèfon
  const regexTelefon = /^[0-9]{9}$/;
  if (!regexTelefon.test(telefon)) {
    alert("El telèfon ha de tindre exactament 9 dígits numèrics.");
    event.preventDefault();
    return;
  }

  // Validació de l'edat si s'ha introduït
  if (edat) {
    const edatNum = parseInt(edat);
    if (edatNum < 18 || edatNum > 99) {
      alert("L'edat ha d'estar entre 18 i 99 anys.");
      event.preventDefault();
      return;
    }
  }

  // Validació del checkbox de consentiment
  if (!consentiment) {
    alert("Has d'acceptar el tractament de les teves dades.");
    event.preventDefault();
    return;
  }
});
