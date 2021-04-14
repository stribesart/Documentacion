export function FiltroTipoConsulta(){
 const divRadio = GeneraElementoDom("div");
 let nombreLabel1;
 let nombreLabel2;
 
 nombreLabel1 = "Mas Vendidos";
 nombreLabel2 = "Menos Vendidos";
 
 divRadio.appendChild(Input(nombreLabel1, "radio", 'radio-mas-vendidos', "tipoConsulta", "0", 1, 0));
 divRadio.appendChild(Input(nombreLabel2, "radio", 'radio-menos-vendidos', "tipoConsulta", "1", 1));
 return divRadio;
}