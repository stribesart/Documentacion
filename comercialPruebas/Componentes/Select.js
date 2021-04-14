import { llenaLista } from "../funciones/llenaLista.js";

export async function Select(AOpciones, ACheck = 0) { //Funcion que crea Selects en el Promociones.php
    let { nombreTabla, url, valor } = AOpciones;
    let params = AOpciones.params;
    const $formGroup = document.createElement('div');
    const $label = document.createElement('label');
    const $labelContainer = document.createElement('div');
    let $select = document.createElement('select');

    if(Object.keys(params).length === 0){
    //if (typeof params.campoValue == undefined) {
        params = {
            campoValue: `${nombreTabla.toLowerCase().substring(0,3)}01`,
            campoDescripcion: `${nombreTabla.toLowerCase().substring(0,3)}02`
        }
    }
    if (ACheck != 0) {
        const $checkbox = document.createElement('input');
        $checkbox.type = 'checkbox';
        $checkbox.id = `cb${nombreTabla}`;
        $checkbox.name = `cb${nombreTabla}`;
        $labelContainer.appendChild($checkbox);
        $select.style.display = 'none';

        $checkbox.addEventListener('change', e => {
            if ($select.style.display === 'none') {
                $select.style.display = 'block';
            } else {
                $select.style.display = 'none';
            }
        });
    }


    $formGroup.className = 'form-group';
    $label.innerText = nombreTabla;
    $label.id = `lbl${nombreTabla}`;
    if (nombreTabla === "Año") {
        $select.id = `idAnio`;
        $select.name = `idAnio`;
    } else {
        $select.id = `id${nombreTabla}`;
        $select.name = `id${nombreTabla}`;
    }

    // console.log($select.name)

    $select = await llenaLista($select, { url: url, params: params });

    if (valor != undefined) {
        $select.value = valor;
    }

    $labelContainer.appendChild($label);

    $formGroup.appendChild($labelContainer);
    $formGroup.appendChild($select);

    return $formGroup;

}