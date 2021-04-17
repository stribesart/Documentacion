import { ObtieneTipoUsuario } from '../ObtieneTipoUsuario.js';
import { ObtieneZona } from '../ObtieneZona.js';

export const llenaTablaIndicadores = async(semana) => {
    const d = document,
        $tbody = document.getElementById('resumen-desempenio-metas'),
        $paseantesTbody = d.getElementById('paseantes-tbody'),
        $aniosList = d.getElementById('lista-años'),
        $semanasList = d.getElementById('lista-semanas'),
        $checkZonas = d.getElementById('checkbox-zona'),
        $checkSucursal = d.getElementById('checkbox-sucursal'),
        $zonasList = d.getElementById('lista-zonas'),
        $sucursalList = d.getElementById('lista-sucursal'),
        $paseantesFragment = document.createDocumentFragment(),
        $zonasFragment = document.createDocumentFragment(),
        $filtroZonas = d.getElementById('filtro-zonas'),
        anioActual = $aniosList.value,
        anioAnterior = anioActual - 1,
        actual = d.getElementsByClassName("anoActual"),
        anterior = d.getElementsByClassName("anoAnterior");
    CambiaAnios(actual, anioActual);
    CambiaAnios(anterior, anioAnterior);
    const tipoUsuario = await ObtieneTipoUsuario();
    if (tipoUsuario === '3' || tipoUsuario === '2') {
        $filtroZonas.style.display = 'none';
    }
    while ($tbody.firstChild) {
        $tbody.removeChild($tbody.firstChild);
    }

    while ($paseantesTbody.firstChild) {
        $paseantesTbody.removeChild($paseantesTbody.firstChild);
    }


    let options = {
            method: "get",
            url: "http://oficinas.prada.mx:72/comercial/resumenIndicadores/ObtieneTablaIndicadores.php",
            params: {
                aniosList: $aniosList.value,
                semanasList: semana,
                checkZonas: $checkZonas.checked,
                checkSucursal: $checkSucursal.checked,
                zonasList: $zonasList.value,
                sucursalList: $sucursalList.value,
                tipoConsulta: 0
            }
        },
        res = await axios(options),
        json = await res.data;
    console.log(options);
    json.forEach(obj => {
        const row = document.createElement("tr"),
            rowPaseantes = document.createElement('tr');
        for (var i = 0; i < Object.keys(obj).length - 1; i++) {
            const celda = document.createElement("td");
            let textoCelda = document.createTextNode(obj[Object.keys(obj)[i]]);
            if (i > 14) {
                if (i === 15) {
                    textoCelda = document.createTextNode(obj[Object.keys(obj)[0]])
                    celda.style.textAlign = 'left';
                }
                celda.appendChild(textoCelda);
                rowPaseantes.appendChild(celda);
                $paseantesFragment.appendChild(rowPaseantes);
            } else {
                celda.appendChild(textoCelda);
                if (i === 0) { celda.style.textAlign = 'left'; }
                row.appendChild(celda);
                $zonasFragment.appendChild(row);
            }
        }
    });
    while ($tbody.firstChild) {
        $tbody.removeChild($tbody.firstChild);
    }

    while ($paseantesTbody.firstChild) {
        $paseantesTbody.removeChild($paseantesTbody.firstChild);
    }
    $tbody.appendChild($zonasFragment);
    $paseantesTbody.appendChild($paseantesFragment);
}

export const llenaTablaDesempenioSucursal = async(semana) => {
    const d = document,
        $tbody = document.getElementById('desempenio-sucursales'),
        $paseantesTbody = d.getElementById('paseantes-tbody-sucursal'),
        $aniosList = d.getElementById('lista-años'),
        $semanasList = d.getElementById('lista-semanas'),
        $checkZonas = d.getElementById('checkbox-zona'),
        $checkSucursal = d.getElementById('checkbox-sucursal'),
        $zonasList = d.getElementById('lista-zonas'),
        $sucursalList = d.getElementById('lista-sucursal'),
        $paseantesFragment = document.createDocumentFragment(),
        $zonasFragment = document.createDocumentFragment(),
        tituloEmpleadosModal = document.getElementById('empleados_modal-tittle');
    while ($tbody.firstChild) {
        $tbody.removeChild($tbody.firstChild);
    }

    while ($paseantesTbody.firstChild) {
        $paseantesTbody.removeChild($paseantesTbody.firstChild);
    }

    let options = {
            method: "get",
            url: "http://oficinas.prada.mx:72/comercial/resumenIndicadores/ObtieneTablaIndicadores.php",

            params: {
                aniosList: $aniosList.value,
                semanasList: semana,
                checkZonas: $checkZonas.checked,
                checkSucursal: $checkSucursal.checked,
                zonasList: $zonasList.value,
                sucursalList: $sucursalList.value,
                tipoConsulta: 1
            }
        },
        res = await axios(options),
        json = await res.data;
    json.forEach(obj => {
        const row = document.createElement("tr"),
            rowPaseantes = document.createElement('tr');
        for (var i = 0; i < Object.keys(obj).length - 1; i++) {
            const celda = document.createElement("td"),
                celdaButton = document.createElement('td'),
                empleadosButton = document.createElement('button');
            let textoCelda = document.createTextNode(obj[Object.keys(obj)[i]]);
            if (i > 14) {
                if (i === 15) {
                    textoCelda = document.createTextNode(obj[Object.keys(obj)[0]]);
                    celda.style.textAlign = 'left';
                }
                celda.appendChild(textoCelda);
                rowPaseantes.appendChild(celda);
                $paseantesFragment.appendChild(rowPaseantes);
            } else {
                celda.appendChild(textoCelda);
                if (i === 0) { celda.style.textAlign = 'left'; }
                row.appendChild(celda);
                if (i == 14) {
                    empleadosButton.innerHTML = '<i class="fas fa-user"></i>';
                    empleadosButton.className = 'btn btn-primary';
                    celdaButton.appendChild(empleadosButton);
                    row.appendChild(celdaButton);
                    empleadosButton.addEventListener('click', () => {
                        $("#empleadosModal").modal('show');
                        tituloEmpleadosModal.innerHTML = 'Empleados: ' + obj.nombreZona;
                        llenaTablaDesempenioEmpleados(semana, obj.idZona);
                    });
                }
                $zonasFragment.appendChild(row);
            }
        }
    });
    while ($tbody.firstChild) {
        $tbody.removeChild($tbody.firstChild);
    }
    $tbody.appendChild($zonasFragment);

    while ($paseantesTbody.firstChild) {
        $paseantesTbody.removeChild($paseantesTbody.firstChild);
    }
    $paseantesTbody.appendChild($paseantesFragment);


}

const llenaTablaDesempenioEmpleados = async(semana, sucursal) => {
    const d = document,
        $tbody = document.getElementById('resumen-desempenio-empleados'),
        $aniosList = d.getElementById('lista-años'),
        $semanasList = d.getElementById('lista-semanas'),
        $checkZonas = d.getElementById('checkbox-zona'),
        $checkSucursal = d.getElementById('checkbox-sucursal'),
        $zonasList = d.getElementById('lista-zonas'),
        $sucursalList = d.getElementById('lista-sucursal'),
        $paseantesFragment = document.createDocumentFragment(),
        $zonasFragment = document.createDocumentFragment();
    while ($tbody.firstChild) {
        $tbody.removeChild($tbody.firstChild);
    }
    let options = {
            method: "get",
            url: "http://oficinas.prada.mx:72/comercial/resumenIndicadores/ObtieneTablaIndicadores.php",
            params: {
                aniosList: $aniosList.value,
                semanasList: semana,
                checkZonas: $checkZonas.checked,
                checkSucursal: $checkSucursal.checked,
                zonasList: $zonasList.value,
                sucursalList: $sucursalList.value,
                idSucursal: sucursal,
                tipoConsulta: 2
            }
        },
        res = await axios(options),
        json = await res.data;
    json.forEach(obj => {
        const row = document.createElement("tr"),
            rowPaseantes = document.createElement('tr');
        for (var i = 0; i < Object.keys(obj).length - 1; i++) {
            const celda = document.createElement("td");
            let textoCelda = document.createTextNode(obj[Object.keys(obj)[i]]);
            if (i > 14) {

            } else {
                celda.appendChild(textoCelda);
                if (i === 0) { celda.style.textAlign = 'left'; }
                row.appendChild(celda);
                $zonasFragment.appendChild(row);
            }
        }
    });

    $tbody.appendChild($zonasFragment);
}

function CambiaAnios(arreglo, valor) {
    for (var i = 0; i < arreglo.length; i++) {
        arreglo[i].innerHTML = valor;
    }
}