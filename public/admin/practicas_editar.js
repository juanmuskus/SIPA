
var practicas={};
practicas.init = function(){
 // console.log('Hola Kami'); 
 practicas.agregarpractica ();
 //practicas.editarpractica();
 practicas.eliminarpractica();
}
$(practicas.init);

//Creo un Metodo de Agregar Facultad...
 practicas.agregarpractica = function(){
     sessionStorage.setItem('fecha_salida' ,$('#sal').val());
     sessionStorage.setItem('fecha_llegada' ,$('#lle').val());
     sessionStorage.setItem('fecha_salida_cambia',0);
     sessionStorage.setItem('fecha_llegada_cambia',0);

     
     $('#sal').on('change', function(e){
         var data = $(this).val();
         if(data != sessionStorage.getItem('fecha_salida')){
             console.log("cambia salida");
             sessionStorage.setItem('fecha_salida_cambia',1);
             localStorage.clear();
         }
         else{
             sessionStorage.setItem('fecha_salida_cambia',0);
         }
     });
     
     $('#lle').on('change', function(e){
         var data = $(this).val();
         if(data != sessionStorage.getItem('fecha_llegada')){
             console.log("cambia llegada");
             sessionStorage.setItem('fecha_llegada_cambia',1);
             localStorage.clear();
         }
         else{
             sessionStorage.setItem('fecha_llegada_cambia',0);
         }
     });
//Evento para escoger la facultad
 $('#dep').on('change', function(){
    var departamento = $('#dep').val();
   // console.log(facultad);
 //var programas =('#pro').val();
    
    var ajax= $.get('/Practicas/obtenerprogramas', {departamento:departamento});
    ajax.done(function(data){
      //  console.log(data);
        //limpiar el contenido del selector
        $('#pro').html('');
      //  $('#dep').html('');
        //declaro una variable
        
          for(var i=0; i<data.length; i++){
        // console.log(data);
        //agregar contenido al selector
        $('#pro').append('<option value="'+data[i]['ID_Programa']+'" selected="selected">'+data[i]['Programa']+'</option>'); 
       // $('#dep').append('<option value="'+data[i]['ID_Departamento']+'" selected="selected">'+data[i]['Departamento']+'</option>');
        }  
         $('#pro').trigger('change');
    });
 }); 
 //evento para escoger el departamento
  $('#fac').on('change', function(){
    var facultad = $('#fac').val();
   // console.log('Hola');
 //var programas =('#pro').val();
 
    
    var ajax= $.get('/Practicas/obtenerdepartamento', {facultad:facultad});
    ajax.done(function(data){
      //  console.log(data);
        //limpiar el contenido del selector
         $('#dep').html('');
        //declaro una variable
        
          for(var i=0; i<data.length; i++){
         //console.log(data);
        //agregar contenido al selector
        $('#dep').append('<option value="'+data[i]['ID']+'" selected="selected">'+data[i]['Departa']+'</option>');
        }  
       //EVENTO PARA SIMILAR ENTREDA DEL USUARIO
       $('#dep').trigger('change');
      
    });
 }); 
 //Obtener el programas
 //evento para escoger el departamento
  $('#pro').on('change', function(){
    var programas = $('#pro').val();
   // console.log(departamento);
 //var programas =('#pro').val();
 
    
    var ajax= $.get('/Practicas/obtenersemestre', {programas:programas});
    ajax.done(function(data){
      //  console.log(data);
        //limpiar el contenido del selector
         $('#sem').html('');
        //declaro una variable
        
        for(var i=0; i<data.length; i++){
        // console.log(data);
        //agregar contenido al selector
        $('#sem').append('<option value="'+data[i]['sem']+'" selected="selected">'+data[i]['sem']+'</option>');
        }  
       //EVENTO PARA SIMILAR ENTREDA DEL USUARIO
       $('#sem').trigger('change');
    });
 });
 //Obtener las asignaturas
  $('#sem').on('change', function(){
    var programa= $('#pro').val();  
    var semestre = $('#sem').val();
   // console.log(departamento);
 //var programas =('#pro').val();
 
    
    var ajax= $.get('/Practicas/obtenerasignatura', {semestre:semestre, programa:programa});
    ajax.done(function(data){
      //  console.log(data);
        //limpiar el contenido del selector
        
       $('#asigna').html('');
       // $('#sem').html('');
        
        //declaro una variable
        
          for(var i=0; i<data.length; i++){
        // console.log(data);
        //agregar contenido al selector
        $('#asigna').append('<option value="'+data[i]['id_asigna']+'" selected="selected">'+data[i]['asigna']+'</option>');
        }  
       //EVENTO PARA SIMULAR ENTREDA DEL USUARIO
         $('#asigna').trigger('change');
      // $('#pro').trigger('change');
    });
 });
 //Evento para obtener los grupos de las asignatura escogida
  $('#asigna').on('change', function(){
    var asignatura= $('#asigna').val();  
   
   // console.log(asignatura);
    
    var ajax= $.get('/Practicas/obtenergrupos', {asignatura:asignatura});
    ajax.done(function(data){
      // console.log(data);
        //limpiar el contenido del selector
         $('#gru').html('');
        //declaro una variable
        
          for(var i=0; i<data.length; i++){
       // console.log(data);
        //agregar contenido al selector
        $('#gru').append('<option value="'+data[i]['gru']+'" selected="selected">'+data[i]['gru']+'</option>');
        }  
       //EVENTO PARA SIMULAR ENTREDA DEL USUARIO
       $('#gru').trigger('change');
     
    });
 }); 
 //Evento para obtener los matriculados
  $('#gru').on('change', function(){
    var grupo= $('#gru').val();  
   
   // console.log(grupo);
    
    var ajax= $.get('/Practicas/obtenermatriculados', {grupo:grupo});
    ajax.done(function(data){
      // console.log(data);
        //limpiar el contenido del selector
         $('#num').html('');
        //declaro una variable
        
          for(var i=0; i<data.length; i++){
       // console.log(data);
        //agregar contenido al selector
        $('#num').append('<option value="'+data[i]['mat']+'" selected="selected">'+data[i]['mat']+'</option>');
        }  
       //EVENTO PARA SIMULAR ENTREDA DEL USUARIO
       $('#num').trigger('change');
    });
 }); 
 
 //Evento del docente responsable escogido
 /** $('#nombre').on('change', function(){
    var nombre_solicitante= $('#nombre').val();  
    console.log(nombre_solicitante);
   // console.log(grupo);
    
    var ajax= $.get('/Practicas/obtenerdocente', {nombre_solicitante:nombre_solicitante});
    ajax.done(function(data){
      // console.log(data);
        //limpiar el contenido del selector
         $('#nombre').html('');
        //declaro una variable
        
          for(var i=0; i<data.length; i++){
       // console.log(data);
        //agregar contenido al selector
        $('#nombre').append('<option value="'+data[i]['cod']+'" selected="selected">'+data[i]['ape']+''+data[i]['nom']+'</option>');
        }  
       //EVENTO PARA SIMULAR ENTREDA DEL USUARIO
      // $('#nombre').trigger('change');
    });
 });  */

 
 
     //Evento en el Boton
   var datatable= $('#example').DataTable();
   
      // Para las multiples tablas
     // $('table.display').dataTable();
      $('#prog').on('click', function(){ 
      //Se muestre por consola el resultado de este metodo    
     // datatable.fnGetData();  
     
      var num= $('#num').val(); 
      console.log(num);
      var reco= $('#reco option:selected').html();
       console.log(reco);
      var despla= $('#despla').val();
      console.log(despla);
      var sal= $('#sal').val(); 
       console.log(sal);
      var lug= $('#lug').val(); 
       console.log(lug);
      var dia= $('#per').val(); 
       console.log(dia);
      var lle= $('#lle').val(); 
       console.log(lle);
      // var docen= $('#docen option:selected').html();
     // console.log(docen);
        var auxi= $('#auxi option:selected').html();
       console.log(auxi);
        var ases= $('#ases option:selected').html();
       console.log(ases);
       var obs= $('#obs').val(); 
       console.log(obs);
       
       //función para eliminar una fila
      $(document).on( 'click', '.eliminar_practica', function (e) {
          // Previene los comportamientos por defectos
           e.preventDefault(); 
    datatable
        .row( $(this).parents('tr') )
        .remove()
        .draw();
      });
      
         //Validación De campos Vacios
    var valid= true;
     //llamo a la variable table
      var table=$('#examplee').DataTable();
      
      table.rows().data();
      var recursos= table.data().toArray();
      var recursosdatos= "";
      var ides= [];
      var nombresrecursos= [];
      
      for(var i=0; i<recursos.length; i++){
          ides.push(recursos[i][0]);
          nombresrecursos.push(recursos[i][1]);
          
          
      }
        recursosdatos= nombresrecursos.join(',') +'<input type="hidden" value=' + ides.join(',') + '>' ;
 /**   if(num > 0 && reco != "" && despla != "" && sal != "" && lug != ""  && dia != "" && lle != "" && docen != "" && auxi != "" && ases != "" &&  obs != ""){
       
       
        valid= true;
           // alert('Los Datos Son Correctos');
    }else{
        valid = false;
        alert('Los Datos Son Incorrectos');
    } */
        datatable.row.add([
         num,
         reco,
         sal,
         lug,
         dia,
         lle,
         '<td><div class="hide"><div class="desplazamiento"><input name="desplazamiento" type="hidden" value='+despla+'></div><div class="auxiliares">'+auxi+'<input name="id_auxiliares" type="hidden" value=' + $('#auxi').val()+'></div><div class="asesores">'+ases+'<input name="id_asesores" type="hidden" value=' + $('#ases').val()+'></div><div class="observaciones"><input name="observaciones" type="hidden" value=' +obs+'></div><div class="recursos"><input name="recursos" type="hidden" value=' +recursosdatos+'></div></div> <a class="editar_prog" href="#"><i class="fa fa-pencil-square-o" style="font-size:18px;color:#563d7c;cursor:pointer;"></i></a> <a class="par" href="#"><i class="fa fa-user-plus" style="font-size:18px;color:#337ab7;cursor:pointer;"></i></a> <a class="editar_recur" href="#"><i class="fa fa-pencil-square-o"  style="font-size:18px;color:#21b384;cursor:pointer;"></i></a> <a class="eliminar_practica" data-practica="" href="#"><i class="" style="font-size:18px;color:#d9534f;cursor:pointer;"></i></a> </td>'
          
      ]).draw();
      //Para que se limpie el formulario
      var num= $('#num').val("");
      var reco= $('#reco').val("");
      var despla= $('#despla').val("");
      var sal= $('#sal').val(""); 
      var lug= $('#lug').val(""); 
      var dia= $('#per').val("");
      var lle= $('#lle').val(""); 
      var tipo= $('#tipo').val("");
      var valor= $('#valor').val(""); 
     // var docen= $('#docen option:selected').val("");
      var auxi= $('#auxi option:selected').val("");
      var ases= $('#ases option:selected').val("");
      var obs= $('#obs').val(""); 
       
     
      }); 
      //Validación para que el evento se active inmediatamente cuando los cambios de paso, 
      //pero antes de que el asistente muestra el nuevo paso. 
      //Evento del editar
         $(document).on( 'click', '.editar_prog', function (e) {
             //
            var obtener= datatable.row($(this).parent().parent()).index();
            console.log(obtener);
             //Cargar valores por defecto
             var elemento= $(this).parent().parent();
             var d = datatable.row( elemento ).data();
             //se toma el dato de la ultima columna de la tabla
             //en vez de cargar los datos de d[6] se toman de localstorage
             var data_default = d[6];
             var data_obj = $.parseHTML(data_default);
             var local = [];
             if(localStorage.getItem('dias_obj').length > 0){
                 local= JSON.parse(localStorage.getItem('dias_obj'));
             }
             
             //desplazamiento
//             var desplazamiento_def = $(data_obj).find('.desplazamiento').html();
            var desplazamiento_def = local[obtener].desplazamiento;
            console.log(desplazamiento_def);
            
             //pernoctado se toma de la columna 4 de la tabla tiene valor si y no pero se necesita true o false
           //  console.log(d[4]);
//             var pernoctado_def = (d[4] == "Si" ? 1 : 0);
             var pernoctado_def = (local[obtener].pernoctado == "Si" ? 1 : 0);
            // console.log(pernoctado_def);
             //ruta no esta en los datos ocultos de la columna acciones se toma de la columna 1 de la tabla
             var ruta_def= local[obtener].ruta;
             //docente
//             var docente_def = $(data_obj).find('.docentes').html();
          //   var docente_def = local[obtener].docente;
             //auxiliar
//             var auxiliar_def = $(data_obj).find('.auxiliares').html();
             var auxiliar_def = local[obtener].auxiliar;
             //asesor
//             var asesor_def = $(data_obj).find('.asesores').html();
             var asesor_def = local[obtener].asesor;
             //observaciones
//             var observaciones_def= $(data_obj).find('.observaciones').html();
             var observaciones_def = local[obtener].observaciones;  
             
             
             
              //No se comporte por defecto viene, de mandarme a otra pagina  
          e.preventDefault(); 
           //Elemnto cliqueado
         var elementocliqueado= this;
          //   console.log('hola');
         var form= $('#form').clone();
         form.attr('id', 'form_programacion_popup')
         
         //se aplican los datos al formulario de editar
         
         //recorrido
         // busca en el selector reco la opcion que tenga el mismo valor que la variable ruta_def
        var id_ruta = (ruta_def != null ? ruta_def.slice(ruta_def.indexOf("value=")+6, ruta_def.lastIndexOf('>')) : -1);
        console.log('recorrido');
        console.log(ruta_def);
        console.log(id_ruta);
        if(id_ruta > 0)
        form.find('.reco').val(id_ruta);
        console.log(id_ruta);
         
         //desplazamiento         
         form.find('.despla').val(desplazamiento_def);
         console.log(desplazamiento_def);
         
        //pernoctado     
        pernoctado_def > 0 ? form.find('.per').prop('checked', true) : form.find('.per').prop('checked', false);
        
        //docente
        /*
         * Me llegara un dato similar a este
         * <div class="docentes">Jhanier Garcia Pitalua<input type="hidden" value="3">&gt;</div>
         * pero solo debo sacar el id por lo tanto hay que procesar la cadena para obtener el id solamente
         * en este caso el id es 3
         */
   /**     console.log(docente_def);
        var id_docente = (docente_def != null ? docente_def.slice(docente_def.indexOf("value=")+6, docente_def.lastIndexOf('>')) : -1);
        console.log(id_docente);
        if(id_docente > 0)
        form.find('.docen').val(id_docente); */
        
        //auxiliar
        /*
         * Similar al anterior
         * <div class="auxiliares">Kamilo Cervantes<input type="hidden" value="4"></div>
         */
        console.log(auxiliar_def);
        var id_auxiliar = (auxiliar_def != null ? auxiliar_def.slice(auxiliar_def.indexOf("value=")+6, auxiliar_def.lastIndexOf('>')): -1);
        console.log(id_auxiliar);
        if(id_auxiliar > 0)
        form.find('.auxi').attr('value', id_auxiliar);
//        console.log(form.find('.auxi'));
        //asesor
        /*
         * Similar al anterior
         * <div class="asesores">Luchi Sarriego<input type="hidden" value="5"></div>
         */
        console.log(asesor_def);
        var id_asesor = (asesor_def != null ? asesor_def.slice(asesor_def.indexOf("value=")+6, asesor_def.lastIndexOf('>')): -1);
        console.log(id_asesor);
         if(id_asesor > 0)
        form.find('.ases').val(id_asesor);
        
        //observaciones
        form.find('.obs').val(observaciones_def);
         form.removeClass('hide');
       var dialog =  bootbox.dialog({
         message: form,
         class:'modalancho', 
         title: "Datos de la programación",
         buttons: {
         default: {
         label: "Aceptar",
         className: "btn-default",
         callback: function() {
         //visualizo el vector de objeto, que se lista en el localstorage
        // obj= ;
        // console.log(obj);
       
          //guardo los datos en el LocalStorage
         // localStorage.setItem('dias_obj', dias_obj);
            
         // console.log($(elementocliqueado).parent().parent());   
          var elemento= $(elementocliqueado).parent().parent();
          var desplazamiento= form.find('.despla').val();
          console.log(desplazamiento);
          var pernoctado= form.find('.per').is(':checked')?'Si':'No';
          var ruta= form.find('.reco option:selected').html()+'<input type="hidden" value=' + form.find('.reco').val() + '>';
         // var docente=form.find('.docen option:selected').html()+'<input type="hidden" value=' + form.find('.docen').val() + '>';
          var auxiliar=form.find('.auxi option:selected').html()+'<input type="hidden" value=' + form.find('.auxi').val() + '>';
          var asesor=form.find('.ases option:selected').html()+'<input type="hidden" value=' + form.find('.ases').val() + '>';
          var observaciones= form.find('.obs').val();
          var d = datatable.row( elemento ).data();
          
          var obtener= datatable.row($(elementocliqueado).parent().parent()).index();  
            console.log(obtener);
         //extraigo con get
         //creo un vector de objeto
         var obj= JSON.parse(localStorage.getItem('dias_obj'));
         console.log(obj);
         obj[obtener].desplazamiento= desplazamiento;
         obj[obtener].pernoctado= pernoctado;
         obj[obtener].ruta= ruta;
        // obj[obtener].docente= docente;
         obj[obtener].auxiliar= auxiliar; 
         obj[obtener].asesor= asesor;
         obj[obtener].observaciones= observaciones;
         localStorage.setItem('dias_obj', JSON.stringify(obj));
           //se captura el valor guardado de campos escondidos de la tabla
           var tmp = d[6];
//           console.log("preprocesado");
//           console.log(tmp);
           //se convierte la informacion que esta en html a objeto jquery
           tmp = $.parseHTML(tmp);
//           console.log("nodo jquery");
           console.log(tmp);
           //de dicha informacion se saca la parte de recurso que no se recopila en el modal de editar
           var recursos = $('.recursos', tmp).html();
           console.log(recursos);
           d[1]=ruta;
         //  d[2]=desplazamiento;
           d[4]=pernoctado;
           //en vez de guardar la informacion en d[6] la guardaremos en localStorage
           localStorage.setItem('desplazamiento', desplazamiento);
           localStorage.setItem('pernoctado', pernoctado);
           localStorage.setItem('ruta', ruta);
          // localStorage.setItem('docente', docente);
           localStorage.setItem('auxiliar', auxiliar);
           localStorage.setItem('asesor', asesor);
           localStorage.setItem('observaciones', observaciones);
//           d[6]= '<td><div class="hide"><div class="desplazamiento">'+desplazamiento+'</div><div class="docentes">'+docente+'></div><div class="auxiliares">'+auxiliar+'</div><div class="asesores">'+asesor+'</div><div class="observaciones">' +observaciones+'</div><div class="recursos">'+recursos+'</div></div><a class="editar_prog" href="#"><i class="fa fa-pencil-square-o" style="font-size:18px;color:#563d7c;cursor:pointer;"></i></a> <a class href="#"><i class="fa fa-user-plus" style="font-size:18px;color:#337ab7;cursor:pointer;"></i></a> <a class="editar_recur" href="#"><i class="fa fa-pencil-square-o"  style="font-size:18px;color:#21b384;cursor:pointer;"></i></a> <a class="eliminar_practica" data-practica="" href="#"><i class="fa fa-trash" style="font-size:18px;color:#d9534f;cursor:pointer;"></i></a> <a class="" href="#"><i class="fa fa-file-text-o" style="font-size:18px;color:#704010;cursor:pointer;"></i></a> </td>';

          // d[8]=docente;
         //  d[9]=auxiliar;
         //  d[10]=asesor;
          // d[11]=observaciones;
          // console.log(d);
        //  d.counter++;
 
         datatable
        .row(elemento)
        .data( d )
        .draw();
       // Example.show("Se realizo con Exito");
     //   var facultad_id=$(elementocliqueado).data('facultad');

 //Codigo para actualizar automaticamente la pagina..
 
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

dialog.init(function(){
    console.log(id_ruta)
    dialog.find('.auxi option[value='+id_auxiliar+']').attr('selected', 'true');
    dialog.find('.ases option[value='+id_asesor+']').attr('selected', 'true');
    dialog.find('.reco option[value='+id_ruta+']').attr('selected', 'true');
    

//    console.log("id_auxiliar");
//    console.log(id_auxiliar+'');
//    $('#form_programacion_popup .auxi').val(id_auxiliar);
//    $('#form_programacion_popup .auxi').trigger('change');
});
     
      });
      //Evento de agregar de participantes
      //Asignación de eventos por delegados
$(document).on('click', '.par', function(e){
  //No se comporte por defecto viene, de mandarme a otra pagina  
  e.preventDefault(); 
   //Elemnto cliqueado
 var elementocliqueado= this;
 //declaro la variable de donde almacena el id del formulario
 
 var par= $('#par').clone();
 
 //console.log('HOla'); 
    par.removeClass('hide');
    bootbox.dialog({
         message: par,
         class:'modalancho', 
         title: "Datos del participante de la programación ",
  buttons: {
    default: {
      label: "Aceptar",
      className: "btn-default",
      callback: function() {
       // Example.show("Se realizo con Exito");
        var nombre= par.find('.nom').val();
        console.log(nombre);
        var identificacion= par.find('.ide').val();
        console.log(identificacion)
        var tipo_participante= par.find('.tip').val();
        console.log(tipo_participante);
// console.log(facultad_id);

 var ajax= $.post('/Participantes/guardarparticipante', {nombre:nombre, identificacion:identificacion, tipo_participante:tipo_participante});
 
/** ajax.error(function(){
     alert('Error, No puede Borrar, No se Puede Borrar la Ruta');
 }); */
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
      
      
      //metodo para visualizar los recursos y el valor
//      $(document).on('')
      //Evento del recursos especiales
      $(document).on( 'click', '.editar_recur', function (e) { 
        //evento del recurso 
       e.preventDefault(); 
       //Elemnto cliqueado
       var elementocliqueado= this;
       var elemento= $(elementocliqueado).parent().parent();
       // console.log(elemento);
       var d = datatable.row( elemento ).data();
      //  console.log(d);
       var recurso= $('#re').clone();    
        //se toma el dato de la ultima columna de la tabla
        //cambiala fuente de datos a localstorage
       var data_default = d[6];
        
       var data_obj = $.parseHTML(data_default);
        var obtener2= datatable.row($(elementocliqueado).parent().parent()).index();  
        console.log(obtener2);
       
       //creo un vector de objeto
         var local2= JSON.parse(localStorage.getItem('dias_obj'));
        console.log(local2);
//       var tipo_def= $(data_obj).find('.recursos').html();
        // var tipo_def= localStorage.getItem('recursos');
        
        var tipo_def = (local2[obtener2].recursosdatos == 0 ? null:local2[obtener2].recursosdatos);
        console.log(tipo_def);
        
        //corto el cadena de string, para que solo me queden los id de los recursos
      // console.log(tipo_def);
       var id_recursos= (tipo_def != null ? tipo_def.slice(tipo_def.indexOf("value=")+6, tipo_def.lastIndexOf('>')): -1);
       console.log(id_recursos);
       id_recursos = id_recursos != -1 ? id_recursos.split(","): null;
       console.log(id_recursos);
       var tabla_recurso = recurso.find('.recurso').DataTable();
       console.log(id_recursos != null && id_recursos.length > 0);
       if(id_recursos != null && id_recursos.length > 0){
//       recurso.find('.recursos').val(id_recursos);
          console.log('hola');
       var ajax=$.post('/Progrecurso/visualizarprogrecurso', {tipo_def:id_recursos.join(',')});
       ajax.done(function(data){
       console.log(data);
       if(data.length > 0){
       
//        console.log(tabla_recurso);
       $.each(data, function(index,value){
           console.log(data);
           tabla_recurso.row.add([
               value.id,
               value.nombre,
               value.valor,
               '<a class="eliminar_practicaa" data-practica="" href="#"><i class="fa fa-trash" style="font-size:18px;color:#d9534f;cursor:pointer;"></i></a>'
            ]).draw(); 
       });
      
       
       
            }
       recurso.removeClass('hide');    
        });
        }else{
            recurso.removeClass('hide');
        }
      
      //   var recurso= $('#re').clone();
         //se aplican los datos al formulario de editar
         
       
       var table=recurso.find('.recurso').DataTable();
       $(document).on('click', '.rec', function(e){
         
       //No se comporte por defecto viene, de mandarme a otra pagina  
       e.preventDefault(); 
      //Elemnto cliqueado
      var elementocliqueado= this;
      //de esta manera no vas a poder sacar los datos
      //los datos se sacan del datatable no del formulario
      var idrecurso= recurso.find('.tipo').val();   
      var tipo= recurso.find('.tipo option:selected').html();
      // console.log(tipo);
      var valor= recurso.find('.valor').val(); 
       //Cargar valores por defecto
       //creo 
      
         
      if(valor > 0){
       //Metodo Para enviar los datos al controlador
      var ajax= $.post('/Progrecurso/guardarprogrecurso', {valor:valor, idrecurso:idrecurso});
      //envio los datos de los recursos por ajax
     
      ajax.done(function(data){
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
      $(document).on( 'click', '.eliminar_practicaa', function (e){
        //  console.log('Hola');
          // Previene los comportamientos por defectos
        e.preventDefault(); 
         table
        .row( $(this).parents('tr') )
        .remove()
        .draw();
      });
 
 }); 
 
    bootbox.dialog({
    message: recurso,
    class:'modalancho', 
  title: "Datos de los Recursos",
  buttons: {
    default: {
      label: "Aceptar",
      className: "btn-default",
      callback: function() {
          var elemento= $(elementocliqueado).parent().parent();
          console.log(elemento);
          var d = datatable.row( elemento ).data();
         // console.log(d);
          
      table.rows().data();
      var recursos= table.data().toArray();
      var recursosdatos= "";
      var ides= [];
      var nombresrecursos= [];
      
      for(var i=0; i<recursos.length; i++){
          ides.push(recursos[i][0]);
          nombresrecursos.push(recursos[i][1]);
          
          
      }
        recursosdatos= nombresrecursos.join(',') +'<input type="hidden" value=' + ides.join(',') + '>' ;
        localStorage.setItem('recursos', JSON.stringify(recursosdatos));
        console.log(recursosdatos);
         //
         var obtener2= datatable.row($(elementocliqueado).parent().parent()).index();  
        //console.log(obtener);
       
       //creo un vector de objeto
         var obj2= JSON.parse(localStorage.getItem('dias_obj'));
         obj2[obtener2].recursosdatos= recursosdatos;
         //guardo los datos localStorage
         localStorage.setItem('dias_obj', JSON.stringify(obj2));
        
           var tmp = d[6];
           console.log(tmp);
           var tmp2;
           console.log("preprocesado");
           
           //se convierte la informacion que esta en html a objeto jquery
           tmp2 = $.parseHTML(tmp);
           console.log(tmp2);
           console.log("nodo jquery");
           console.log($(tmp2).html());
           //de dicha informacion se saca la parte de recurso que no se recopila en el modal de editar
           $(tmp2).find(".recursos").html(recursosdatos);
         //  console.log(tmp2);
//           d[6] = $(tmp2).html();
           console.log(d[6]);
//         d[7]=recursosdatos; 
          // console.log(d);
        //  d.counter++;
 
   datatable
        .row(elemento)
        .data( d )
        .draw(); 
       // Example.show("Se realizo con Exito");
     //   var facultad_id=$(elementocliqueado).data('facultad');

 //Codigo para actualizar automaticamente la pagina..
 
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
      
      
      $("#myWizard").on('actionclicked.fu.wizard', function (evt, data){
        
           //Validación De campos Vacios
           var valid= true;
          // console.log(data);
           if(data.step==1){
          
          var calendario= $('#cal').val(); 
         // console.log(calendario);
          var solicitante= $('#nombre').val();
          console.log(solicitante);
          var facultad= $('#fac').val();
          console.log(facultad);
          var departamento= $('#dep').val();
          console.log(departamento);
          var programa= $('#pro').val();
          console.log(programa);
          var semestre= $('#sem').val();
          console.log(semestre);
          var asignatura= $('#asigna').val();
          console.log(asignatura);
          var grupo= $('#gru').val();
          console.log(grupo);
          var numero_est= $('#num').val();
          console.log(numero_est);
          var practica= $('#nom').val();
          console.log(practica);
          var tipo= $('#tipo').val();
          console.log(tipo);
          var objetivo= $('#obj').val();
          console.log(objetivo);
          var justificacion= $('#jus').val();
          console.log(justificacion);
          var des_docente= $('#adoc').val();
          console.log(des_docente);
          var des_estudiante= $('#est').val();
          console.log(des_estudiante);
          
          //Validación
     
          if(solicitante != "" && facultad != "" && departamento != "" && programa != "" && semestre != "" && asignatura != "" && grupo != "" && numero_est != "" && practica != "" && tipo != "" && objetivo != "" && justificacion != "" && des_docente != "" && des_estudiante != ""){
          //  console.log(); 
            
          }else{
              evt.preventDefault();
               valid = false;
             alert('Por Favor Diligencie los campos'); 
          }
            
          }
          //obtener el numero de dias, apartir de dos fechas..
         // console.log(data);
          if(data.step==2){
              evt.preventDefault();
              var fecha_inicial= $('#sal').val();
              var fecha_input = fecha_inicial.split('/');
              console.log(fecha_input);
              var jqxhr = $.get('/practicas/obtenerverificacioncalendario/', {
                  fecha_inicio : fecha_input[2]+'-'+fecha_input[1]+'-'+fecha_input[0]
              });
              
              jqxhr.done(function(data){
                 if(data != null){
                    if(data.length == 0){
                        //fecha no es valida
                        
                        valid = false;
                        alert('Las fechas de la práctica estan por fuera del calendario activo');
                    } 
                    else{
                        //fecha es valida
             var fecha_final= $('#lle').val();
             var dias= practicas.calcularDias(fecha_inicial, fecha_final)+1;   
             var dias_obj=[];
             localStorage.clear();
//             console.log(dias_obj);
             if(dias > 0 || fecha_inicial == fecha_final){
               console.log(dias);
               //en el caso de editar se puede precargar la informacion a partir de la bd
               var practica_id = $('#practica_id').val();
               
               //si se cambian las fechas
               if(sessionStorage.getItem('fecha_salida_cambia')>0 || sessionStorage.getItem('fecha_llegada_cambia')>0  ){
//                     dias_obj = [];   
                     for(var i=0; i < dias; i++){
                        dias_obj.push({
                        desplazamiento: '',
                        pernoctado: '',
                        ruta: '',
                        docente: '',
                        auxiliar: '',
                        asesor: '',
                        observaciones: '',
                        recursos: ''
                      });
                    }
                    localStorage.setItem('dias_obj', JSON.stringify(dias_obj));
               }
               else{
                   
               
               //si no se cambian las fechas
               var jqxhr = $.get('/practicas/cargardatosprogramacion', {
                   p:practica_id
               });
               
               jqxhr.done(function(data){
                   $.each(data['programaciones'], function(index,val){
                       console.log(val);
                       var tmp_obj = {
                        desplazamiento: val.departamental,
                        pernoctado: val.dias_pernoctados,
                        ruta: val.ruta.ruta+'<input type="hidden" value="'+val.ruta.cod_ruta+'">',
                        docente: '',
                        auxiliar: '',
                        asesor: '',
                        observaciones: val.observaciones,
                        recursosdatos: '',
                        recursos: ''
                      };
                      //auxiliar y asesor
                      $.each(val.participantes, function(ix,va){
                          if(va.tipo_participante == 'asesor'){
                              tmp_obj.asesor = va.nombre + '<input type="hidden" value="'+va.id_participante+'">';
                          }
                          else{
                              if(va.tipo_participante == 'auxiliar'){
                                  tmp_obj.auxiliar = va.nombre + '<input type="hidden" value="'+va.id_participante+'">';
                              }
                          }
                      });
                      //recursos
                      var tmp_rn = [];
                      var tmp_rids = [];
                      $.each(val.recursos, function(idx,v){
                         tmp_rn.push(v.id_recursos.nombre);  
                         tmp_rids.push(v.id_pro);  
                      });
                      tmp_obj.recursosdatos = tmp_rn.join(',')+'<input type="hidden" value="'+tmp_rids.join(',')+'">'
                       dias_obj.push(tmp_obj);
                   });
                   localStorage.setItem('dias_obj', JSON.stringify(dias_obj));
                
                   console.log(dias_obj);
               });
             }
            
             //guardo los datos en el LocalStorage
           
               
           }else{
               valid = false;
             alert('Las fechas son incorrectas'); 
           } 
           
           var lugar= $('#lug').val();
           if(lugar != ""){
               
           }else{
               evt.preventDefault();
               valid= false;
               alert('Por favor ingrese el lugar de encuentro'); 
           }
          // console.log(fecha_final);
           
        var convertir= new Date(fecha_inicial)
          // console.log(convertir);
            var fecha= practicas.sumaFecha(1, fecha_inicial);
          //  console.log(fecha);
            var tmp= fecha_final;
            if(fecha_inicial == fecha_final){
                dias = 1;
            }
            for(i=0; i< dias; i++){
             if(i==0){
               
             } else{
                lugar= "";  
             } 
             console.log(dias-1);
            
             if(i == (dias-1)){
              fecha_final= tmp;   
                 
             }else{
                 fecha_final= "";
             }
             //en esta seccion se cargan los datos de las programaciones en vez de cargarlas en blanco
             
             if(sessionStorage.getItem('fecha_salida_cambia')>0 || sessionStorage.getItem('fecha_llegada_cambia')>0  ){
               
              if(fecha_inicial == fecha_final){
              datatable.row.add ([
              i+1,
              "",
              fecha_inicial,
              lugar,
              "",
             fecha_final,
            
          '<td><a class="editar_prog" href="#"><i class="fa fa-pencil-square-o" style="font-size:18px;color:#563d7c;cursor:pointer;"></i></a> <a class="par" href="#"><i class="fa fa-user-plus" style="font-size:18px;color:#337ab7;cursor:pointer;"></i></a> <a class="editar_recur" href="#"><i class="fa fa-pencil-square-o"  style="font-size:18px;color:#21b384;cursor:pointer;"></i></a> <a class="eliminar_practica" data-practica="" href="#"><i class="" style="font-size:18px;color:#d9534f;cursor:pointer;"></i></a> </td>'    
             ]).draw();
             }
             else{
                 datatable.row.add ([
              i+1,
              "",
              practicas.sumaFecha(i, fecha_inicial),
              lugar,
              "",
             fecha_final,
          '<td><a class="editar_prog" href="#"><i class="fa fa-pencil-square-o" style="font-size:18px;color:#563d7c;cursor:pointer;"></i></a> <a class="par" href="#"><i class="fa fa-user-plus" style="font-size:18px;color:#337ab7;cursor:pointer;"></i></a> <a class="editar_recur" href="#"><i class="fa fa-pencil-square-o"  style="font-size:18px;color:#21b384;cursor:pointer;"></i></a> <a class="eliminar_practica" data-practica="" href="#"><i class="" style="font-size:18px;color:#d9534f;cursor:pointer;"></i></a> </td>'    
             ]).draw();
             }
            }
             
//           dias_obj.push(tmp_obj);
            }
            //si las fechas cambian
            if(sessionStorage.getItem('fecha_salida_cambia')>0 || sessionStorage.getItem('fecha_llegada_cambia')>0  ){
//                localStorage.setItem('dias_obj',dias_obj);
            }
            else{               
           
            
            //si lasfechas no cambian
             var jqxhr = $.get('/practicas/cargardatosprogramacion', {
                   p:practica_id
               });
               
               jqxhr.done(function(data){
                   $.each(data.programaciones, function(i,v){                      
                   console.log("agregando programaciones");
                   console.log("programacion " +i);
                   console.log("valor ");
                   console.log(v);
                   if(fecha_inicial == fecha_final){
                    datatable.row.add ([
                    i+1,
                    v.ruta.ruta,
                    fecha_inicial,
                    lugar,
                    v.dias_pernoctados,
                   fecha_final,

                '<td><a class="editar_prog" href="#"><i class="fa fa-pencil-square-o" style="font-size:18px;color:#563d7c;cursor:pointer;"></i></a> <a class="par" href="#"><i class="fa fa-user-plus" style="font-size:18px;color:#337ab7;cursor:pointer;"></i></a> <a class="editar_recur" href="#"><i class="fa fa-pencil-square-o"  style="font-size:18px;color:#21b384;cursor:pointer;"></i></a> <a class="eliminar_practica" data-practica="" href="#"><i class="" style="font-size:18px;color:#d9534f;cursor:pointer;"></i></a> </td>'    
                   ]).draw();
                   }
                   else{
                       datatable.row.add ([
                    i+1,
                    v.ruta.ruta,
                    practicas.sumaFecha(i, fecha_inicial),
                    lugar,
                    v.dias_pernoctados,
                   fecha_final,
                '<td><a class="editar_prog" href="#"><i class="fa fa-pencil-square-o" style="font-size:18px;color:#563d7c;cursor:pointer;"></i></a> <a class="par" href="#"><i class="fa fa-user-plus" style="font-size:18px;color:#337ab7;cursor:pointer;"></i></a> <a class="editar_recur" href="#"><i class="fa fa-pencil-square-o"  style="font-size:18px;color:#21b384;cursor:pointer;"></i></a> <a class="eliminar_practica" data-practica="" href="#"><i class="" style="font-size:18px;color:#d9534f;cursor:pointer;"></i></a> </td>'    
                   ]).draw();
                   }
                   });
               });
                }
            $('#myWizard').wizard('selectedItem', {
                                step: 3
                                
                            });
                    }
                 }
                 else{
                     //fecha no es valida
                     evt.preventDefault();
                        valid = false;
                        alert('Las fechas de la práctica estan por fuera del calendario activo');
                 }
                
              });
           //fin jqxhr
          
            //fin step 2
          }
          else{
              if(data.step==3){
                  $('#rep_cal').html($('#cal option:selected').html());
                  $('#rep_docente').html($('#nombre').val());
                  $('#rep_asig').html($('#asigna option:selected').html());
                  $('#rep_gru').html($('#gru option:selected').html());
                  $('#rep_numest').html($('#num').val());
                  $('#rep_nompr').html($('#nom').val());
                  $('#rep_obj').html($('#obj').val());
                  $('#rep_just').html($('#jus').val());
                  $('#rep_actdoc').html($('#adoc').val());
                  $('#rep_actest').html($('#est').val());
                  $('#rep_tipopr').html($('#tipo').val());
                  $('#rep_fsal').html($('#sal').val());
                  $('#rep_flleg').html($('#lle').val());
                  $('#rep_lugar').html($('#lug').val());
                  
                  var tmp = $('#example').clone();
                  tmp.prop('id', 'rep_table');
                  tmp.DataTable();
                  $('#rep_tbl').append(tmp);
                  
              }
              if(data.step == 3){
                  if(data.direction == "previous"){
                      if(confirm("Esta operación eliminará la programación ingresada, ¿desea continuar?")){
                          datatable.clear().draw();
                          $('#myWizard').wizard('selectedItem', {
                                step: 3
                                
                            });
                      }
                      
                  } 
              }
              
              if(data.step == 4){
              if(data.direction == "previous"){
              if(confirm("Esta operación eliminará la programación ingresada, ¿desea continuar?")){    
              //var rep_tab= $('#rep_table').DataTable();
              $('#rep_table').html('');
              //rep_tab.clear().draw();
              datatable.clear().draw();
              $('#myWizard').wizard('selectedItem', { 
                   step:2
              
                      });
                  }
              }    
                  
              }
          }
      });   
          
   
          
      
         
    //Validación de que los campos no se vayan vacios
    $( "#myWizard" ).on('finished.fu.wizard', function(){
       
   //un ejemplo de como extraer los datos de la tabla datatable
     datatable.rows().data();
    //si lo usas en la tabla de recursos te va a devolver los recursos almacenados
     // console.log(datatable.data().toArray());
      //declaro una variable para conocer la pocisión del vector a donde estan los id de participantes
      var programacion= datatable.data().toArray();
      console.log(programacion);
    var dias_obj = localStorage.getItem('dias_obj');
    dias_obj = JSON.parse(dias_obj);
    /*
     * Posicion     Corresponde a
     * 0            Num dias
     * 1            Recorrido (Extraer id)
     * 2            Fecha salida
     * 3            Lugar
     * 4            Pernoctado
     * 5            Fecha llegada
     * 
     * 6            Asesor (Extraer id)
     * 7            Auxiliar (Extraer id)
     * 8            Desplazamiento
     * 9            Observaciones
     * 10           Pernoctado
     * 11           Recursos (Extraer ids)
     * 12           Ruta
     */
      for(var i=0; i< programacion.length;i++){
          programacion[i][1]= programacion[i][1].substring(programacion[i][1].indexOf('value=')+6).replace('>', "");
         // console.log(programacion[i][1]);
          programacion[i][6] = dias_obj[i]['asesor'].substring(dias_obj[i]['asesor'].indexOf('value=')+6).replace('>', "");
          programacion[i][7] = dias_obj[i]['auxiliar'].substring(dias_obj[i]['auxiliar'].indexOf('value=')+6).replace('>', "");
          programacion[i][8] = dias_obj[i]['desplazamiento'];
          programacion[i][9] = dias_obj[i]['observaciones'];
          programacion[i][10] = dias_obj[i]['pernoctado'];
        //  programacion[i][11] = dias_obj[i]['recursosdatos'].substring(dias_obj[i]['recursosdatos'].indexOf('value=')+6).replace('>', "");
         // console.log(programacion[i][11]);
          programacion[i][12] = dias_obj[i]['ruta'].substring(dias_obj[i]['ruta'].indexOf('value=')+6).replace('>', "");

//          programacion[i][8]= programacion[i][8].substring(programacion[i][8].indexOf('value=')+6).replace('>', "");
//          programacion[i][9]= programacion[i][9].substring(programacion[i][9].indexOf('value=')+6).replace('>', "");
//          programacion[i][10]= programacion[i][10].substring(programacion[i][10].indexOf('value=')+6).replace('>', "");
        //  console.log(programacion);
         if(programacion[i][11] != null){
            programacion[i][11] = dias_obj[i]['recursosdatos'].substring(dias_obj[i]['recursosdatos'].indexOf('value=')+6).replace('>', ""); 
           } 
      }
     
      //console.log(programacion);
       // console.log('Hola Kami');
       //validación del paso1 corresponde al formulario de prácticas
       
        //Con esta variable le paso los datos del formulario en un vector
     var datos = $('#pra').serialize();
     console.log(datos);
     //campos para validar
    
    // alert(datos); 
    //Mensaje de Confirmación 
    $(document).on('click', '#final', function(e){
  //No se comporte por defecto viene, de mandarme a otra pagina  
  e.preventDefault(); 
   //Elemento cliqueado
 var elementocliqueado= this;
 //console.log('HOla'); 
    bootbox.dialog({
  message: "La Práctica se envió a la Logística",
  title: "Práctica se guardo con exito",
  buttons: {
    default: {
      label: "Aceptar",
      className: "btn-default",
      callback: function() {
       // Example.show("Se realizo con Exito");
       
// console.log(facultad_id);
var practica_id = $('#practica_id').val();
 var ajax= $.post('/practicas/guardarpractica', {datos:datos, programacion:programacion, id: practica_id});
  // Codigo para actualizar la facultad cuando se agrega una nueva facultad..
  ajax.done(function(){
     alert('la Práctica se Guardo Con Exito');
//     window.location='/practicas/listarpractica';
  }); 
 
 //Codigo para actualizar automaticamente la pagina.
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
    
   });
    
}
practicas.isValidDate= function (day,month,year){
		var dteDate;
		month=month-1;
		dteDate=new Date(year,month,day);
		return ((day==dteDate.getDate()) && (month==dteDate.getMonth()) && (year==dteDate.getFullYear()));
	}
 
	/**
	 * Funcion para validar una fecha
	 * Tiene que recibir:
	 *  La fecha en formato español dd/mm/yyyy
	 * Devuelve:
	 *  true o false
	 */
 practicas.validate_fecha= function (fecha){
		var patron=new RegExp("^([0-9]{1,2})([/])([0-9]{1,2})([/])(19|20)+([0-9]{2})$");
 
		if(fecha.search(patron)==0){
			var values=fecha.split("/");
			if(practicas.isValidDate(values[0],values[1],values[2])){
				return true;
			}
		}
		return false;
	}
 
 practicas.calcularDias= function(fechaInicial, fechaFinal){
		
		var resultado="";
		if(practicas.validate_fecha(fechaInicial) && practicas.validate_fecha(fechaFinal)){
			inicial=fechaInicial.split("/");
			final=fechaFinal.split("/");
			// obtenemos las fechas en milisegundos
			var dateStart=new Date(inicial[2],(inicial[1]-1),inicial[0]);
            var dateEnd=new Date(final[2],(final[1]-1),final[0]);
            console.log(dateStart - dateEnd);
            console.log(dateStart);
            console.log(dateEnd);
            if(dateStart<dateEnd)
            {
				// la diferencia entre las dos fechas, la dividimos entre 86400 segundos
				// que tiene un dia, y posteriormente entre 1000 ya que estamos
				// trabajando con milisegundos.
				resultado=(((dateEnd-dateStart)/86400)/1000);
			}else{
                            if(dateStart - dateEnd == 0){
                                resultado = 1;
                            }
                            else{
                                resultado="La fecha inicial es posterior a la fecha final";
                            }
				
			}
		}else{
                    if(dateStart - dateEnd == 0){
                                resultado = 1;
                            }
                           
			if(!practicas.validate_fecha(fechaInicial))
				resultado="La fecha inicial es incorrecta";
			if(!practicas.validate_fecha(fechaFinal))
				resultado="La fecha final es incorrecta";
		}
		return resultado;
    }
  practicas.sumaFecha = function(d, fecha){
 var Fecha = new Date();
 var sFecha = fecha || (Fecha.getDate() + "/" + (Fecha.getMonth() +1) + "/" + Fecha.getFullYear());
 var sep = sFecha.indexOf('/') != -1 ? '/' : '-'; 
 var aFecha = sFecha.split(sep);
 var fecha = aFecha[2]+'/'+aFecha[1]+'/'+aFecha[0];
 fecha= new Date(fecha);
 fecha.setDate(fecha.getDate()+parseInt(d));
 var anno=fecha.getFullYear();
 var mes= fecha.getMonth()+1;
 var dia= fecha.getDate();
 mes = (mes < 10) ? ("0" + mes) : mes;
 dia = (dia < 10) ? ("0" + dia) : dia;
 var fechaFinal = dia+sep+mes+sep+anno;
 return (fechaFinal);
 }
/**  practicas.editarpractica = function(){
    //Creo una variable que me guarde el dato de la facultad para este caso el id..   
   var calendario= $('#cal').data('calendario');   
 
      $('#cal').val(calendario);
    //Se actualice el valor del selector cuando elija un programa que este asociado a su facultad.
    $('#cal').trigger('change'); 
   var datos = $('#pra').serialize();
    // alert(datos); 
    //Mensaje de Confirmación 
     $('#final').on('click', function(){
     
     var id=$('#cod_practica').val();
// console.log(facultad_id);
       
 var programacion = "";
 var ajax= $.post('/practicas/actualizarpractica', {datos:datos, programacion:programacion, id:id});
  // Codigo para actualizar la facultad cuando se agrega una nueva facultad..
  ajax.done(function(){
    //  alert('la Práctica se Guardo Con Exito');
    // window.location='/practicas/listarpractica';
  });
 
   
    });
      
} */


practicas.eliminarpractica = function(){
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





