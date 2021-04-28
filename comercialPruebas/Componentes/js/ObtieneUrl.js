/**
 * Funcion que construye una URL para poder consumir un Web Service
 * @param {string} AModulo - Parametro que recibe la ruta del modulo que se va a cargar
 * @param {string} APagina - Parametro que recibe el nombre de la pagina que se va a cargar
 * @returns string
 */
export function ObtieneUrl(AModulo, APagina) {
    const
        servidor = "http://oficinas.prada.mx:72/",
        portal = "comercialPruebas/";
    const url = `${servidor}${portal}${AModulo}${APagina}`;
    return url;
}