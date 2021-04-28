import { ObtieneUrl } from "./ObtieneUrl.js";

/**
 * Funcion que obtiene la semana actual del calendario que esta corriendo dependienddo del dia en el que estemos.
 * @param {string} campo - Parametro que ni siquiera se utilza en esta funcion, no se por que lo crearon jaja xD
 * @returns Json
 */
export const ObtieneSemanaActual = async(campo = "") => {
    let options = {
            method: "get",
            url: ObtieneUrl("php/","ObtieneSemanaActual.php")
        },
        res = await axios(options),
        json = await res.data;

    return json;
}