import { Button } from './Button.js';
import { GeneraElementoDom } from "../publico/js/GeneraElementoDom.js"
import { ObtieneElementoDom } from '../publico/js/obtieneElementoDom.js';

/**
 * Esta funcion lo que hace es crear una tabla que se pude insertar en el DOM
 * @param {string} json - Parametro que define un objeto JSON
 * @param {string} id - Parametro que identifica el elemento en el DOM
 * @param {string} sizeClass - Parametro que valida el tamaño de la tabla
 * @param {string} ACampoId - Parametro que valida el id de algun elemento
 * @param {int} type - Parametro que identifica el tipo de tabla que se va a crear
 * @param {int} colspanEncabezados - Parametro que define la cantidad de columas por celda
 * @param {int} titulos - Parametro que define si tendra o no titulo la tabla
 * @returns DOMString
 */
export function TablaOpcionMenu(json, id, sizeClass, ACampoId, type = 0, colspanEncabezados = 0, titulos = 0) {
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
        return $card;
    }

    // Object.keys(contenido[0]).forEach(e => {
    //     console.log(e);
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

    if(titulos === 1){
        const $titulos = GeneraElementoDom("tr");
        $titulos.innerHTML = `
            <th></th>
            <th colspan="${colspanEncabezados}">Paseantes</th>
            <th colspan="${colspanEncabezados}">Visitantes</th>
            <th colspan="${colspanEncabezados}">Atraccion</th>
        `;
        $thead.appendChild($titulos);
    }

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
        } else if (i === Object.keys(contenido[0]).length - 1 && type <= 2) {

        } else {
            const $th = document.createElement('th');
            $th.innerText = Object.keys(contenido[0])[i].replace("{ ", "");
            $theadRow.appendChild($th);
        }
    }
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
                $td.appendChild(Button('<i class="fas fa-user"></i>', 'seleccionar', 'btn-primary', `selected-${id}`, registro[ACampoId]));
                $tr.appendChild($td);
            } else if (i === tamanioTabla && type === 2) {

            } else {
                const $td = document.createElement('td');
                $td.innerText = registro[Object.keys(registro)[i]];
                $tr.appendChild($td);
            }
        }
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