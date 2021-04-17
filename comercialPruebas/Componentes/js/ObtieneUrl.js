export function ObtieneUrl(AModulo, APagina) {
    const
        servidor = "http://oficinas.prada.mx:72/",
        portal = "comercialPruebas/";
    const url = `${servidor}${portal}${AModulo}${APagina}`;
    return url;
}