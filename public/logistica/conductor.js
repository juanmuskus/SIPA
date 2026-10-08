
var conductor={};
conductor.init = function(){
 // console.log('Hola Kami'); 
 conductor.agregarconductor();
 conductor.editarconductor();
 conductor.eliminarconductor();
}
$(conductor.init);

//Creo un Metodo de Agregar Conductor...
conductor.agregarconductor = function(){
  //Validación de que los campos no se vayan vacios
    $( "#con" ).validate({
  rules: {
    nom: {
      required: true
       },
       ape: {
      required: true
       },
       ide: {
      required: true
       },
       tele: {
      required: true
       },
       dir: {
      required: true
       }
      }
   });
    //on hace la asignación de un evento..
    $('#agregar').on('click', function(){
       console.log('Hola')
    //val me devuelve el elemento que esta en el id de la función  (extrae el valor del input)
    // #facultad valor del input
    // facultad variable donde se guarda los datos
    if($('#con').valid()){
    var nom= $('#nom').val(); 
    console.log(nom);
    var ape= $('#ape').val();
    console.log(ape);
    var ide= $('#ide').val();
    console.log(ide);
    var tele= $('#tele').val();
    console.log(tele);
    var dir= $('#dir').val();
    console.log(dir);
    //Metodo Para enviar los datos al controlador
  var ajax= $.post('/conductor/guardarconductor', {nom:nom, ape:ape, ide:ide, tele:tele, dir:dir});
  // Codigo para actualizar la facultad cuando se agrega una nueva facultad..
  ajax.done(function(){
   window.location='/conductor/listarconductor';
  });
    }
    
    });
    
}
conductor.editarconductor = function(){
     //Validación de que los campos no se vayan vacios
    $( "#con" ).validate({
  rules: {
     nom: {
      required: true
       },
       ape: {
      required: true
       },
       ide: {
      required: true
       },
       tele: {
      required: true
       },
       dir: {
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
    if($('#con').valid()){
    var nombre= $('#nom').val(); 
    console.log(nombre);
    var apellido= $('#ape').val();
    console.log(apellido);
    var identificacion= $('#ide').val();
    console.log(identificacion);
    var telefono= $('#tele').val();
    console.log(telefono);
    var direccion= $('#dir').val();
    console.log(direccion);
    //Guardar el id de facultades
    var id=$('#id_conductor').val();
    console.log(id);
            
   // console.log(facultad);
    //Metodo Para enviar los datos al controlador
 var ajax=  $.post('/conductor/actualizarconductor', {nombre:nombre, apellido:apellido, identificacion:identificacion, telefono:telefono, direccion:direccion, id:id});
       //Actualizar Facultad
        ajax.done(function(){
        window.location='/conductor/listarconductor';
  });    
    }
    });
    
}
conductor.eliminarconductor = function(){
//Asignación de eventos por delegados
$(document).on('click', '.eliminar_conductor', function(e){
  //No se comporte por defecto viene, de mandarme a otra pagina  
  e.preventDefault(); 
   //Elemnto cliqueado
 var elementocliqueado= this;
 //console.log('HOla'); 
    bootbox.dialog({
  message: "Esta Seguro de Borrar el conductor",
  title: "Mensaje de Confirmación",
  buttons: {
    default: {
      label: "Aceptar",
      className: "btn-default",
      callback: function() {
       // Example.show("Se realizo con Exito");
        var conductor_id=$(elementocliqueado).data('conductor');
// console.log(facultad_id);

 var ajax= $.post('/conductor/eliminarconductor', {conductor_id:conductor_id});
 
 ajax.error(function(){
     alert('Error, No puede Borrar, Por que hay una llave foranea de programas a facultad');
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








