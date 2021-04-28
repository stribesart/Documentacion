import { llenaAnios, llenaLista, ocultaFiltro } from './funciones.js';
import { ObtieneSemanaActual } from './ObtieneSemanaActual.js';

const d = document,
    aniosList = d.getElementById('lista-años'),
    semanasList = d.getElementById('lista-semanas'),
    periodosSemanalesEndPoint = 'http://oficinas.prada.mx:72/comercial/assets/php/obtienePeriodosSemanales.php',
    zonasVentasEndPoint = 'http://oficinas.prada.mx:72/comercial/assets/php/obtieneZonasVentas.php',
    sucursalesVentasEndPoint = 'http://oficinas.prada.mx:72/comercial/assets/php/obtieneSucursalVentas.php',
    checkZonas = d.getElementById('checkbox-zona'),
    checkSucursal = d.getElementById('checkbox-sucursal'),
    zonasList = d.getElementById('lista-zonas'),
    sucursalList = d.getElementById('lista-sucursal'),
    filtroSucursal = d.getElementById('filtro-sucursal');

llenaAnios(2020, aniosList);
// zonasList.style.display = 'none';
checkSucursal.disabled = true;
filtroSucursal.style.display = 'none';

/**
 * Funcion que valida los eventos que se realizan dentro de las listas que se van cambiando en los filtros.
 */
(async() => {
    const SemanasParams = {
        anio: aniosList.value
    }

    let semanaActual = await ObtieneSemanaActual();

    await llenaLista(SemanasParams, periodosSemanalesEndPoint, semanasList, semanaActual);

    const ZonasParams = {
        anio: aniosList.value,
        semana: semanasList.value
    }
    await llenaLista(ZonasParams, zonasVentasEndPoint, zonasList);

    // const SucursalesParams = {
    //     anio: aniosList.value,
    //     semana: semanasList.value
    // }
    // await llenaLista(SucursalesParams, sucursalesVentasEndPoint, sucursalList);

    ocultaFiltro(checkZonas, zonasList);
    ocultaFiltro(checkSucursal, sucursalList);

    d.addEventListener('change', async e => {
        if (e.target === aniosList) {
            const SemanasParams = {
                anio: aniosList.value
            }

            llenaLista(SemanasParams, periodosSemanalesEndPoint, semanasList);
            const ZonasParams = {
                anio: aniosList.value,
                semana: semanaList.value
            }
            await llenaLista(ZonasParams, zonasVentasEndPoint, zonasList);
            if (checkZonas.checked === true) {
                const SucursalesParams = {
                    anio: aniosList.value,
                    semana: semanaList.value,
                    zona: zonaList.value
                }
                await llenaLista(SucursalesParams, sucursalesVentasEndPoint, sucursalList);
            }

            if (checkZonas.checked != true) {
                const SucursalesParams = {
                    anio: aniosList.value,
                    semana: semanaList.value
                }
                await llenaLista(SucursalesParams, sucursalesVentasEndPoint, sucursalList);
            }
        }
        if (e.target === semanasList) {
            checkSucursal.disabled = true;
            filtroSucursal.style.display = 'none';
            await ocultaFiltro(checkZonas, zonasList);
            if (checkZonas.checked != true) {
                const SucursalesParams = {
                    anio: aniosList.value,
                    semana: semanasList.value
                }
                await llenaLista(SucursalesParams, sucursalesVentasEndPoint, sucursalList);
            }
            const ZonasParams = {
                anio: aniosList.value,
                semana: semanasList.value
            }
            await llenaLista(ZonasParams, zonasVentasEndPoint, zonasList, );
            if (checkZonas.checked === true) {
                const SucursalesParams = {
                    anio: aniosList.value,
                    semana: semanasList.value,
                    zona: zonaList.value
                }
                await llenaLista(SucursalesParams, sucursalesVentasEndPoint, sucursalList);
            }

        }

        if (e.target === checkZonas) {
            ocultaFiltro(checkZonas, zonasList);
            if (checkZonas.checked != true) {
                checkSucursal.disabled = true;
                filtroSucursal.style.display = 'none'
                const SucursalesParams = {
                    anio: aniosList.value,
                    semana: semanasList.value
                }
                await llenaLista(SucursalesParams, sucursalesVentasEndPoint, sucursalList);
            } else {
                checkSucursal.disabled = false;
                filtroSucursal.style.display = 'block'
                const SucursalesParams = {
                    anio: aniosList.value,
                    semana: semanasList.value,
                    zona: zonasList.value
                }
                await llenaLista(SucursalesParams, sucursalesVentasEndPoint, sucursalList);
            }

        }

        if (e.target === checkSucursal) {
            ocultaFiltro(checkSucursal, sucursalList);
        }

        if (e.target === zonasList) {
            const SucursalesParams = {
                anio: aniosList.value,
                semana: semanasList.value,
                zona: zonasList.value
            }
            await llenaLista(SucursalesParams, sucursalesVentasEndPoint, sucursalList);
        }
    });

})();