import { ObtieneElementoDom } from "../ObtieneElementoDom.js";
import { CabeceraAceptar } from "./CabeceraAceptar.js";

export default async function AceptarUniformes(Ajson){

 ObtieneElementoDom("header-uniformes-modal").innerHTML = CabeceraAceptar();
}