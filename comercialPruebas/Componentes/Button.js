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