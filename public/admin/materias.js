
var materias={};
materias.init = function(){
  //console.log('Hola Kami'); 
materias.agregarmaterias();
materias.editarmateria();
materias.eliminarmaterias();
}
$(materias.init);

materias.agregarmaterias = function(){
    //Validación de que los campos no se vayan vacios
    $( "#asigna" ).validate({
  rules: {
    asignatura: {
      required: true 
       },
       codigo:{
       required: true    
       },
       grupo:{
       required: true    
       },
       programa:{
       required: true    
       },
       facultad:{
       required: true    
       },
       sede:{
       required: true    
       }
      }
   });
  //on hace la asignación de un evento..
    $('#agregar').on('click', function(){
       // console.log('Hola');
       if ($('#asigna').valid()){
       // facultad variable donde se guarda los datos
       var asignatura= $('#asignatura').val(); 
       var codigo= $('#codigo').val();
       var grupo= $('#grupo').val();
       var programa= $('#programa').val();
       var facultad= $('#facultad').val();
       var sede= $('#sede').val();
       // console.log(sede);
    
     
      //console.log(programa);
    //Metodo Para enviar los datos al controlador
    var ajax= $.post('/asignaturas/guardarasignatura', {asignatura:asignatura, codigo:codigo, grupo:grupo, programa:programa, facultad:facultad, sede:sede}); 
    ajax.done(function(){
         window.location='/asignaturas/listarasignatura';
     }); 
       }
   
  }); 
 
    
}
 materias.editarmateria = function(){
   //Validación de que los campos no se vayan vacios
    $( "#asigna" ).validate({
  rules: {
    asignatura: {
      required: true 
       },
       codigo:{
       required: true    
       },
       grupo:{
       required: true    
       },
       programa:{
       required: true    
       },
       facultad:{
       required: true    
       },
       sede:{
       required: true    
       } 
      }
   });    
  // console.log('hola');
   var programa= $('#programa').data('asignatura');
   //console.log(programa);
   
    //val le asigna valor al selector...
   $('#programa').val(programa);
    //Se actualice el valor del selector cuando elija un programa que este asociado a su facultad.
    $('#programa').trigger('change');
    
     // para que se actualice el id...
    
    var facultad= $('#facultad').data('facultad');
    
    // Val le asigna valor al selector
    $('#facultad').val(facultad);
    //Se actualice el valor del selector cuando elija una faculta que este asociado a un programa
    $('#facultad').trigger('change');
    
    //Para que se actualice el id
    var sede= $('#sede').data('sede');
    
     //val le asigna valor al selector
      $('#sede').val(sede);
      
    //Se actualiza el valor del selector cuando elija una sede que este asociada a una asignatura
    $('#sede').trigger('change');
    
 $('#editar').on('click', function(){
     //Creo una variable temporal para que guarde el dato que en el selector de programas
     //Valido los campos
     if($('#asigna').valid()){
         //Creo una variable...
        var asignatura= $('#asignatura').val(); 
        var codigo= $('#codigo').val();
        var grupo= $('#grupo').val();
        var idprograma= $('#programa').val();
        var id_facultad= $('#facultad').val();
        var id_sede= $('#sede').val();
      //  console.log(id_sede);
    // console.log(idprograma);
      //Creo una variable que me guarde el dato de la facultad para este caso el id. 
    //Guardar los datos
        
      //console.log(programa);
      //Guardar los Datos
      var id= $('#cod_asignatura').val();
      //Actualizar el dato del selector cuando lo edite
      programa= $('#programa').val();
      facultad= $('#facultad').val();
      sede= $('#sede').val();
     // console.log(programa);
    //Metodo Para enviar los datos al controlador
     var ajax= $.post('/asignaturas/actualizarasignatura', {asignatura:asignatura, codigo:codigo, grupo:grupo, programa:idprograma, facultad:id_facultad, sede:id_sede, id:id}); 
 // actualizar las modificaciones de las asignaturas
       ajax.done(function(){
         window.location='/asignaturas/listarasignatura';
     });   
     }
 });
  
 
  }
 materias.eliminarmaterias = function(){
//Asignación de eventos por delegados
$(document).on('click', '.eliminar_asignatura', function(e){
  //No se comporte por defecto viene, de mandarme a otra pagina  
  e.preventDefault();  
 //console.log('HOla'); 
 //Elemnto cliqueado
 var elementocliqueado= this;
 //Codigo de evento de eliminar una asignatura...
 bootbox.dialog({
  message: "Esta Seguro de Borrar La Asignatura",
  title: "Confirmar Asignatura",
  buttons: {
   default: {
      label: "Aceptar",
      className: "btn-default",
      callback: function() {
       // Example.show("Se realizo con Exito");
        //
      var asignatura_id=$(elementocliqueado).data('asignatura');
      // console.log(facultad_id);
     var ajax= $.post('/asignaturas/eliminarasignatura', {asignatura_id:asignatura_id});
     ajax.error(function(){
     alert('Error, No puede Borrar, Por que hay una llave foranea de asignatura a programa');
 });
      //Actualizar eliminar
      ajax.done(function(){
          location.reload();
      });
      }
    },
    danger: {
      label: "Cancelar",
      className: "btn-danger",
      callback: function() {
       // Example.show("oh, Error!");
      }
    } 
  }
});

});
    
    
} 
  
  
  
   