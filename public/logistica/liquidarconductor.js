var liquidarconductor={};
liquidarconductor.init = function(){
 // console.log('Hola Kami'); 
 liquidarconductor.agregarliquidarconductor();
 liquidarconductor.editarliquidarconductor();
 liquidarconductor.eliminarliquidarconductor();
}
$(liquidarconductor.init);

//Creo un Metodo de Agregar Conductor...
liquidarconductor.agregarliquidarconductor = function(){
  //Validación de que los campos no se vayan vacios
    $( "#liqui" ).validate({
  rules: {
    combu: {
      required: true
       },
       pea: {
      required: true
       },
       via: {
      required: true
       },
       impre: {
      required: true
       },
       paga: {
      required: true
       },
       lega: {
        required: true   
       },
       pa: {
        required: true   
       },
       le: {
        required: true   
       },
        ru: {
        required: true   
       },
       condu: {
        required: true   
       },
       cod: {
        required: true   
       },
       veh: {
        required: true   
       },
       obs: {
        required: true   
       }
      }
   });
    //on hace la asignación de un evento..
    $('#agregar').on('click', function(){
       console.log('Hola')
    
    if($('#liqui').valid()){
    var combustible= $('#combu').val(); 
    console.log(combustible);
    var peaje= $('#pea').val();
    console.log(peaje);
    var viatico= $('#via').val();
    console.log(viatico);
    var imprevisto= $('#impre').val();
    console.log(imprevisto);
    var pagado= $('#paga').val();
    console.log(pagado);
     var legalizado= $('#lega').val();
    console.log(legalizado);
    var fechapa= $('#pa').val();
    console.log(fechapa);
     var fechale= $('#le').val();
    console.log(fechale);
    var conductor= $('#condu').val();
    console.log(conductor);
    var cod_practica= $('#cod').val();
    console.log(cod_practica);
    var vehiculo= $('#veh').val();
    console.log(vehiculo);
    var observacion= $('#obs').val();
    console.log(observacion);
    //Metodo Para enviar los datos al controlador
  var ajax= $.post('/liquiconductor/guardarliquiconductor', {combustible:combustible, peaje:peaje, viatico:viatico, imprevisto:imprevisto, pagado:pagado, legalizado:legalizado, fechapa:fechapa, fechale:fechale, conductor:conductor, cod_practica:cod_practica, vehiculo:vehiculo, observacion:observacion});
  // Codigo para actualizar la facultad cuando se agrega una nueva facultad..
  ajax.done(function(){
   window.location='/liquiconductor/listarliquiconductor';
  });
    }
    
    });
    
}
liquidarconductor.editarliquidarconductor = function(){
     //Validación de que los campos no se vayan vacios
    $( "#liqui" ).validate({
 rules: {
    combu: {
      required: true
       },
       pea: {
      required: true
       },
       via: {
      required: true
       },
       impre: {
      required: true
       },
       paga: {
      required: true
       },
       lega: {
        required: true   
       },
       pa: {
        required: true   
       },
       le: {
        required: true   
       },
        ru: {
        required: true   
       },
       condu: {
        required: true   
       },
       cod: {
        required: true   
       },
       veh: {
        required: true   
       },
       obs: {
        required: true   
       }
      }
   });
    //Creo una variable que me guarde el dato de la practica para este caso el id..   
     var practica= $('#cod').data('cod');   
 
    $('#cod').val(practica);
    //Se actualice el valor del selector cuando elija un programa que este asociado a su facultad.
    $('#cod').trigger('change');
    
     //Creo una variable que me guarde el dato del conductor para este caso el id..  
     var condu= $('#condu').data('condu');   
     $('#condu').val(condu);
   //Creo una variable que me guarde el dato del conductor para este caso el id.. 
    $('#condu').trigger('change');
    
    var vehi= $('#veh').data('veh');
    
    $('#veh').val(vehi);
     $('#veh').trigger('change');
    
    //on hace la asignación de un evento..
    $('#editar').on('click', function(){
     console.log('Hola');
    //Valido los campos
    if($('#liqui').valid()){   
     var id= $('#id').val();
     console.log(id);
     var combustible= $('#combu').val(); 
    console.log(combustible);
    var peaje= $('#pea').val();
    console.log(peaje);
    var viatico= $('#via').val();
    console.log(viatico);
    var imprevisto= $('#impre').val();
    console.log(imprevisto);
    var pagado= $('#paga').val();
    console.log(pagado);
     var legalizado= $('#lega').val();
    console.log(legalizado);
    var fechapa= $('#pa').val();
    console.log(fechapa);
     var fechale= $('#le').val();
    console.log(fechale);
    var conductor= $('#condu').val();
    console.log(conductor);
    var cod_practica= $('#cod').val();
    console.log(cod_practica);
    var vehiculo= $('#veh').val();
    console.log(vehiculo);
    var observacion= $('#obs').val();
    console.log(observacion);
            
   //Actualizar el dato del selector cuando lo edite
     practica= $('#cod').val();
     condu= $('#condu').val();
     vehi= $('#veh').val();
    //Metodo Para enviar los datos al controlador
 var ajax=  $.post('/liquiconductor/actualizarliquiconductor', {combustible:combustible, peaje:peaje, viatico:viatico, imprevisto:imprevisto, pagado:pagado, legalizado:legalizado, fechapa:fechapa, fechale:fechale, condu:conductor, practica:cod_practica, vehi:vehiculo, observacion:observacion, id:id});
       //Actualizar Facultad
        ajax.done(function(){
        window.location='/liquiconductor/verliquidacion';
  });    
    }
    });
    
}
//Edición Adicional

liquidarconductor.eliminarliquidarconductor = function(){
//Asignación de eventos por delegados
$(document).on('click', '.eliminar_liquidarconductor', function(e){
  //No se comporte por defecto viene, de mandarme a otra pagina  
  e.preventDefault(); 
   //Elemnto cliqueado
 var elementocliqueado= this;
 //console.log('HOla'); 
    bootbox.dialog({
  message: "Esta Seguro de Borrar la liquidación del conductor",
  title: "Confirmar Liquidación",
  buttons: {
    default: {
      label: "Aceptar",
      className: "btn-default",
      callback: function() {
       // Example.show("Se realizo con Exito");
        var liquidar_id=$(elementocliqueado).data('liquidar');
// console.log(facultad_id);

 var ajax= $.post('/liquiconductor/eliminarliquiconductor', {liquidar_id:liquidar_id});
 
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
      className: "btn-success",
      callback: function() {
       // Example.show("oh, Error!");
      }
    }
    
  }
});
 
 });   
    
}








