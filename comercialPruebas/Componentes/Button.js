/**
 * Este componente crea un Boton en el DOM.
 * @param {string} text - Texto que aparece en el Boton
 * @param {(string|number)} id - Identificador de nuestro boton
 * @param {string} type - Tipo de Boton que crearemos con los estilos de Bootstrap 5
 * @param {string} dataAttribute - Parametro que se inserta si queremos agregar un atributo a nuestro elemento.
 * @param {string} dataValue - Valor de nuestro nuevo atributo si es que se le agrega.
 * @returns {DOMString}
 * @example
 * Button("Solicitar","Solicitar","btn-secondary","modulo-uniformes","SolicitarUniformes");
 */
export function Button(text, id, type,dataAttribute, dataValue){
    const $buttonContainer = document.createElement('div');
    const $button = document.createElement('button');

    $buttonContainer.classList.add('form-group');
    $button.classList.add('btn');

    if (typeof type != 'undefined'){
        $button.classList.add(type);
    }else{
        $button.classList.add('btn-primary');
    }
    
    if(typeof dataAttribute != 'undefined' && typeof dataValue != 'undefined'){
        $button.setAttribute(`data-${dataAttribute}`, dataValue);
    }

    if(typeof id != 'undefined'){
        $button.id = id;
    }
    $button.setAttribute("data-bs-toggle", "button");
    $button.innerHTML = text;

    $buttonContainer.appendChild($button);
    return $buttonContainer;
}