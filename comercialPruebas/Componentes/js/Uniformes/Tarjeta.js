import { GeneraElementoDom } from "../GeneraElementoDom.js";
import { Input } from "../../../Componentes/Input.js";
import { CabeceraSolicitar } from "./CabeceraSolicitar.js";
import { ObtieneElementoDom } from "../ObtieneElementoDom.js";

export default function Tarjeta(json) {
    const contenido = GeneraElementoDom("div");
    const cardBody = GeneraElementoDom("div");
    const listaTallas = ObtieneListaTallas(json.tallas);
    const valor = ObtieneValorCheckbox(json.tallas);
    const existencias = ObtieneExistencias(json.tallas);
    const $inputs = GeneraElementoDom("div");
    const $divTallas = GeneraElementoDom("div");
    const stockPtag = GeneraElementoDom("p");
    const sotckSpan = GeneraElementoDom("span");

    $divTallas.id = "divSolicitar";
    stockPtag.className = `card-text`;
    stockPtag.innerText = "Stock: ";
    sotckSpan.innerText = existencias;
    stockPtag.appendChild(sotckSpan);
    contenido.classList.add("card-uniformes");
    contenido.id = json.cod10;

    cardBody.className="card-body";

    cardBody.innerHTML = `
      <h5 class="card-title">${json.cod10}</h5>
      <p class="card-text">Familia: ${json.Familia}</p>
      <p class="card-text">Seccion: ${json.Seccion}</p>
      <p class="card-text">Departamento: ${json.Departamento}</p>
      <p class="card-text">Temporada: ${json.Temporada}</p>
      <p class="card-text">Temporada: ${json.imagen}</p>
    `;
    contenido.innerHTML =  `
    <img src="http://oficinas.prada.mx:72/comercialPruebas/publico/img/uniformes/${json.cod10}.jpg" class="card-img-top mx-auto" width="150" height="140">`;

    $inputs.appendChild(Input("", "checkbox", `input-${json.cod10}`, "plu[]", valor));
    $divTallas.innerHTML = `
      <p>Seleccione Talla: <select id="sel${valor}">${listaTallas}</select></p>
      <p class="card-text">Cantidad a solicitar:<input id="can${json.cod10}" type='number' min='0' pattern='^[0-9]+' name='${valor}' value='0' style='width:40px'></p>
    `;

    $divTallas.style.display = "none";

    $inputs.appendChild($divTallas);
    cardBody.appendChild(stockPtag);
    cardBody.appendChild($inputs);
    contenido.appendChild(cardBody);

  $inputs.addEventListener("change", (e) => {
    const $select = ObtieneElementoDom(`sel${valor}`);
    const $cantidad = ObtieneElementoDom(`can${json.cod10}`);
    if(e.target.name === "plu[]"){
      if(e.target.checked == true){
        sotckSpan.innerText = $select.options[$select.selectedIndex].getAttribute("data-stock");
        e.target.value = $select.options[$select.selectedIndex].getAttribute("data-plu");
        $cantidad.value = "1";
        $cantidad.name = $select.options[$select.selectedIndex].getAttribute("data-plu");
      }else{
        sotckSpan.innerText = existencias;
        $cantidad.value = "0";
      }
    }else if(e.target.tagName == "SELECT"){
      const $checkbox = ObtieneElementoDom(`input-${json.cod10}`); 
      sotckSpan.innerText =$select.options[$select.selectedIndex].getAttribute("data-stock");
      $checkbox.value = $select.options[$select.selectedIndex].getAttribute("data-plu");
      $cantidad.name = $select.options[$select.selectedIndex].getAttribute("data-plu");
    }
  });


  return contenido;

  //     <div id="divSolicitar" id="div${json.cod10}" style="display: none;">
  //       <p>Seleccione Talla: <select id="sel${valor}">${listaTallas}</select></p>
  //       <p class="card-text">Cantidad a solicitar:<input id="can${json.cod10}" type='number' min='0' pattern='^[0-9]+' name='u${valor}' value='0' style='width:40px'></p>
  //     </div>
}

function ObtieneListaTallas(json){
  const ALista = GeneraElementoDom("select");
    json.forEach(opt => {
    const $option = document.createElement('option');
    if(opt["exi01"] === undefined){
      $option.innerHTML = "error";
    }else{
      $option.value = opt["exi01"];
      $option.innerText = opt["tal02"];
      $option.setAttribute(`data-plu`, opt["exi01"]);
      $option.setAttribute(`data-stock`, opt["exi10"]);
    }
    
    ALista.appendChild($option);
  });
  return ALista.innerHTML;
}
function ObtieneValorCheckbox(json){
  let valor;
  json.forEach(opt => {
    const $option = document.createElement('option');
    if(opt["exi01"] === undefined){
        $option.innerHTML = "error";
    }else{
        $option.value = opt["exi01"];
        $option.setAttribute(`data-plu`, opt["exi01"]);
    }
    valor = $option.value;
  });
  return valor;
}
function ObtieneExistencias(json){
  let valor =0;
  json.forEach(opt => {
    const $option = document.createElement('option');
    if(opt["exi01"] === undefined){
        $option.innerHTML = "error";
    }else{
        $option.value = opt["exi10"];
        $option.setAttribute(`data-${opt["exi10"]}`, opt["exi10"]);
    }
    valor = valor + parseInt($option.value, 10) ;
  });
  return valor;
}