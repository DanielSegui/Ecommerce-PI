document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('commentForm');
    const caja = document.getElementById('commentsContainer');

    // 1. Función para cargar
    const cargar = () => {
        fetch('gestion_comentarios.php')
            .then(r => r.json())
            .then(data => {
                caja.innerHTML = data.map(c => `
                    <div style="background:#222; padding:10px; margin-bottom:5px; border-left:3px solid gold;">
                        <p>${c.texto} <small>(${c.vehiculo})</small></p>
                    </div>
                `).join('');
            });
    };

    cargar();

    // 2. Función para enviar
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const valor = document.getElementById('commentText').value;
        
        const fd = new FormData();
        fd.append('texto', valor);
        fd.append('vehiculo', window.location.pathname.split('/').pop());

        fetch('gestion_comentarios.php', { method: 'POST', body: fd })
            .then(r => {
                if(!r.ok) throw new Error("Error en el servidor");
                return r.json();
            })
            .then(() => {
                document.getElementById('commentText').value = '';
                cargar();
            })
            .catch(err => alert("ERROR: El servidor no deja escribir el archivo JSON. Revisa los permisos de la carpeta."));
    });
});