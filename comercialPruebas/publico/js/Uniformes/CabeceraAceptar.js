export function CabeceraAceptar(){
 return `<h4>ACEPTAR UNIFORMES</h4>
 <div class="form-check">
  Descontar en: 
  <input type="radio" name="semanas" value="3">3
  <input type="radio" name="semanas" value="6">6
  <input type="radio" name="semanas" value="9">9
  <input type="radio" name="semanas" value="12" checked>12 Semanas
 </div>
 Comentarios:<input type="text" name="comentarios" value="" size=100>`;
 }