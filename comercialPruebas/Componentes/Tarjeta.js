import { GeneraElementoDom } from "../publico/js/GeneraElementoDom.js";

export function Tarjeta(json) {
    const contenido = GeneraElementoDom("div");
    contenido.classList.add("card");
    contenido.id = json.cod01;
    contenido.innerHTML = `
    <img src="${json.imagen}" class="card-img-top" width="150" height="140">
    <div class="card-body">
      <h5 class="card-title">${json.cod10}</h5>
      <p class="card-text">Color: ${json.col02}</p>
      <p class="card-text">Departamento: ${json.dep02}</p>
      <p class="card-text">Familia: ${json.fam02}</p>
      <p class="card-text">Unidades: ${json.unidades}</p>
      <p class="card-text">Precio: ${json.dti08}</p>
      <p class="card-text">Ventas: ${json.venta}</p>
      <div class="d-grid gap-2">
        <button type="button" class="btn btn-outline-secondary btn-sm" id="tallas" data-selected=${json.cod01}>Tallas</button>
        <button type="button" class="btn btn-outline-secondary btn-sm" id="tiendas" data-selected=${json.cod01}>Tiendas</button>
        <button type="button" class="btn btn-outline-secondary btn-sm" id="tickets" data-selected=${json.cod01}>Tickets</button>
      </div>
    </div>`

    return contenido;
}