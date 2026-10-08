
var liquidarpracticas={};
liquidarpracticas.init = function(){
 // console.log('Hola Kami'); 
 liquidarpracticas.liquidarpractica();
 liquidarpracticas.editarliquidacion();
// liquidarconductor.eliminarliquidarconductor();
}
$(liquidarpracticas.init);

//Creo un Metodo de Agregar Conductor...
liquidarpracticas.liquidarpractica = function(){
  //Validación de que los campos no se vayan vacios
    $( "#doc" ).validate({
  rules: {
   via: {
      required: true
       },
       estu: {
      required: true
       },
       tran: {
      required: true
       },
       estado: {
      required: true
       },
       pa: {
        required: true   
       },
       lega: {
        required: true   
       },
       le: {
        required: true   
       }
      
      }
   });
      // se actualice automaticamente
  
    //on hace la asignación de un evento..
    $('#agregar').on('click', function(){
      // console.log('Hola')
    
    if($('#doc').valid()){
    var viatico= $('#via').val(); 
    console.log(viatico);
    var estudiantes= $('#estu').val();
    console.log(estudiantes);
    var transporte= $('#tran').val();
    console.log(transporte);
    var estado= $('#estado').val();
    console.log(estado);
    var pagado= $('#pa').val();
    console.log(pagado);
     var legalizado= $('#lega').val();
    console.log(legalizado);
     var fechale= $('#le').val();
    console.log(fechale);
    var cod_practica= $('#cod_practica').val();
    console.log(cod_practica);
 //   var id= $('#liquidar').val();
   
    //Metodo Para enviar los datos al controlador
   // practica= $('#cod').val();
  //  var ajaxx= $.post('/liquidarpracticas/liquidarpractica', {cod_practica:cod_practica});  
    var ajax= $.post('/liquidarpracticas/guardarliquidarpracticas', {viatico:viatico, estudiantes:estudiantes, transporte:transporte, estado:estado, pagado:pagado, legalizado:legalizado, fechale:fechale, cod_practica:cod_practica});
  // Codigo para actualizar la facultad cuando se agrega una nueva facultad..
  ajax.done(function(){
 //  window.location='/practicas/listarpractica';
  });
    }
    
    });
    
}
 liquidarpracticas.editarliquidacion = function(){
  //Validación de que los campos no se vayan vacios
/**  var practica= $('#cod').data('cod');   
 
    $('#cod').val(practica);
    //Se actualice el valor del selector cuando elija un programa que este asociado a su facultad.
    $('#cod').trigger('change'); **/
    $( "#edi" ).validate({
  rules: {
   via: {
      required: true
       },
       estu: {
      required: true
       },
       tran: {
      required: true
       },
       estado: {
      required: true
       },
       pa: {
        required: true   
       },
       lega: {
        required: true   
       },
       le: {
        required: true   
       }
      
      }
   });
    // se actualice automaticamente
      var practica= $('#cod').data('cod');   
 
    $('#cod').val(practica);
    //Se actualice el valor del selector cuando elija un programa que este asociado a su facultad.
    $('#cod').trigger('change');
    //on hace la asignación de un evento..
    $('#editar').on('click', function(){
       console.log('Hola')
    
    if($('#edi').valid()){
    var viatico= $('#via').val(); 
    console.log(viatico);
    var estudiantes= $('#estu').val();
    console.log(estudiantes);
    var transporte= $('#tran').val();
    console.log(transporte);
    var estado= $('#estado').val();
    console.log(estado);
    var pagado= $('#pa').val();
    console.log(pagado);
     var legalizado= $('#lega').val();
    console.log(legalizado);
     var fechale= $('#le').val();
    console.log(fechale);
    var cod_practica= $('#cod').val();
    console.log(cod_practica);
    var id= $('#id_liquidar').val();
    console.log(id);
    //Metodo Para enviar los datos al controlador
    practica= $('#cod').val();
    var ajax= $.post('/liquidarpracticas/actualizarliquidarpracticas', {viatico:viatico, estudiantes:estudiantes, transporte:transporte, estado:estado, pagado:pagado, legalizado:legalizado, fechale:fechale, practica:cod_practica, id:id});
  // Codigo para actualizar la facultad cuando se agrega una nueva facultad..
  ajax.done(function(){
 // window.location='/liquidarpracticas/listarliquidacion';
  });
    }
    
    });
    
}

//Edición Adicional










