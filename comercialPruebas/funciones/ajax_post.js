/**
 * Esta funcion consume una api AjaxPost.
 * @param {object} props Objeto que contiene la direccion de donde se consumira una api, los parametros que consume esa api y una funcion Success que se ejecuta si se consume correctamente la api.
 */
export async function ajax_post(props){
    const { url, params, cbSuccess} = props;

    const options = {
        method: "POST",
        mode: "no-cors",
        headers: {
            "Content-type":"application/json; charset=utf-8"
        },
        data: params
    };
    await axios(url, options)
    .then(response => {
     cbSuccess(response.data);
    })
    .catch(e => {
     console.log(e);
    });
}