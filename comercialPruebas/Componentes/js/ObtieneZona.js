/**
 * Esta funcion se encarga de verificar que valor de la zona se identiica segun la semana que esta corriendo actualmente.
 * @param {int} semana - Parametro qe recibe el numero de semana que esta corriendo en el dia actual
 * @returns Json
 */
export const ObtieneZona = async(semana) => {
    const $aniosList = document.getElementById('lista-años'),
        $semanasList = document.getElementById('lista-semanas');
    let options = {
            method: "get",
            url: "http://oficinas.prada.mx:72/comercial/assets/php/obtieneZonasVentas.php",
            params: {
                anio: $aniosList.value,
                semana: semana
            }
        },
        res = await axios(options),
        json = await res.data;

    return json[0].value;
}