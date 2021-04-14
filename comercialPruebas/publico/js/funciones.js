const d = document;

export const llenaAnios = (anioInicial, lista) => {
	const fecha = new Date(),
		anioActual = fecha.getFullYear(),
		$fragmento = d.createDocumentFragment();
		
	for(let i = anioInicial; i <= anioActual; i++){
		const opcion = d.createElement("option");
		if(i === anioActual){
			opcion.selected = 'selected';
		}
		
		opcion.value = i;
		opcion.text = i;
		
		$fragmento.appendChild(opcion);
	} 
	
	lista.appendChild($fragmento);
};


export const llenaLista = async(params,endPont, lista, seleccionado) =>{	
	const $fragment = document.createDocumentFragment();
	while(lista.firstChild){
		lista.removeChild(lista.firstChild);
	}	
		let options = {
			method: "get",
			url: endPont,
			params: params
		},
		res = await axios(options),
		json = await res.data;
		json.forEach(obj => {
			const {value, texto} = obj;
			const opt = document.createElement("option");
			opt.value = value;
			opt.innerHTML = texto;
			/*if(seleccionado === value){
				opt.selected = true;
			}*/
			$fragment.appendChild(opt);
		});
		lista.appendChild($fragment);
		lista.selectedIndex = seleccionado-1;
		return lista.value;
}

export function ocultaFiltro (check, filtro){
	console.log("Hola");
	if(check.checked){
		filtro.style.display = 'block';
	}else{
		filtro.style.display = 'none';
	}
}