// CONFIGURACIÓN
const cocheId = "ferrari_f8_tributo";
let selectedRating = 5;
const btnFav = document.getElementById('btn-favorito');

document.addEventListener('DOMContentLoaded', () => {
    verificarFavorito();
    cargarComentarios();
});

// --- LÓGICA DE FAVORITOS ---
function verificarFavorito() {
    let favoritos = JSON.parse(localStorage.getItem('favs_dn_motors')) || [];
    if (favoritos.includes(cocheId)) {
        actualizarInterfazFavorito(true);
    }
}

if (btnFav) {
    btnFav.addEventListener('click', () => {
        let favoritos = JSON.parse(localStorage.getItem('favs_dn_motors')) || [];
        
        if (favoritos.includes(cocheId)) {
            favoritos = favoritos.filter(id => id !== cocheId);
            actualizarInterfazFavorito(false);
        } else {
            favoritos.push(cocheId);
            actualizarInterfazFavorito(true);
        }
        localStorage.setItem('favs_dn_motors', JSON.stringify(favoritos));
    });
}

function actualizarInterfazFavorito(isFav) {
    const textoFav = btnFav.querySelector('.texto-fav');
    const corazon = btnFav.querySelector('.corazon');

    if (isFav) {
        btnFav.style.borderColor = "#ff4444";
        btnFav.style.backgroundColor = "rgba(255, 68, 68, 0.1)";
        corazon.style.color = "#ff4444";
        textoFav.innerText = "En tus favoritos";
        textoFav.style.color = "#ff4444";
    } else {
        btnFav.style.borderColor = "#333";
        btnFav.style.backgroundColor = "transparent";
        corazon.style.color = "#444";
        textoFav.innerText = "Añadir a favoritos";
        textoFav.style.color = "#fff";
    }
}

// --- LÓGICA DE COMENTARIOS ---
document.querySelectorAll('.star').forEach(star => {
    star.addEventListener('click', (e) => {
        document.querySelectorAll('.star').forEach(s => s.classList.remove('active'));
        e.target.classList.add('active');
        selectedRating = e.target.getAttribute('data-value');
    });
});

function cargarComentarios() {
    fetch('gestion_comentarios.php?accion=cargar')
    .then(res => res.json())
    .then(data => {
        const container = document.getElementById('commentsContainer');
        container.innerHTML = '';
        data.forEach(c => container.innerHTML += crearHTMLComentario(c));
    });
}

function crearHTMLComentario(c) {
    const stars = "★".repeat(c.estrellas) + "☆".repeat(5 - c.estrellas);
    return `
        <div class="comment-card" id="comment-${c.id}">
            <div class="comment-header">
                <span class="user-name">${c.usuario}</span>
                <span class="stars-display">${stars}</span>
            </div>
            <p style="color: #ccc;">${c.texto}</p>
            <div class="comment-footer">
                <button class="btn-delete" onclick="borrarComentario(${c.id})">Eliminar</button>
            </div>
        </div>`;
}

document.getElementById('commentForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData();
    formData.append('texto', document.getElementById('commentText').value);
    formData.append('estrellas', selectedRating);
    formData.append('accion', 'crear');

    fetch('gestion_comentarios.php', { method: 'POST', body: formData })
    .then(res => res.json()).then(data => {
        if (data.success) {
            cargarComentarios();
            document.getElementById('commentForm').reset();
        }
    });
});

function borrarComentario(id) {
    if (!confirm("¿Borrar?")) return;
    const formData = new FormData();
    formData.append('id', id);
    formData.append('accion', 'borrar');
    fetch('gestion_comentarios.php', { method: 'POST', body: formData }).then(() => cargarComentarios());
}