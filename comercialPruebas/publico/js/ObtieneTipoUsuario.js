export const ObtieneTipoUsuario = async() => {
    let options = {
            method: "get",
            url: "http://oficinas.prada.mx:72/Comercial/assets/php/obtieneTipoUsuario.php"
        },
        res = await axios(options),
        json = await res.data;

    return json;
}