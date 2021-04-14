import { GeneraElementoDom } from "../GeneraElementoDom.js";

export function llenaTablaPromociones(json){
    const $container = GeneraElementoDom("div");
    $container.className = "resmenIndicadores-container";
    for(let i = 0; i < Object.keys(json).length; i++){
        const $table = GeneraElementoDom("table");
        const $thead = GeneraElementoDom("thead");
        const $tbody = GeneraElementoDom("tbody");
        const $titulosrow = GeneraElementoDom("tr");
        const $thTitulos = GeneraElementoDom("th");
        $thTitulos.innerText = `${Object.keys(json)[i]}`;
        $titulosrow.appendChild($thTitulos);
        $thead.appendChild($titulosrow);
        let aux = 0
        // console.log(json[Object.keys(json)[i]]);
        json[Object.keys(json)[i]].forEach(element => {
            const $tbodyRow = GeneraElementoDom("tr");
            const $headerRow = GeneraElementoDom("tr"); 
            for(let j = 0; j < Object.keys(element).length; ++j){
                if(!aux){
                    // console.log(aux);
                        const $th = GeneraElementoDom("th");
                        $thTitulos.colSpan = Object.keys(element).length;
                        $th.innerText = `${Object.keys(element)[j]}`;
                        $headerRow.appendChild($th);
                    }
                    const $td = GeneraElementoDom("td");
                    $td.innerText = `${element[Object.keys(element)[j]]}`;
                    $tbodyRow.appendChild($td);
            }
            
                // console.log(aux);
                $thead.appendChild($headerRow);
            
            $tbody.appendChild($tbodyRow);
            aux++;
        });
        // for(let j = 0; j< Object.keys(json[Object.keys(json)[i]]).length; j++){
            // }
            
        $table.appendChild($thead);
        $table.appendChild($tbody);
        $container.appendChild($table);
    }

    return $container;
}