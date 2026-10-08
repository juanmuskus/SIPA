  //Funcion para que cargue el calendario
  $(function(){
      $('.calendario').datepicker({
          language: "es"      
      });
      $('.calendarioboton').on("click", function(){
       $(this).closest('.calendario').datepicker('show');  
      });
  });
  
   
 $(function(){
    $(document).ready(function() {
   // $('#example').dataTable();
  });      
 }); 
 // Para las multiples tablas
 $(function(){
   $(document).ready(function() {
  //  $('table.display').dataTable();
} );      
 });

  
