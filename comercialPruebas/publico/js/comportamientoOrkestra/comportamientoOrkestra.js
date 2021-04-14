import { ajax_post } from "../../../funciones/ajax_post.js";
import { Filtros } from "../Filtros.js";
import { GeneraElementoDom } from "../GeneraElementoDom.js";
import { ObtieneElementoDom } from "../obtieneElementoDom.js";
import { ObtieneUrl } from "../ObtieneUrl.js";
import { Table } from "../../../Componentes/Tabla.js";
import { ObtieneVariableSession } from "../ObtieneVariableSession.js";
import { Modal } from "../masVendidos/Modal.js";

export default async function Orkestra(){
  const container = GeneraElementoDom("div");
  const ejemplo = GeneraElementoDom("div");

  ejemplo.innerHTML = "<h1>Ejemplo</h1>"
  container.id = "container";
  ObtieneElementoDom("contenido").appendChild(container);

  ObtieneElementoDom("titulos").innerHTML = "<h1>Comportamiento Orkestra</h1>";

  await Filtros(2, CargarDatos);

  CargarDatos();

  container.addEventListener("click",async (e) => {
    if (e.target.getAttribute("data-selected-orkestra2") != undefined || e.target.parentNode.getAttribute("data-selected-orkestra2") != undefined) {
        const sucursal = (e.target.getAttribute("data-selected-orkestra2") != undefined) ? e.target.getAttribute("data-selected-orkestra2") : e.target.parentNode.getAttribute("data-selected-orkestra2");
        let $modal = document.getElementById("orkestra-modal");
        if($modal === null){
            $modal = new bootstrap.Modal(Modal("orkestra-modal", "Vendedores",await GeneraContenidoModal(sucursal)));
        }else{
            let modalBody = ObtieneElementoDom("modal-body-orkestra-modal");
            modalBody.innerHTML = null;
            modalBody.appendChild(await GeneraContenidoModal(sucursal));
            $modal = bootstrap.Modal.getInstance($modal);
        }
        $modal.show();
    }
});


  return container;
}

async function CargarDatos(){
  const data = new FormData(ObtieneElementoDom("filtros-form"));
  const container = ObtieneElementoDom("container");
  const idConsulta = (ObtieneElementoDom("idSemana") != null)  ? ObtieneElementoDom("idSemana").value : ObtieneElementoDom("idMes").value;
  container.innerHTML = null;
  data.append("tipoUsuario", ObtieneVariableSession("tipoUsuario"));
  data.append("idPonderado", ObtieneVariableSession("idPonderado"));
  data.append("idConsulta",idConsulta);
  for(let i = 0; i < 3; i++){
    data.set("nivelConsulta",i);
    const tipoTabla = (i === 2)? 1 : 3;
    await ajax_post({
      url: ObtieneUrl("php/","orkestra/ObtieneOrkestra.php"),
          params: data,
          cbSuccess: (json) => {
            container.appendChild(Table(json,`orkestra${i}`, "table-lg", "", tipoTabla));
          }
    });
  }
}

async function GeneraContenidoModal(sucursal) {
  const $contenedor = GeneraElementoDom("div");
  const idConsulta = (ObtieneElementoDom("idSemana") != null) ? ObtieneElementoDom("idSemana").value : ObtieneElementoDom("idMes").value;
  const data = new FormData(ObtieneElementoDom("filtros-form"));
  data.append("tipoUsuario", ObtieneVariableSession("tipoUsuario"));
  data.append("idPonderado", ObtieneVariableSession("idPonderado"));
  data.append("idConsulta",idConsulta);
  data.append("nivelConsulta",3);
  data.set("idSucursales", sucursal);
  data.set("cbSucursales", "on");
  await ajax_post({
    url: ObtieneUrl("php/","orkestra/ObtieneOrkestra.php"),
    params: data,
    cbSuccess: (json) => {
      $contenedor.appendChild(Table(json.sucursal,`orkestra3`, "table-lg", "", 3));
      $contenedor.appendChild(Table(json.vendedor,`orkestra3`, "table-lg", "", 3));
      
    }
  });

  return $contenedor;
}

