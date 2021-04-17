import { ObtieneUrl } from "./ObtieneUrl.js";

export const ObtieneSemanaActual = async(campo = "") => {
    let options = {
            method: "get",
            url: ObtieneUrl("php/","ObtieneSemanaActual.php")
        },
        res = await axios(options),
        json = await res.data;

    return json;
}