import { Input } from "../../../Componentes/Input.js";
import { GeneraElementoDom } from "../GeneraElementoDom.js";

export async function CabeceraFormato(){
 const divRangoFecha = GeneraElementoDom("div"),
       tex = GeneraElementoDom("label");
 tex.append("Periodo a Consultar");
 divRangoFecha.appendChild(tex);
 divRangoFecha.appendChild(Input(" al dia ", "date", "periodo-inicial", "fechaInicial", ""));
 divRangoFecha.appendChild(Input("", "date", "periodo-final", "fechaFinal"));
 return divRangoFecha.innerHTML;
}