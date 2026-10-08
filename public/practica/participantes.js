
var participantes={};
participantes.init = function(){
 // console.log('Hola Kami'); 
//participantes.agregardocente();
participantes.agregarauxiliar();
participantes.agregarasesor();
 
}
$(participantes.init);


participantes.agregarauxiliar = function(){
    //on hace la asignación de un evento..
    $('#agrega').on('click', function(){
       // console.log('Hola')
    
   var nombre= $('#aux').val();  
    console.log(nombre);
   var identificacion= $('#auxiliar').val();
   console.log(identificacion);
   var tipo_participante= ('auxiliar');
   console.log(tipo_participante);
   var valid= true;
  if(nombre != "" && identificacion > 0 && tipo_participante != ""){
   
    //Metodo Para enviar los datos al controlador
  var ajax= $.post('/Participantes/guardarparticipante', {nombre:nombre, identificacion:identificacion, tipo_participante:tipo_participante});
  // Codigo para actualizar la facultad cuando se agrega una nueva facultad..
  ajax.done(function(data){
       //pintar una nueva opción
      var html= "";
      html= '<option value='+ data.id_participante +'>'+ data.nombre +'</option>';
      console.log(html);
      console.log(data);
      $('#auxi').append(html);
      //Para que se pueda seleccionar el selector
      $('#auxi').find('option[value='+ data.id_participante +']').attr('selected', true);
      $('#auxi').triggerHandler('change');
     // window.location='/facultades/listarfacultad';
  });    
  } else{
      valid = false;
      alert('Los Datos Son Incorrectos');
  }  
 
    });        
}
participantes.agregarasesor = function(){
    //Validación de que los campos no se vayan vacios
    //on hace la asignación de un evento..
    $('#agre').on('click', function(){
       // console.log('Hola')
    //val me devuelve el elemento que esta en el id de la función  (extrae el valor del input)
    // #facultad valor del input
    // facultad variable donde se guarda los datos
    
   var nombre= $('#ase').val();  
   console.log(nombre);
   var identificacion= $('#asesor').val();
   console.log(identificacion);
   var tipo_participante= ('asesor');
   console.log(tipo_participante);
   var valid= true;
   
   if(nombre != "" && identificacion > 0 && tipo_participante != ""){
      //Metodo Para enviar los datos al controlador
  var ajax= $.post('/Participantes/guardarparticipante', {nombre:nombre, identificacion:identificacion, tipo_participante:tipo_participante});
  // Codigo para actualizar la facultad cuando se agrega una nueva facultad..
  ajax.done(function(data){
       var html= "";
      html= '<option value='+ data.id_participante +'>'+ data.nombre +'</option>';
      console.log(html);
      console.log(data);
      $('#ases').append(html);
      //Para que se pueda seleccionar el selector
      $('#ases').find('option[value='+ data.id_participante +']').attr('selected', true);
      $('#ases').triggerHandler('change');
      
     // window.location='/facultades/listarfacultad';
  });    
       
   }else{
       valid = false;
      alert('Los Datos Son Incorrectos'); 
   }

    });
    
    
    
}




