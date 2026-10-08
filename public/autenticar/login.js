var login={};
login.init = function(){
 
 login.autenticar();
}
$(login.init);

login.autenticar = function(){
    
   //Validación de que los campos no se vayan vacios
    $( "#log" ).validate({
  rules: {
    user: {
      required: true
       },
     pass: {
      required: true
       }
      }
   });  
     //on hace la asignación de un evento..
    $('#acceder').on('click', function(e){
       e.preventDefault();   
       // console.log('Hola')
    //val me devuelve el elemento que esta en el id de la función  (extrae el valor del input
    if($('#log').valid()){
    var user= $('#user').val();
   // console.log(user);
    var pass= $('#pass').val();
   // console.log(pass);
   // console.log(pass);
    
   // console.log(facultad);
    //Metodo Para enviar los datos al controlador
  var ajax= $.post('/login/autenticar', {user:user, pass:pass});
    ajax.error(function(){
     alert('Los Datos No son Correctos, Ingreselo de Nuevo');
   //alert('Contraseña es Incorrecta, Ingresela de Nuevo');
 });
  // Codigo para actualizar 
  ajax.done(function(){
      window.location='/Autorizar/index';
  });
    }
    
    }); 
    
}

