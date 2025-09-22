document.getElementById("formContacte").addEventListener("submit", function(event) {
  const nom = document.getElementById("nom").value;
  const email = document.getElementById("email").value;
  const telefon = document.getElementById("telefon").value;

  if (nom.length < 3) {
    alert("El nom ha de tindre almenys 3 caràcters.");
    event.preventDefault();
  }

  if (!email.includes("@")) {
    alert("El correu ha de contindre un '@'.");
    event.preventDefault();
  }

  const regexTelefon = /^[0-9]{9}$/;
  if (!regexTelefon.test(telefon)) {
    alert("El telèfon ha de tindre exactament 9 dígits numèrics.");
    event.preventDefault();
  }
});
