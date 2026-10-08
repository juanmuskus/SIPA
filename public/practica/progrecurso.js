
var progrecurso={};
progrecurso.init = function(){
 // console.log('Hola Kami'); 
progrecurso.agregarprogrecurso();

 
}
$(progrecurso.init);

//Creo un Metodo de Agregar Facultad...
progrecurso.agregarprogrecurso = function(){
   

    var table=$('#examplee').DataTable();
       $(document).on('click', '#rec', function(e){
  //No se comporte por defecto viene, de mandarme a otra pagina  
  e.preventDefault(); 
   //Elemnto cliqueado
 var elementocliqueado= this;
 //console.log('HOla'); 
    bootbox.dialog({
  message: "agregar recurso especial",
  title: "Confirmar Recurso",
  buttons: {
    default: {
      label: "Aceptar",
      className: "btn-default",
      callback: function() {
     var idrecurso= $('#tipo').val();   
     var tipo= $('#tipo option:selected').html();
      // console.log(tipo);
     var valor= $('#valor').val(); 
      // console.log(valor);
       
        if(valor > 0){
       //Metodo Para enviar los datos al controlador
  var ajax= $.post('/Progrecurso/guardarprogrecurso', {valor:valor, idrecurso:idrecurso});
      ajax.done(function(data){
          console.log(data);
       //pintar una nueva opción
        table.row.add([
         data.id_pro,   
         tipo,
         valor,
         '<td><a class="eliminar_practicaa" data-practica="" href="#"><i class="fa fa-trash" style="font-size:18px;color:#d9534f;cursor:pointer;"></i></a></td>'
           
      ]).draw();

      
     // window.location='/facultades/listarfacultad';
  }); 
  }else{
        valid = false;
        alert('Los Datos Son Incorrectos');
        
    }
   //función para eliminar una fila
      $(document).on( 'click', '.eliminar_practicaa', function (e) {
          // Previene los comportamientos por defectos
           e.preventDefault(); 
    table
        .row( $(this).parents('tr') )
        .remove()
        .draw();
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






