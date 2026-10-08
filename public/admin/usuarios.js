
var usuarios={};
usuarios.init = function(){
  //console.log('Hola Kami'); 
usuarios.agregarusuario();
usuarios.agregarusurdep();
usuarios.editarusuario();
usuarios.eliminarusuario();
usuarios.resetearcontrasena();
usuarios.nuevacontrasena();
}
$(usuarios.init);

  usuarios.agregarusuario = function(){
    //Validación de que los campos no se vayan vacios
    $( "#usu" ).validate({
  rules: {
    nom: {
      required: true 
       },
       ape:{
       required: true    
       },
       ide:{
       required: true    
       },
       correo:{
       required: true    
       },
       usuario:{
       required: true    
       },
       pass:{
       required: true    
       },
       programa:{
       required: true    
       },
       rol:{
       required: true    
       }
      }
   });
  //on hace la asignación de un evento..
    $('#agregar').on('click', function(){
        //console.log('Hola')
    if($('#usu').valid()){
    //Declaro las variables que se van a enviar por ajax  
    var nom= $('#nom').val();
    var ape= $('#ape').val();
    var ide= $('#ide').val();
    var correo= $('#correo').val();
    var usuario= $('#usuario').val();
    var pass= $('#pass').val();
    var programa= $('#programa').val();
    var rol= $('#rol').val();
    //console.log(facultad);
    //val me devuelve el elemento que esta en el id de la función  (extrae el valor del input)
    // #facultad valor del input
    // facultad variable donde se guarda los datos 
    //console.log(programa);
    
    //Metodo Para enviar los datos al controlador
 // var ajax= 
      var ajax= $.post('/usuarios/guardarusuario', {nom:nom, ape:ape, ide:ide, correo:correo, usuario:usuario, pass:pass, programa:programa, rol:rol});  
     
    ajax.done(function(){
      window.location='/usuarios/listarusuario';   
     });  
    }
    }); 
 
    
} 
usuarios.agregarusurdep = function(){
    //Validación de que los campos no se vayan vacios
    $( "#usu" ).validate({
  rules: {
    nom: {
      required: true 
       },
       ape:{
       required: true    
       },
       ide:{
       required: true    
       },
       correo:{
       required: true    
       },
       usuario:{
       required: true    
       },
       pass:{
       required: true    
       },
       rol:{
       required: true    
       }
      }
   });
  //on hace la asignación de un evento..
    $('#agregar').on('click', function(){
        //console.log('Hola')
    if($('#usu').valid()){
    //Declaro las variables que se van a enviar por ajax  
    var nom= $('#nom').val();
    var ape= $('#ape').val();
    var ide= $('#ide').val();
    var correo= $('#correo').val();
    var usuario= $('#usuario').val();
    var pass= $('#pass').val();
    var rol= $('#rol').val();
    //console.log(facultad);
    //val me devuelve el elemento que esta en el id de la función  (extrae el valor del input)
    // #facultad valor del input
    // facultad variable donde se guarda los datos 
    //console.log(programa);
    
    //Metodo Para enviar los datos al controlador
 // var ajax= 
      var ajax= $.post('/usuarios/guardaruserdep', {nom:nom, ape:ape, ide:ide, correo:correo, usuario:usuario, pass:pass, rol:rol});  
     
  /**  ajax.done(function(){
    //  window.location='/usuarios/listarusuario';   
     }); */
    }
    }); 
 
    
} 
 usuarios.editarusuario = function(){
   //Validación de campos vacios
    $( "#usu" ).validate({
  rules: {
    nom: {
      required: true 
       },
       ape:{
       required: true    
       },
       ide:{
       required: true    
       },
       correo:{
       required: true    
       },
       usuario:{
       required: true    
       },
       pass:{
       required: true    
       },
       programa:{
       required: true    
       },
       rol:{
       required: true    
       }
      }
   }); 
   //Creo una variable que me guarde el dato de la programa para este caso el id..   
   var programa= $('#programa').data('programa');   
 
      $('#programa').val(programa);
    //Se actualice el valor del selector cuando elija un programa que este asociado a su facultad.
    $('#programa').trigger('change');
     // console.log(facultad);}
    //val le asigna valor al selector...
    var rol= $('#rol').data('rol');
    
     $('#rol').val(rol);
     
     $('#rol').trigger('change');
    
    
     //Asignación del Evento
 $('#editar').on('click', function(){
     //valido los campos
     if($('#usu').valid()){
     //Creo una variable temporal para que guarde el dato que en el selector de programa
    //Guardar los datos
     var nom= $('#nom').val();
     var ape= $('#ape').val();
     var ide= $('#ide').val();
     var correo= $('#correo').val();
     var usuario= $('#usuario').val(); 
     var id_programa =$('#programa').val();
     var id_rol =$('#rol').val();
    // console.log(id_rol);
     //
    var id=$('#id_usuario').val();
   // console.log(id);
    //Actualizar el dato del selector cuando lo edite
     programa= $('#programa').val();
     rol= $('#rol').val();
     
    //Metodo Para enviar los datos al controlador
    var ajax= $.post('/usuarios/actualizarusuario', {nom:nom, ape:ape, ide:ide, correo:correo, usuario:usuario,  programa:id_programa, rol:id_rol, id:id });
  //Actualizar el programa
      ajax.done(function(){
      window.location='/usuarios/listarusuario';   
     });   
    }
 }); 
  
 
  } 
  //resetera la contraseña del usuario
  usuarios.resetearcontrasena = function(){
   //Validación de campos vacios
    $( "#usu" ).validate({
  rules: {
    
       pass:{
       required: true    
       },
       pas:{
       required: true    
       },
        pa:{
       required: true    
       }
      }
   }); 

     //Asignación del Evento
 $('#resetear').on('click', function(){
     //valido los campos
     if($('#usu').valid()){
     //Creo una variable temporal para que guarde el dato que en el selector de programa
    //Guardar los datos
    
   //  console.log(ape);
     var pass= $('#pass').val();
     var pas =$('#pas').val();
     console.log(pas);
     var pa =$('#pa').val();
     console.log(pa);
     var id=$('#id_usuario').val();
    
    //Actualizar el dato del selector cuando lo edite
    
    //Metodo Para enviar los datos al controlador
    var ajax= $.post('/usuarios/actualizarres', { pass:pass,  pas:pas, pa:pa, id:id });
    ajax.error(function(){
     alert('No se pueden las contraseñas son incorrectas');
 });
     //Actualizar el programa
        ajax.done(function(){
       window.location='/usuarios/listarusuario';   
        });  
    }
 }); 
  }
  //Nueva contraseña
  usuarios.nuevacontrasena = function(){
    //Validación de campos vacios
    $( "#usu" ).validate({
  rules: {
    
       
       pas:{
       required: true    
       } 
      }
   }); 
        //Asignación del Evento
 $('#cambiar').on('click', function(){
     //valido los campos
     if($('#usu').valid()){
     //Creo una variable temporal para que guarde el dato que en el selector de programa
    //Guardar los datos
    
  
     var pas =$('#pas').val();
     console.log(pas);
     var id=$('#id_usuario').val();
    
    //Actualizar el dato del selector cuando lo edite
    
    //Metodo Para enviar los datos al controlador
    var ajax= $.post('/usuarios/actualizarcontrasena', {  pas:pas,  id:id });
    ajax.error(function(){
    //alert('No se pueden las contraseñas son incorrectas');
 });
     //Actualizar el programa
        ajax.done(function(){
       window.location='/usuarios/listarusuario';   
        });  
    }
 }); 
      
  }
  
  usuarios.eliminarusuario = function(){
//Asignación de eventos por delegados
$(document).on('click', '.eliminar_usuario', function(e){
  //No se comporte por defecto viene, de mandarme a otra pagina  
  e.preventDefault();  
 //console.log('HOla'); 
//Elemnto cliqueado
  var elementocliqueado= this;
 //función del boton eliminar
  //Elemnto cliqueado
  bootbox.dialog({
  message: "Esta Seguro de Borrar La Usuario",
  title: "Confirmar Usuario",
  buttons: {
  default: {
      label: "Aceptar",
      className: "btn-default",
      callback: function() {
       // Example.show("Se realizo con Exito");
        var usuario_id=$(elementocliqueado).data('usuario');
       //console.log(programa_id);
       var ajax= $.post('/usuarios/eliminarusuario', {usuario_id:usuario_id});
     ajax.error(function(){
     alert('Error, No puede Borrar, Por que hay una Relación de programa en Usuarios');
 });
   //Codigo para actualizar el listar programa cuando se borra un programa...
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
  
   