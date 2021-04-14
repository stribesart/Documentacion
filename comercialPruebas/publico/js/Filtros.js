import { Input } from "../../Componentes/Input.js";
import { Select } from "../../Componentes/Select.js";
import { llenaLista } from "../../funciones/llenaLista.js";
import { GeneraElementoDom } from "./GeneraElementoDom.js";
import { ObtieneElementoDom } from "./obtieneElementoDom.js";
import { ObtieneSemanaActual } from "./ObtieneSemanaActual.js";
import { ObtieneUrl } from "./ObtieneUrl.js";
import { ObtieneVariableSession } from "./ObtieneVariableSession.js";

export async function Filtros(AModulo,CbChange){
 

  const filtrosFragment = document.createElement("form");
  filtrosFragment.id = "filtros-form";
  let nombreLabel1;
  let nombreLabel2;
  const panelPesos = GeneraElementoDom("div");
  const pesosHeading = GeneraElementoDom("div");
  const pesosBody = GeneraElementoDom("div");

  panelPesos.className = "card";

  pesosHeading.className = "card-header";
  pesosHeading.innerText = "Tipo Venta";

  pesosBody.className = "panel-body";
  pesosBody.id = "tipoVenta-body";

  panelPesos.appendChild(pesosHeading);

  
  panelPesos.appendChild(pesosBody);
  
  filtrosFragment.appendChild(panelPesos);
  
  if(AModulo == 0){
    nombreLabel1 = "Pesos";
    nombreLabel2 = "Unidades";
  }else{
    nombreLabel1 = "Semanas";
    nombreLabel2 = "Meses";
  }
  
  ObtieneElementoDom("filtros").removeEventListener("change",RemueveListener, true);
  
  
    pesosBody.appendChild(Input(nombreLabel1, "radio", `radio-${nombreLabel1}`, "tipoVenta", "0", 1));
    pesosBody.appendChild(Input(nombreLabel2, "radio", `radio-${nombreLabel2}`, "tipoVenta", "1", 1));
  
  if(AModulo == 0){
    
    const panelResumen = GeneraElementoDom("div");
    const resumenHeading = GeneraElementoDom("div");
    const resumenBody = GeneraElementoDom("div");
    
    panelResumen.className = "card";
    
    resumenHeading.className = "card-header";
    resumenHeading.innerText = "Tipo Ponderado";
    
    resumenBody.className = "panel-body";
    
    panelResumen.appendChild(resumenHeading);
    
    resumenBody.appendChild(Input("General", "radio", `radio-general`, "tipoPonderado", "0", 1));
    resumenBody.appendChild(Input("Resumen", "radio", `radio-resumen`, "tipoPonderado", "1", 1));
    
    
    panelResumen.appendChild(resumenBody);
    
    filtrosFragment.appendChild(panelResumen);

  }
  
  const $aniosContainer = await Select({ //se crea el select del año con la funcion de Select
    nombreTabla: 'Año', 
    params: {
      //anio: "2020",
      campoValue: "id",
      campoDescripcion: "descripcion"
    },
    url : ObtieneUrl("php/", "ObtieneAnios.php")//funcion que usamos para el json de los años
  }, 0)

  filtrosFragment.appendChild($aniosContainer);
    const $semanasContainer = document.createElement("div");    
    $semanasContainer.appendChild(await Select({ //se crea el select del año con la funcion de Select
      nombreTabla: 'Semana', 
      params: {
        anio: "2021",
        campoValue: "id",
        campoDescripcion: "periodo"
      },
      url : ObtieneUrl("php/", "ObtienePeriodosSemanales.php"),
      valor: await ObtieneSemanaActual()
    },  0));
    
    filtrosFragment.appendChild($semanasContainer);
    
    filtrosFragment.appendChild(
      await Select({ //se crea el select del año con la funcion de Select
        nombreTabla: 'Zonas', 
        params: {
          tipoUsuario: ObtieneVariableSession("tipoUsuario"),
          formulario: AModulo,
          idSemana: $semanasContainer.firstChild.lastChild.value,
          anio: $aniosContainer.lastChild.value,
          campoValue: "zon01",
          campoDescripcion: "zon02"
        },
        url : ObtieneUrl("php/", "ObtieneZonasVentas.php")//funcion que usamos para el json de los años
      }, 1)
      );
      
      const $filtroSucursal = await Select({ //se crea el select del año con la funcion de Select
        nombreTabla: 'Sucursales', 
        params: {
          tipoUsuario: sessionStorage.getItem("tipoUsuario"),
          idPonderado: ObtieneVariableSession("idPonderado"),
          idSemana: $semanasContainer.firstChild.lastChild.value,
          anio: $aniosContainer.lastChild.value,
          formulario: AModulo,
          campoValue: "dzo02",
          campoDescripcion: "dzo04"
        },
        url : ObtieneUrl("php/","ObtieneSucursalesVentas.php")//funcion que usamos para el json de los años
      }, 1);
      
      filtrosFragment.appendChild($filtroSucursal);
      
      document.getElementById("filtros").innerHTML = null;
      document.getElementById("filtros").appendChild(filtrosFragment);
      
      const $radio1 = document.getElementById(`radio-${nombreLabel1}`);
      const $radioGeneral = document.getElementById('radio-general');
      const $semanasList = ObtieneElementoDom("idSemana");
      const $aniosList = ObtieneElementoDom("idAnio");
      const $sucursalesList = document.getElementById("idSucursales");
      const $zonasList = ObtieneElementoDom("idZonas");
      $radio1.checked = "true";
      if(AModulo == 0){
        $radioGeneral.checked = "true";
      }
      $filtroSucursal.style.display = "none";

      const FiltrosChange = async (e)=>{
        if(AModulo == 1){
          if(e.target.id === "idSemana" || e.target.id === "idMes"){

            await CargaZonas($zonasList, $aniosList, $semanasList, ObtieneElementoDom("idMes"), AModulo)
            CargaSucursales($sucursalesList, $zonasList, AModulo, $aniosList.value, $semanasList.value);
          }

        }
          if(e.target.id === "cbZonas"){
            const $checkZonas = ObtieneElementoDom("cbZonas"); 
            const $checkSucursales = ObtieneElementoDom("cbSucursales"); 
  
            if($checkZonas.checked === true){
              $filtroSucursal.style.display = "block";
              CargaSucursales($sucursalesList, $zonasList, AModulo, $aniosList.value, $semanasList.value);
            }else{
              $checkSucursales.checked = false;
              $filtroSucursal.style.display = "none";
              $sucursalesList.style.display = "none";
            }
          }
          if(e.target === $zonasList){
            await CargaSucursales($sucursalesList, $zonasList, AModulo, $aniosList.value, $semanasList.value);
          }
          if(e.target.id === "idAnio"){
           await CargaSemanas($semanasList,$aniosList);
          }
          if(AModulo != 0){
            if(e.target.name === "tipoVenta"){
              $semanasContainer.innerHTML = null;
              if(e.target.value === "0"){
                $semanasContainer.appendChild(await Select({ //se crea el select del año con la funcion de Select
                  nombreTabla: 'Semana', 
                  params: {
                    anio: "2021",
                    campoValue: "id",
                    campoDescripcion: "periodo"
                  },
                  url : ObtieneUrl("php/", "ObtienePeriodosSemanales.php"),
                  valor: await ObtieneSemanaActual()
                },  0));
              } else {
                $semanasContainer.appendChild(await Select({ //se crea el select del año con la funcion de Select
                  nombreTabla: 'Mes', 
                  params: {
                    anio: "2021",
                    campoValue: "idMes",
                    campoDescripcion: "nombreMes"
                  },
                  url : ObtieneUrl("php/", "ObtieneMeses.php"),
                  valor: new Date().getMonth()+1
                },  0));
              }
              await CargaZonas($zonasList, $aniosList, $semanasList, ObtieneElementoDom("idMes"), AModulo)
              CargaSucursales($sucursalesList, $zonasList, AModulo, $aniosList.value, $semanasList.value);
            }
          }
        CbChange();
      }
      filtrosFragment.removeEventListener("change", FiltrosChange);
      
      filtrosFragment.addEventListener("change",  FiltrosChange);
    }

  async  function CargaSucursales($sucursalesList, $zonasList, AModulo, AAnio, ASemana){
     await llenaLista($sucursalesList,{
        url : ObtieneUrl("php/","ObtieneSucursalesVentas.php"),
        params:{
          anio: AAnio,
          idSemana: ASemana,
          tipoUsuario: sessionStorage.getItem("tipoUsuario"),
          idPonderado: sessionStorage.getItem("idPonderado"),
          idZona : $zonasList.value,
          formulario : AModulo,
          campoValue: "dzo02",
          campoDescripcion: "dzo04"
        }
      });
    }

  async function CargaSemanas($semanasList, $aniosList){
    await llenaLista($semanasList,{
      url: ObtieneUrl("php/", "ObtienePeriodosSemanales.php"),
      params:{
        anio: $aniosList.value,
        campoValue: "id",
        campoDescripcion: "periodo"
      }
    });
  }

  async function CargaZonas($zonasList,$aniosList,$semanasList, $mesList, AModulo){
    await llenaLista($zonasList,{
      url: ObtieneUrl("php/", "ObtieneZonasVentas.php"),
      params:{
        tipoUsuario: ObtieneVariableSession("tipoUsuario"),
        formulario: AModulo,
        idSemana: ($semanasList != null)? $semanasList.value : "",
        anio: $aniosList.value,
        tipoVenta: TipoVenta(),
        idMes: ($mesList != null )? $mesList.value : "",
        campoValue: "zon01",
        campoDescripcion: "zon02"
      }
    });
  }

  function TipoVenta (){
    const radios = document.getElementsByName("tipoVenta");
    for(let i = 0; i < radios.length; i++){
      if(radios[i].checked){
        return radios[i].value;
      }
    }
  }

  function RemueveListener(){
    console.log("HOla");
  }