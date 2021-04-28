/**
 * Esta es una funcion que crea un elemento en el DOM de tipo Input
 * @param {string} ANombreLabel - Parametro que define el texto que ira en el input
 * @param {string} AType - Parametro que define el tipo de input que se va a realizar
 * @param {string} AId - Parametro que define el identificador del elemento a insertar en el dom
 * @param {string} AName - Parametro que define el nombre del elemento del dom
 * @param {string} AValue - Parametro que define si se debe de insertar un valor al elemento, es opcional
 * @param {int} ADisabled - Parametro que define si el elemento va a ir habilitado o deshabilitado
 * @param {int} AChecked - Parametro que define si se le va a insertar un checkbox
 * @returns DOMString
 * @example
 * Input(nombreLabel1, "radio", `radio-${nombreLabel1}`, "tipoVenta", "0", 1);
 */
export function Input(ANombreLabel,AType,  AId, AName, AValue = '', ADisabled = 1, AChecked = 1){
    const $container = document.createElement('div')
    const $label = document.createElement('label');
    const $input = document.createElement('input');

    //$container.className = 'form-group';
    $label.innerText = ANombreLabel;

    $input.type = AType;
    $input.id = AId;
    $input.className = 'form-contol';
    $input.name = AName;
    if(ADisabled === 0){
        $input.disabled = 'disabled';
    }
    if(AChecked === 0){
        $input.checked = 'checked';
    }
    if(AValue != ''){
        $input.value = AValue;
    }
    
    $container.appendChild($input);
    $container.appendChild($label);

    return $container;
}