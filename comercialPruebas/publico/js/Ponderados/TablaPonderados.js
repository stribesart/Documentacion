import { GeneraElementoDom } from "../GeneraElementoDom.js"
import { ObtieneElementoDom } from "../obtieneElementoDom.js";

export function TablaPonderados(AJson) {
    const $contenido = ObtieneElementoDom("contenido");
    $contenido.innerHTML = null;
    $contenido.appendChild(PintaTablaPonderados(AJson));
    $contenido.appendChild(PintaTablaPonderados(AJson, 1));
}

function PintaTablaPonderados(AJson, tipo = 0) {
    const { titulo, rango, metasZona, metasSucursal, ventasSucursal } = AJson;
    const { porcentajes, valores } = metasZona;
    const $tabla = GeneraElementoDom("table");
    const $thead = GeneraElementoDom("thead");
    const $tbody = GeneraElementoDom("tbody");
    let porcentajesMetas = "<td></td>";
    let valoresMetas = "<td></td>";
    let metasSucursales = "";
    let signoPesos = "";
    let bodyJson;
    if (ObtieneElementoDom("radio-Pesos").checked == true) {
        signoPesos = "";
    }

    $tabla.className = "table tablaponderados";
    $tabla.setAttribute("border", "1");
    $tabla.setAttribute("align", "1");

    for (let i = 0; i < Object.keys(porcentajes).length; i++) {
        porcentajesMetas += `<td colspan="2">${porcentajes[Object.keys(porcentajes)[i]]}</td>`;
        valoresMetas += `<td colspan="2">${signoPesos}${valores[Object.keys(valores)[i]]}</td>`;
    }

    if (tipo == 0) {
        bodyJson = metasSucursal;
    } else {
        bodyJson = ventasSucursal;
    }

    bodyJson.forEach(meta => {
        let claseColor = "";
        if ((meta.sucursal != null) && meta.sucursal.includes("Diferencia")) {
            claseColor = 'class = "trAzul"';
        } else if (meta.sucursal.includes("Web") || meta.sucursal.includes("Ventas")) {
            claseColor = 'class= "trAmarillo"';
        }
        metasSucursales += `
    <tr ${claseColor}>
      <td class="nombre">${meta.sucursal}</td>
      <td>${meta.aju05}</td>
      <td class="pesos">${meta.aju12}</td>
      <td>${meta.aju06}</td>
      <td class="pesos">${meta.aju13}</td>
      <td>${meta.aju07}</td>
      <td class="pesos">${meta.aju14}</td>
      <td>${meta.aju08}</td>
      <td class="pesos">${meta.aju15}</td>
      <td>${meta.aju09}</td>
      <td class="pesos">${meta.aju16}</td>
      <td>${meta.aju10}</td>
      <td class="pesos">${meta.aju17}</td>
      <td>${meta.aju11}</td>
      <td class="pesos">${meta.aju18}</td>
      <td>${meta.aju19}</td>
      <td class="pesos">${meta.aju20}</td>
      <td>${meta.porcentaje}</td>
      <td class="pesos">${meta.meta}</td>
    </tr>
   `;
    });

    $thead.innerHTML = `
  <tr>
    <th colspan="20" class="titulo-tabla">${titulo.titulo}</th>
  </tr>
  <tr>
    <th>Meta</th>
    <th colspan="3">Semana</th>
  </tr>
  <tr>
    <td>${signoPesos}${rango.Meta}</td>
    <td colspan="3">${rango.rango[0].periodo}</td>
  </tr>
  <tr>
    <th></th>
    <th colspan="2">Lunes</th>
    <th colspan="2">Martes</th>
    <th colspan="2">Miercoles</th>
    <th colspan="2">Jueves</th>
    <th colspan="2">Viernes</th>
    <th colspan="2">Sabado</th>
    <th colspan="2">Domingo</th>
    <th colspan="2">Total</th>
  </tr>
  <tr>
    ${porcentajesMetas}
  </tr>
  <tr>
    ${valoresMetas}
  </tr>
  <tr></tr>
  <tr>
    <th>Sucursal</th>
    <th colspan="2">Lunes</th>
    <th colspan="2">Martes</th>
    <th colspan="2">Miercoles</th>
    <th colspan="2">Jueves</th>
    <th colspan="2">Viernes</th>
    <th colspan="2">Sabado</th>
    <th colspan="2">Domingo</th>
    <th colspan="2">Totales</th>
    <th colspan="2">Totales Mensuales</th>
  </tr>
  <tr>
    <th>Nombre</th>
    <th>%</th>
    <th>META</th>
    <th>%</th>
    <th>META</th>
    <th>%</th>
    <th>META</th>
    <th>%</th>
    <th>META</th>
    <th>%</th>
    <th>META</th>
    <th>%</th>
    <th>META</th>
    <th>%</th>
    <th>META</th>
    <th>%</th>
    <th>META</th>
    <th>%</th>
    <th>META</th>    
  </tr>
 `;

    $tbody.innerHTML = `
  ${metasSucursales}
 `;

    $tabla.appendChild($thead);
    $tabla.appendChild($tbody);

    return $tabla;

}