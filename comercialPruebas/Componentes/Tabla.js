import {Button} from './Button.js';

/**
 * Esta funcion lo que realiza es una tabla dentro del DOM
 * @param {string} json - Conjunto de elementos json
 * @param {string} id - Parametro que valida que identificador es
 * @param {string} sizeClass - Parametro que define que tamaño sera la tabla 
 * @param {string} ACampoId - Parametro que valida el campo id de cualquier otro elemento
 * @param {int} type - Parametro que define el tipo de tabla que se va a insertar en el DOM
 * @param {int} colspanEncabezados - Parametro que define la cantidad de columnas que usara una celda
 * @returns DOMString
 */
export function Table(json, id, sizeClass, ACampoId ,  type = 0, colspanEncabezados = 0){
 const $card = document.createElement('div');
 const $cardBody = document.createElement('div');
 const $tableHolder = document.createElement('div');
 const $table = document.createElement('table');
 const $thead = document.createElement('thead');
 const $theadRow = document.createElement('tr');
 const $tbody = document.createElement('tbody');
 const headers = (json.headers.split(',').filter(Boolean));
 const contenido = json.content;

 let tamanioTabla = 0;
 if(contenido[0].length != 8){
 if(json.titulos != undefined){
  const $titulos = json.titulos.split(',');
  const $titulosHeader = document.createElement('tr');

  let t = 0;

  $titulos.forEach( titulo => {
   const $th = document.createElement('th');
   if(t === 0){
    $th.colSpan = "1";
   }else{
    $th.colSpan = colspanEncabezados;
   }
   $th.innerText = titulo;
   $titulosHeader.appendChild($th);
   t++;
  });
  
  $thead.appendChild($titulosHeader);
 }

 $card.className = `card${id} card-table border-light shadow-sm mb-4`;
 $cardBody.className = `card-body`;
 $tableHolder.classList.add('table-responsive');
 $table.className = `table tablaponderados`;
 $table.classList.add(sizeClass);
 $thead.classList.add('thead-light');
 if(contenido.length === 0){
  $card.innerHTML = "<h3 class = 'no-data-message'>No hay datos</h3>";
  return $card;
 }
  if(type === 0 || type === 1){
   tamanioTabla = headers.length;
  }else{
   tamanioTabla = headers.length - 1;
  }
  for(let i = 0; i <= tamanioTabla; i++){
      const $th = document.createElement('th');
      if(i === headers.length && type <= 1){
          $th.innerText = 'Opciones';
      }else{
          $th.innerText = headers[i].trim();
      }
      $theadRow.appendChild($th);
  }
  $thead.appendChild($theadRow);
  const $tbodyFragment = document.createDocumentFragment();
  
  contenido.forEach(registro => {
   const $tr = document.createElement('tr');
   for(let i = 0; i <= tamanioTabla; i++){
    const $td = document.createElement('td');
    if(i === tamanioTabla && type === 0){
     $td.appendChild(Button('Editar','', 'btn-info', `data-edit-${id}`, registro[ACampoId]));
     $td.appendChild(Button('Eliminar','', 'btn-danger', `data-eliminar-${id}`, registro[ACampoId]));
    }else if(i === tamanioTabla && type === 1){
     $td.appendChild(Button('<i class="fas fa-user"></i>','seleccionar', 'btn-primary', `selected-${id}`, registro[registro.length-1]));
    }else{
     $td.innerText = registro[Object.keys(registro)[i]];
    }
    $tr.appendChild($td);
   }
   $tbodyFragment.appendChild($tr);
  });
  
  $tbody.appendChild($tbodyFragment);
  $table.appendChild($thead);
  $table.appendChild($tbody);
  $tableHolder.appendChild($table);
  $cardBody.appendChild($tableHolder);
  $card.appendChild($cardBody);
  
 }
  return $card;
}