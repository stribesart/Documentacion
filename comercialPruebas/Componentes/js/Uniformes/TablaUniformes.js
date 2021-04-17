import { Button } from '../../../Componentes/Button.js';
import { GeneraElementoDom } from "../GeneraElementoDom.js";

/**
 * Esta funcion lo que realiza es una tabla en el DOM
 * @param {object} AParameteros Objeto con un json, id, sizeclass, campoid y el tipo
 */
export function TablaUniformes(AParameteros) {
    const { json, id, sizeClass, ACampoId, type } = AParameteros;

    const $card = document.createElement('div');
    const $cardBody = document.createElement('div');
    const $tableHolder = document.createElement('div');
    const $table = document.createElement('table');
    const $thead = document.createElement('thead');
    const $theadRow = document.createElement('tr');
    const $tbody = document.createElement('tbody');
    const contenido = json;

    let tamanioTabla = 0;

    if (contenido.length === 0) {
        $cardBody.innerHTML = "<h3 class = 'no-data-message'>No hay datos</h3>";
    }

    // Object.keys(contenido[0]).forEach(e => {
    //     const $th = document.createElement('th');
    //     $th.innerText = e;
    //     $theadRow.appendChild($th);
    // });
    $table.id = id;
    $card.className = `card${id} card-table border-light shadow-sm mb-4`;
    $cardBody.className = `card-body`;
    $tableHolder.classList.add('table-responsive');
    $table.className = `table tablaponderados`;
    $table.classList.add(sizeClass);
    $thead.classList.add('thead-light');
    if (type <= 2) {
        tamanioTabla = Object.keys(contenido[0]).length - 1;
    } else {
        tamanioTabla = Object.keys(contenido[0]).length;
    }
    for (let i = 0; i <= tamanioTabla; i++) {
        if (i === Object.keys(contenido[0]).length - 1 && type <= 1) {
            const $th = document.createElement('th');
            $th.innerText = 'Opciones';
            $theadRow.appendChild($th);
        } else {
            const $th = document.createElement('th');
            $th.innerText = Object.keys(contenido[0])[i];
            $theadRow.appendChild($th);
        }
    }
    const $th = document.createElement('th');
    $th.innerText = "Seleccionar";
    $theadRow.appendChild($th);
    $thead.appendChild($theadRow);
    const $tbodyFragment = document.createDocumentFragment();

    contenido.forEach(registro => {
        const $tr = document.createElement('tr');
        for (let i = 0; i <= tamanioTabla; i++) {
            if (i === tamanioTabla && type === 0) {
                const $td = document.createElement('td');
                $td.appendChild(Button('Editar', '', 'btn-info', `data-edit-${id}`, registro[ACampoId]));
                $td.appendChild(Button('Eliminar', '', 'btn-danger', `data-eliminar-${id}`, registro[ACampoId]));
                $tr.appendChild($td);
            } else if (i === tamanioTabla && type === 1) {
                const $td = document.createElement('td');
                $td.appendChild(Button('<i class="fas fa-user"></i>', 'seleccionar', 'btn-primary', `data-selected-${id}`, registro[ACampoId]));
                $tr.appendChild($td);
            } else {
                const $td = document.createElement('td');
                $td.innerText = registro[Object.keys(registro)[i]];
                $tr.appendChild($td);
            }
        }
        const $td = document.createElement('td');
        $td.innerHTML =
            `<input type="checkbox" name="solicitudes[]" value="${registro.sol01}"/>`;
        $tr.appendChild($td);
        $tbodyFragment.appendChild($tr);
    });

    $tbody.appendChild($tbodyFragment);
    $table.appendChild($thead);
    $table.appendChild($tbody);
    $tableHolder.appendChild($table);
    $cardBody.appendChild($tableHolder);
    $card.appendChild($cardBody);



    return $card;


}