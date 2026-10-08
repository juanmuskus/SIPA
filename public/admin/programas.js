
var programas={};
programas.init = function(){
  //console.log('Hola Kami'); 
programas.agregarprograma();
programas.editarprograma();
programas.eliminarprogramas();
}
$(programas.init);

programas.agregarprograma = function(){
    //Validación de que los campos no se vayan vacios
    $( "#pro" ).validate({
  rules: {
    programa: {
      required: true 
       },
       facultad:{
       required: true    
       }
       
      }
   });
  //on hace la asignación de un evento..
    $('#agregar').on('click', function(){
        //console.log('Hola')
    if($('#pro').valid()){
    var facultad= $('#facultad').val();
    //console.log(facultad);
    //val me devuelve el elemento que esta en el id de la función  (extrae el valor del input)
    // #facultad valor del input
    // facultad variable donde se guarda los datos
    var programa= $('#programa').val();  
      //console.log(programa);
    //Metodo Para enviar los datos al controlador
 var ajax=  $.post('/programas/guardarprograma', {programa:programa, facultad:facultad});  
     //Codigo de Actualizar
     ajax.done(function(){
      window.location='/programas/listarprograma';   
     });
    }
    }); 
 
    
}
 programas.editarprograma = function(){
   //Validación de campos vacios
    $( "#pro" ).validate({
  rules: {
    programa: {
      required: true 
       },
       facultad:{
       required: true    
       } 
      }
   });  
   //Creo una variable que me guarde el dato de la facultad para este caso el id..   
   var facultad= $('#facultad').data('programa');   
 
      $('#facultad').val(facultad);
    //Se actualice el valor del selector cuando elija un programa que este asociado a su facultad.
    $('#facultad').trigger('change');
     // console.log(facultad);}
    //val le asigna valor al selector...
     //Asignación del Evento
 $('#editar').on('click', function(){
     //valido los campos
     if($('#pro').valid()){
     //Creo una variable temporal para que guarde el dato que en el selector de programas
     var idfacultad =$('#facultad').val();
     //console.log(idfacultad);
    //Guardar los datos
     var programa= $('#programa').val();  
      //console.log(programa);
      //Guardar los Datos
      var id= $('#id_programa').val();
    //Metodo Para enviar los datos al controlador
     var ajax= $.post('/programas/actualizarprograma', {programa:programa, facultad:idfacultad, id:id});
  //Actualizar el programa
      ajax.done(function(){
      window.location='/programas/listarprograma';   
     });    
    }
 });
  
 
  } 
  programas.eliminarprogramas = function(){
//Asignación de eventos por delegados
$(document).on('click', '.eliminar_programa', function(e){
  //No se comporte por defecto viene, de mandarme a otra pagina  
  e.preventDefault();  
 //console.log('HOla'); 
//Elemnto cliqueado
  var elementocliqueado= this;
 //función del boton eliminar
  //Elemnto cliqueado
  bootbox.dialog({
  message: "Esta Seguro de Borrar La Programa",
  title: "Confirmar Programa",
  buttons: {
   default: {
      label: "Aceptar",
      className: "btn-default",
      callback: function() {
       // Example.show("Se realizo con Exito");
        var programa_id=$(elementocliqueado).data('programa');
       //console.log(programa_id);
       var ajax= $.post('/programas/eliminarprograma', {programa_id:programa_id});
     ajax.error(function(){
     alert('Error, No puede Borrar, Por que hay una llave foranea dfacultad a programa');
 });
   //Codigo para actualizar el listar programa cuando se borra un programa...
    ajax.done(function(){
        location.reload();
    });
      }
    },
    danger: {
      label: "Cancelar",
      className: "btn-danger",
      callback: function() {
        Example.show("oh, Error!");
      }
    }
  }
});

 
});
    
    
} 
  
   