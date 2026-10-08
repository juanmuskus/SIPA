
var rutas={};
rutas.init = function(){
 // console.log('Hola Kami'); 
 rutas.agregarruta();
 rutas.editarruta();
 rutas.eliminarruta();
}
$(rutas.init);

//Creo un Metodo de Agregar Facultad...
rutas.agregarruta = function(){
    //Validación de que los campos no se vayan vacios
    $( "#rut" ).validate({
  rules: {
   ori: {
      required: true
       },
      des: {
      required: true
       },
       ruta: {
      required: true
       },
        si: {
      required: true
       }
      }
   });
    
    //on hace la asignación de un evento..
    $('#agregar').on('click', function(){
       // console.log('Hola')
    //val me devuelve el elemento que esta en el id de la función  (extrae el valor del input)
    // #facultad valor del input
    // facultad variable donde se guarda los datos
    if($('#rut').valid()){
    var origen= $('#ori').val(); 
    var destino= $('#des').val();
    var ruta= $('#ruta').val(); 
    var sitio=$('#si').val();
 
    //Metodo Para enviar los datos al controlador
  var ajax= $.post('/rutas/guardarruta', {origen:origen, destino:destino, ruta:ruta, sitio:sitio});
  // Codigo para actualizar la facultad cuando se agrega una nueva facultad..
 ajax.done(function(){
   //  window.location='/rutas/listarruta';
  });
    }
    
    });
    
}
rutas.editarruta = function(){
     //Validación de que los campos no se vayan vacios
    $( "#rut" ).validate({
  rules: {
    ori: {
      required: true
       },
      des: {
      required: true
       },
       ruta: {
      required: true
       },
       si: {
      required: true
       }
      }
   });
   //Para que se actualice el id
    var sitio= $('#si').data('sitio');
    
     //val le asigna valor al selector
      $('#si').val(sitio);
      
    //Se actualiza el valor del selector cuando elija una sede que este asociada a una asignatura
    $('#si').trigger('change');
    //on hace la asignación de un evento..
    $('#editar').on('click', function(){
       // console.log('Hola')
    //val me devuelve el elemento que esta en el id de la función  (extrae el valor del input)
    // #facultad valor del input
    // facultad variable donde se guarda los datos
    //Valido los campos
    if($('#rut').valid()){
     var origen= $('#ori').val(); 
     console.log(origen);
    var destino= $('#des').val();
     console.log(destino);
    var ruta= $('#ruta').val(); 
    console.log(ruta);
    var sitio=$('#si').val();
    console.log(sitio);
    //Guardar el id de facultades
    var id=$('#cod_ruta').val();
    
            
   // console.log(facultad);
    //Metodo Para enviar los datos al controlador
 var ajax=  $.post('/rutas/actualizarruta', {origen:origen, destino:destino, ruta:ruta, sitio:sitio, id:id});
       //Actualizar Facultad
   /**     ajax.done(function(){
     
  });    */
    }
    });
    
}
rutas.eliminarruta = function(){
//Asignación de eventos por delegados
$(document).on('click', '.eliminar_ruta', function(e){
  //No se comporte por defecto viene, de mandarme a otra pagina  
  e.preventDefault(); 
   //Elemnto cliqueado
 var elementocliqueado= this;
 //console.log('HOla'); 
    bootbox.dialog({
  message: "Esta Seguro de Borrar La Ruta",
  title: "Confirmar Ruta",
  buttons: {
    default: {
      label: "Aceptar",
      className: "btn-default",
      callback: function() {
       // Example.show("Se realizo con Exito");
        var ruta_id=$(elementocliqueado).data('ruta');
// console.log(facultad_id);

 var ajax= $.post('/rutas/eliminarruta', {ruta_id:ruta_id});
 
 ajax.error(function(){
     alert('Error, No puede Borrar, No se Puede Borrar la Ruta');
 });
 //Codigo para actualizar automaticamente la pagina..
 ajax.done(function(){
  location.reload();   
 });
      }
    },
   success: {
      label: "Cancelar",
      className: "btn-success",
      callback: function() {
       // Example.show("oh, Error!");
      }
    }
    
  }
});
 
 });   
    
}





