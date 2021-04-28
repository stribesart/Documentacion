import { ajax_post } from "./ajax_post.js";

/**
 * Funcion que se encarga de llenar las listas del DOM con elementos de la Base de datos.
 * @param {DOMString} ALista - Parametro que identifica la lista a la que se van a insertar los datos
 * @param {object} options - Parametro que valida que irl y que parametros va a consumir el web service
 * @returns DOMString
 */
export async function llenaLista(ALista, options){
    const {url, params} = options;
    let iteraciones = 2;    
    if(params.atributos != undefined){
        iteraciones = 3;
    }

    const data = new FormData();

    for(let i = 0; i < Object.keys(params).length - iteraciones; i++){
        data.append(Object.keys(params)[i], params[Object.keys(params)[i]]);
    }
    ALista.innerHTML = null;
    await ajax_post({
        url : url,
        params: data,
        cbSuccess: (json) => {
            json.forEach(opt => {
                const $option = document.createElement('option');
                if(opt[params.campoValue] === undefined){
                    $option.innerHTML = opt.texto;
                }else{
                    $option.value = opt[params.campoValue];
                    $option.innerText = opt[params.campoDescripcion];
                    if(params.atributos != undefined){
                        const atributos = params.atributos.split(',');
                        for(let j = 0; j <(atributos.length); j++){
                            $option.setAttribute(`data-${atributos[j]}`, opt[atributos[j]]);
                        }
                    }
                }

                ALista.appendChild($option);
            });
        }
    });

    return ALista;
}