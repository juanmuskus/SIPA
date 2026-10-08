
var servicio={};
servicio.init = function(){
 // console.log('Hola Kami'); 
 servicio.agregarservicio();
 servicio.editarservicio();
 servicio.eliminarservicio();
}
$(servicio.init);

//Creo un Metodo de Agregar Conductor...
servicio.agregarservicio = function(){
  //Validación de que los campos no se vayan vacios
    $( "#ser" ).validate({
  rules: {
    servi: {
      required: true
       },
       valo: {
      required: true
       },
       codi:{
       required: true    
       },
       obser:{
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
    if($('#ser').valid()){
    var servicio= $('#servi').val(); 
    console.log(servicio);
    var valor= $('#valo').val();
    console.log(valor);
    var codigo= $('#codi').val();
    console.log(codigo);
    var observacion= $('#obser').val();
    console.log(observacion);
   
    //Metodo Para enviar los datos al controlador
   var ajax= $.post('/servicio/guardarservicio', {servicio:servicio, valor:valor, codigo:codigo, observacion:observacion});
  // Codigo para actualizar la facultad cuando se agrega una nuevo vehiculo..
   ajax.done(function(){
   window.location='/servicio/listarservicio';
  });
    }
    
    });
    
}
servicio.editarservicio = function(){
     //Validación de que los campos no se vayan vacios
    $( "#ser" ).validate({
  rules: {
   servi: {
      required: true
       },
       valo: {
      required: true
       },
       codi:{
       required: true    
       },
       obser:{
       required: true   
       }
      }
   });
    var programacion= $('#codi').data('programacion');
    //console.log(programacion);
     // Val le asigna valor al selector
    $('#codi').val(programacion);
    //Se actualice el valor del selector cuando elija una faculta que este asociado a un programa
    $('#codi').trigger('change');
    //creo la variable tipo
    var tipo= $('#servi').data('tipo');
    //val le asigna valor al selector
    $('#servi').val(tipo);
    //Actualiza el valor del selector
    $('#servi').trigger('change');
    
    //on hace la asignación de un evento..
    $('#editar').on('click', function(){  
    //Valido los campos
    if($('#ser').valid()){    
    var servicio= $('#servi').val(); 
    console.log(servicio);
    var valor= $('#valo').val();
    console.log(valor);
    var codigo= $('#codi').val();
    console.log(codigo);
    var observacion= $('#obser').val();
    console.log(observacion);
    
    
    //Id Del hidden
    
    var id= $('#cod_servicio').val();
  
   
    //Metodo Para enviar los datos al controlador
 var ajax=  $.post('/servicio/actualizarservicio', {servicio:servicio, valor:valor, codigo:codigo, observacion:observacion, id:id});
       //Actualizar Facultad
        ajax.done(function(){
       window.location='/servicio/listarservicio';
  });    
    }
    });
    
}
servicio.eliminarservicio = function(){
//Asignación de eventos por delegados
$(document).on('click', '.eliminar_servicio', function(e){
  //No se comporte por defecto viene, de mandarme a otra pagina  
  e.preventDefault(); 
   //Elemnto cliqueado
 var elementocliqueado= this;
 //console.log('HOla'); 
    bootbox.dialog({
  message: "Esta Seguro de Borrar el Servicio",
  title: "Confirmar Servicio",
  buttons: {
    default: {
      label: "Aceptar",
      className: "btn-default",
      callback: function() {
       // Example.show("Se realizo con Exito");
        var servicio_id=$(elementocliqueado).data('servicio');
// console.log(facultad_id);

 var ajax= $.post('/servicio/eliminarservicio', {servicio_id:servicio_id});
 
 ajax.error(function(){
     alert('Error, No puede Borrar, el Servicio');
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








