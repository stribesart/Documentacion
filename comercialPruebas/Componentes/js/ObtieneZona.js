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