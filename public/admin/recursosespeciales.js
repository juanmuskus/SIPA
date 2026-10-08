
var recursosespeciales={};
recursosespeciales.init = function(){
 // console.log('Hola Kami'); 
 recursosespeciales.agregarrecursos();
 recursosespeciales.editarrecursos();
 recursosespeciales.eliminarrecursos();
}
$(recursosespeciales.init);

//Creo un Metodo de Agregar Facultad...
recursosespeciales.agregarrecursos = function(){
    //Validación de que los campos no se vayan vacios
    $( "#recur" ).validate({
  rules: {
    recu: {
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
    if($('#recur').valid()){
    var nombre= $('#recu').val();  
    console.log(nombre);
    //Metodo Para enviar los datos al controlador
  var ajax= $.post('/recurespeciales/guardarrecurespeciales', {nombre:nombre});
  // Codigo para actualizar la facultad cuando se agrega una nueva facultad..
  ajax.done(function(){
    window.location='/recurespeciales/listarrecurespeciales';
  });
    }
    
    });
    
}
recursosespeciales.editarrecursos = function(){
     //Validación de que los campos no se vayan vacios
    $( "#recur" ).validate({
  rules: {
    recu: {
      required: true
       }
      }
   });
    //on hace la asignación de un evento..
    $('#editar').on('click', function(){
       // console.log('Hola')
    //val me devuelve el elemento que esta en el id de la función  (extrae el valor del input)
    // #facultad valor del input
    // facultad variable donde se guarda los datos
    //Valido los campos
    if($('#recur').valid()){
    var nombre= $('#recu').val(); 
    //Guardar el id de facultades
    var id=$('#id_recursos').val();
    
            
   // console.log(facultad);
    //Metodo Para enviar los datos al controlador
 var ajax=  $.post('/recurespeciales/actualizarrecurespeciales', {nombre:nombre, id:id});
       //Actualizar Facultad
        ajax.done(function(){
      window.location='/recurespeciales/listarrecurespeciales';
  });    
    }
    });
    
}
recursosespeciales.eliminarrecursos = function(){
//Asignación de eventos por delegados
$(document).on('click', '.eliminar_recursos', function(e){
  //No se comporte por defecto viene, de mandarme a otra pagina  
  e.preventDefault(); 
   //Elemnto cliqueado
 var elementocliqueado= this;
 //console.log('HOla'); 
    bootbox.dialog({
  message: "Esta seguro de borrar el recurso especial",
  title: "Confirmar recurso especial",
  buttons: {
    default: {
      label: "Aceptar",
      className: "btn-default",
      callback: function() {
       // Example.show("Se realizo con Exito");
        var nombre_id=$(elementocliqueado).data('recursos');
// console.log(facultad_id);

 var ajax= $.post('/recurespeciales/eliminarrecurespeciales', {nombre_id:nombre_id});
 
 ajax.error(function(){
     alert('Error, No puede Borrar, el recurso especial');
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





