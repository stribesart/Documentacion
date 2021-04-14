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