/**
 * Esta funcion obtiene el valor del session storage para verificar que tipo de usuario es el que esta manipulando la aplicacion respetando la jerarquia de usuarios.
 * @returns Json
 */
export const ObtieneTipoUsuario = async() => {
    let options = {
            method: "get",
            url: "http://oficinas.prada.mx:72/Comercial/assets/php/obtieneTipoUsuario.php"
        },
        res = await axios(options),
        json = await res.data;

    return json;
}