let ahorros = [];
let indiceEdicion = null;

const formularioAhorro = document.getElementById("savingsForm");
const listaAhorros = document.getElementById("savingsList");
const nombreMeta = document.getElementById("goalName");
const montoMeta = document.getElementById("goalAmount");
const tiempoMeta = document.getElementById("goalTime");
const unidadTiempo = document.getElementById("timeUnit");

// Agregar o Editar
formularioAhorro.addEventListener("submit", function (evento) {
  evento.preventDefault();

  const nombre = nombreMeta.value.trim();
  const monto = parseFloat(montoMeta.value);
  const tiempo = parseInt(tiempoMeta.value);
  const unidad = unidadTiempo.value;

  if (!nombre || !monto || !tiempo) {
    alert("Por favor complete todos los campos.");
    return;
  }

  const nuevaMeta = { nombre, monto, tiempo, unidad };

  if (indiceEdicion !== null) {
    ahorros[indiceEdicion] = nuevaMeta;
    indiceEdicion = null;
  } else {
    ahorros.push(nuevaMeta);
  }

  actualizarLista();
  formularioAhorro.reset();
});

// Actualizar lista de metas
function actualizarLista() {
  listaAhorros.innerHTML = "";

  ahorros.forEach((meta, indice) => {
    const itemLista = document.createElement("li");
    itemLista.className = "list-group-item d-flex justify-content-between align-items-center";

    // los calculos
    let ahorroMensual = 0;
    if (meta.unidad === "años") {
      ahorroMensual = meta.monto / (meta.tiempo * 12);
    } else if (meta.unidad === "meses") {
      ahorroMensual = meta.monto / meta.tiempo;
    } else if (meta.unidad === "semanas") {
      ahorroMensual = meta.monto / (meta.tiempo * 4); 
    }

    itemLista.innerHTML = `
      <span>
        <strong>${meta.nombre}</strong> - ₡${meta.monto.toLocaleString()} en ${meta.tiempo} ${meta.unidad}
        <br>
        <small>Deberías ahorrar ₡${ahorroMensual.toFixed(2)} por mes.</small>
      </span>
      <div>
        <button class="btn btn-warning btn-sm" onclick="editarMeta(${indice})">Editar</button>
        <button class="btn btn-danger btn-sm" onclick="borrarMeta(${indice})">Borrar</button>
      </div>
    `;

    listaAhorros.appendChild(itemLista);
  });
}

// Editar Meta
function editarMeta(indice) {
  const meta = ahorros[indice];
  nombreMeta.value = meta.nombre;
  montoMeta.value = meta.monto;
  tiempoMeta.value = meta.tiempo;
  unidadTiempo.value = meta.unidad;

  indiceEdicion = indice;
}

// Borrar Meta
function borrarMeta(indice) {
  ahorros.splice(indice, 1);
  actualizarLista();
}

//se agrego algo de los calculos para metas como en 
// https://delepesoasuspesos.com/calculadora-de-metas-de-ahorro para que salga parecido a esa y que se guarden en la base 