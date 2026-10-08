
var partirespo={};
partirespo.init = function(){
 // console.log('Hola Kami'); 
 partirespo.agregarpartirespo();
 partirespo.editarpartirespo();
 partirespo.eliminarpartirespo();
}
$(partirespo.init);

//Creo un Metodo de Agregar Facultad...
partirespo.agregarpartirespo = function(){
    //Validación de que los campos no se vayan vacios
    $( "#res" ).validate({
  rules: {
    do: {
      required: true
       },
     iden: {
      required: true
       },
      pernoc: {
      required: true
       },
      estu: {
      required: true
       },
      }
   });
    //on hace la asignación de un evento..
    $('#agregar').on('click', function(){
       // console.log('Hola')
    //val me devuelve el elemento que esta en el id de la función  (extrae el valor del input)
    // #facultad valor del input
    // facultad variable donde se guarda los datos
    if($('#res').valid()){
    var docente= $('#do').val();
    console.log(docente);
    var identificacion= $('#iden').val();
    console.log(identificacion);
    var pernoctado= $('#pernoc').val();
    console.log(pernoctado);
    var auxilio= $('#estu').val();
    console.log(auxilio);
    //Metodo Para enviar los datos al controlador
  var ajax= $.post('/Partirespos/guardarpartirespo', {docente:docente, identificacion:identificacion, pernoctado:pernoctado, auxilio:auxilio});
  // Codigo para actualizar la facultad cuando se agrega una nueva facultad..
  ajax.done(function(){
     // window.location='/Partirespos/listarfacultad';
  });
    }
    
    });
    
}
partirespo.editarpartirespo = function(){
     //Validación de que los campos no se vayan vacios
    $( "#res" ).validate({
  rules: {
    do: {
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
    if($('#fac').valid()){
    var facultad= $('#facultad').val(); 
    //Guardar el id de facultades
    var id=$('#id_facultad').val();
    
            
   // console.log(facultad);
    //Metodo Para enviar los datos al controlador
 var ajax=  $.post('/Partirespos/actualizarfacultad', {facultad:facultad, id:id});
       //Actualizar Facultad
        ajax.done(function(){
      window.location='/facultades/listarfacultad';
  });    
    }
    });
    
}
 partirespo.eliminarpartirespo = function(){
//Asignación de eventos por delegados
$(document).on('click', '.eliminar_facultad', function(e){
  //No se comporte por defecto viene, de mandarme a otra pagina  
  e.preventDefault(); 
   //Elemnto cliqueado
 var elementocliqueado= this;
 //console.log('HOla'); 
    bootbox.dialog({
  message: "Esta Seguro de Borrar La Facultad",
  title: "Confirmar Facultad",
  buttons: {
    default: {
      label: "Aceptar",
      className: "btn-default",
      callback: function() {
       // Example.show("Se realizo con Exito");
        var facultad_id=$(elementocliqueado).data('facultad');
// console.log(facultad_id);

 var ajax= $.post('/facultades/eliminarfacultad', {facultad_id:facultad_id});
 
 ajax.error(function(){
     alert('Error, No puede Borrar, Por que hay una llave foranea de programas a facultad');
 });
 //Codigo para actualizar automaticamente la pagina..
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





