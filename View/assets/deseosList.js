
// funcion de agregar
document.getElementById('wishForm').addEventListener('submit', function(event) {
  event.preventDefault();

  const wishName = document.getElementById('wishName').value;
  const wishCost = document.getElementById('wishCost').value;
  const wishPriority = document.getElementById('prioritySelect').value;
  const wishDate = document.getElementById('wishDate').value;
  const wishImage = document.getElementById('wishImage').files[0];

  // parte de las fotos
  const wishCard = document.createElement('div');
  wishCard.classList.add('col', wishPriority);

  const wishCardContent = `
    <div class="card shadow-sm">
      <img src="${URL.createObjectURL(wishImage)}" class="card-img-top" alt="Imagen del deseo">
      <div class="card-body">
        <h5 class="card-title">${wishName}</h5>
        <p class="card-text">Costo estimado: ₡${wishCost}</p>
        <p class="card-text">Prioridad: ${wishPriority}</p>
        <p class="card-text">Fecha de Adición: ${wishDate}</p>
        <div class="d-flex justify-content-between">
          <button class="btn btn-warning btn-custom" onclick="editWish(this)">Editar</button>
          <button class="btn btn-danger btn-custom" onclick="deleteWish(this)">Borrar</button>
        </div>
      </div>
    </div>
  `;
  
  wishCard.innerHTML = wishCardContent;
  document.getElementById('wishGallery').appendChild(wishCard);

  document.getElementById('wishForm').reset();
});

// Funcion de editar 
function editWish(button) {
  const cardBody = button.closest('.card-body');
  const wishName = cardBody.querySelector('.card-title').textContent;
  const wishCost = cardBody.querySelector('.card-text').textContent.split(': ')[1];
  const wishPriority = cardBody.querySelector('.card-text').textContent.split(': ')[1];
  const wishDate = cardBody.querySelector('.card-text').textContent.split(': ')[1];

  document.getElementById('wishName').value = wishName;
  document.getElementById('wishCost').value = wishCost;
  document.getElementById('prioritySelect').value = wishPriority;
  document.getElementById('wishDate').value = wishDate;

  deleteWish(button);
}
function deleteWish(button) {
  const card = button.closest('.col');
  card.remove();
}

// Los filtros
document.getElementById('allButton').addEventListener('click', function() {
  const allCards = document.querySelectorAll('#wishGallery .col');
  allCards.forEach(card => card.style.display = 'block');
});

document.getElementById('urgentButton').addEventListener('click', function() {
  filterByPriority('urgente');
});

document.getElementById('necessaryButton').addEventListener('click', function() {
  filterByPriority('necesario');
});

document.getElementById('optionalButton').addEventListener('click', function() {
  filterByPriority('opcional');
});

function filterByPriority(priority) {
  const allCards = document.querySelectorAll('#wishGallery .col');
  allCards.forEach(card => {
    if (card.classList.contains(priority)) {
      card.style.display = 'block';
    } else {
      card.style.display = 'none';
    }
  });
}
