
export function ModalHTML(ancho){
 return `
 <button type="button" class="btn btn-primary" style="display: none;" data-bs-toggle="modal" data-bs-target="#ventana" id="botonVentana" >Boton que levanta modal</button>
 <div class="modal fade" id="ventana" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
 <div class="modal-dialog modal-${ancho} modal-dialog-scrollable">
  <form id="formulario-solicitar">  
    <div class="modal-content">
     <div class="modal-header">
       <h4 class="modal-title" id="tituloVentana"></h4>
     </div>
     <div class="modal-body" id="contenidoVentana"></div>
     <div class="modal-footer">
     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cerrar">Cerrar</button>
     </div>
    </div>
   </form>
 </div>
</div>
`
}