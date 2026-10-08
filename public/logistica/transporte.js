
var transporte={};
transporte.init = function(){
 // console.log('Hola Kami'); 
 transporte.agregartransporte();
 transporte.editartransporte();
 transporte.eliminartransporte();
}
$(transporte.init);

//Creo un Metodo de Agregar Conductor...
transporte.agregartransporte = function(){
  //Validación de que los campos no se vayan vacios
    $( "#tra" ).validate({
  rules: {
    placa: {
      required: true
       },
       descri: {
      required: true
       },
       vehi: {
      required: true
       },
       estado: {
      required: true
       },
       pasa: {
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
    if($('#tra').valid()){
    var placa= $('#placa').val(); 
    console.log(placa);
    var descripcion= $('#descri').val();
    console.log(descripcion);
    var vehiculo= $('#vehi').val();
    console.log(vehiculo);
    var estado= $('#estado').val();
    console.log(estado);
    var pasajero= $('#pasa').val();
    console.log(pasajero);
    //Metodo Para enviar los datos al controlador
   var ajax= $.post('/transporte/guardartransporte', {placa:placa, descripcion:descripcion, vehiculo:vehiculo, estado:estado, pasajero:pasajero});
  // Codigo para actualizar la facultad cuando se agrega una nuevo vehiculo..
   ajax.done(function(){
    window.location='/transporte/listartransporte';
  });
    }
    
    });
    
}
transporte.editartransporte = function(){
     //Validación de que los campos no se vayan vacios
    $( "#tra" ).validate({
  rules: {
     placa: {
      required: true
       },
       descri: {
      required: true
       },
       vehi: {
      required: true
       },
       estado: {
      required: true
       },
       pasa: {
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
    if($('#tra').valid()){
    var placa= $('#placa').val(); 
    console.log(placa);
    var descripcion= $('#descri').val();
    console.log(descripcion);
    var vehiculo= $('#vehi').val();
    console.log(vehiculo);
    var estado= $('#estado').val();
    console.log(estado);
    var pasajero= $('#pasa').val();
    console.log(pasajero);
    //Guardar el id de facultades
    var id=$('#cod_transporte').val();
    console.log(id);
            
   // console.log(facultad);
    //Metodo Para enviar los datos al controlador
 var ajax=  $.post('/transporte/actualizartransporte', {placa:placa, descripcion:descripcion, vehiculo:vehiculo, estado:estado, pasajero:pasajero, id:id});
       //Actualizar Facultad
        ajax.done(function(){
        window.location='/transporte/listartransporte';
  });    
    }
    });
    
}
transporte.eliminartransporte = function(){
//Asignación de eventos por delegados
$(document).on('click', '.eliminar_transporte', function(e){
  //No se comporte por defecto viene, de mandarme a otra pagina  
  e.preventDefault(); 
   //Elemnto cliqueado
 var elementocliqueado= this;
 //console.log('HOla'); 
    bootbox.dialog({
  message: "Esta Seguro de Borrar el Vehiculo",
  title: "Confirmar Vehiculo",
  buttons: {
    default: {
      label: "Aceptar",
      className: "btn-default",
      callback: function() {
       // Example.show("Se realizo con Exito");
        var transporte_id=$(elementocliqueado).data('transporte');
// console.log(facultad_id);

 var ajax= $.post('/transporte/eliminartransporte', {transporte_id:transporte_id});
 
 ajax.error(function(){
     alert('Error, No puede Borrar, el Vehiculo');
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








