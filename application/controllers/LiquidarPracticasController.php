<?php


class LiquidarPracticasController extends Zend_Controller_Action {
    
   // Entity Manager
    private $em;
    
 public function init()
    {
        // Activar el Entity Manager
        $registry = Zend_Registry::getInstance();
        $this->em = $registry->entitymanager;
        
         $this->_helper->layout->setLayout('admin');
         $this->view->headLink()->appendStylesheet('/font-awesome/css/font-awesome.css');
         $this->view->headLink()->appendStylesheet('/css/facultad.css');
        
    }

    public function indexAction()
    {
       // para que todo lo que este dentro de este metodo se ejecute en todas las Vistas..
    }
    public function liquidarpracticaAction(){
           
    //metodo para liquidar docente responsable
    //preparo la consulta para hacer la liquidación de práctica ....
       $cod_practica= $this->_getParam('cod_practica');
      // var_dump($cod_practica);
       $dql ="select pro, r, p, re from Application_Model_Programacion pro left join pro.ruta r join pro.cod_practica p left join pro.recursos re where pro.cod_practica=:practica";
      // var_dump($dql);
        // Ejecutar el Query, la variable query es donde se carga la consulta.
        $query = $this->em->createQuery($dql);
        
        $query->setParameter('practica', $cod_practica);
        
        //Resultados de la consulta en un Vector, en este caso en Array
        $programacion = $query->getArrayResult();
        
        //Pasarle a la Vista la informción de la facultad
        $this->view->programacion= $programacion; 
       //  var_dump($programacion);
        $this->view->cod_practica= $cod_practica;
       // var_dump($cod_practica);
        
        
        $dql2="select p, cal, liq from Application_Model_Practicas p join p.id_calendario cal left join p.liquidarpractica liq";
        
        $query2 = $this->em->createQuery($dql2);
        
        //Resultados de la consulta en un Vector, en este caso en Array
        $practicas = $query2->getArrayResult();   
        //Pasarle a la Vista la informción a listar práctica
        $this->view->practicas= $practicas;
       // var_dump($practicas);
         
        
      //  Preparo la Consulta de hallar los recursos
        //Creo una variable que me guarde el total de la practica...
        $total_liquidacion= 0;
        //creo una variable que guarde el viatico del docente..
        $valor_docente = 0;
        //variable del auxilio del estudiante..
       $auxilio_est= 0;
       // var_dump($auxilio_est);
     // Creo una variable para guardar el valor de los recursos
      
    
        if($programacion[0]['ruta']['sitio']== 'Municipio'){
        if(count($programacion)== 1){
           $valor_docente= 51709;
          
        if($programacion[0]['ruta']['sitio']== 'Departamento') {
            if(count($programacion)== 1){
                $valor_docente= 79250;
               
            }else{
              $valor_docente=(count($programacion)* 158574)- 79250; 
             // $auxilio_est=(count($programacion)* 31025)- 31025;
            }     
        }  
        }
         }else{
            $valor_docente=(count($programacion)* 103418)- 51709;
           
        }
         //le paso el dato a la vista
         $this->view->valor_docente= $valor_docente;
       //  var_dump($valor_docente);
        // condicional de los auxilio de estudiantes
         //creo un ciclo que me cuente el numero de dias
         
         $cont = 0;
         foreach ($programacion as $dias){
           //  var_dump($dias['dias_pernoctados']);
             if($dias['dias_pernoctados']== 'No'){
                
             $auxilio_est= 0;
             }else {
              if($dias['dias_pernoctados']== 'Si'){
              $auxilio_est= 31025;
              $auxilio_est= ($auxilio_est) * ($dias['cod_practica']['num_estudiantes']);
                      
            //  var_dump($auxilio_est); 
              $cont = ($cont) + ($auxilio_est);
             // var_dump($cont);
              }   
                 
             }
             
         }
          
        $this->view->auxilio_est= $cont;
       // var_dump($cont);
        
         $total_recursos= 0;
      // var_dump($valor_recursos);
        // $recursos= array();
        $recusos_programados= 0;
        // var_dump($recursos);
        // realizo un ciclo
       
           foreach ($programacion as $pro){
          
            foreach ($programacion[$recusos_programados]['recursos'] as $recursos){
              $recusos_programados++;
//            
             $total_recursos= $recursos['valor'] + $total_recursos;
            
            }
           
          
        } 
      
         $this->view->total_recursos = $total_recursos;   
       
        
        //calculo los valores
       $total_liquidacion= $valor_docente + $auxilio_est + $total_recursos;  
       
       //var_dump($total_liquidacion);
        
          
    
     $this->view->headLink()->appendStylesheet('/css/bootstrap-datepicker.min.css'); 
     $this->view->headLink()->appendStylesheet('/css/fuelux.min.css'); 
     $this->view->headLink()->appendStylesheet('/css/jquery.dataTables.min.css');
     $this->view->headLink()->appendStylesheet('/font-awesome/css/font-awesome.css');
     $this->view->headLink()->appendStylesheet('/css/facultad.css');
//     $this->view->headLink()->appendStylesheet('/css/bootstrap-datepicker.css.map');
     $this->view->headScript()->appendFile('/js/fuelux.min.js');
     $this->view->headScript()->appendFile('/js/wizard.js');
     $this->view->headScript()->appendFile('/bootstrap/js/moment.min.js');   
     $this->view->headScript()->appendFile('/bootstrap/js/bootstrap-datepicker.js');      
     $this->view->headScript()->appendFile('/bootstrap/js/datepicker.es.min.js');
     $this->view->headScript()->appendFile('/js/jquery.dataTables.min.js');
     $this->view->headScript()->appendFile('/js/bootstrap-modal.js');
     $this->view->headScript()->appendFile('/js/practica.js');
     $this->view->headScript()->appendFile('/admin/liquidarpractica.js');
     $this->view->headScript()->appendFile('/validacion/jquery.validate.min.js');
     $this->view->headScript()->appendFile('/validacion/localization/messages_es.min.js');
     $this->view->headScript()->appendFile('/validacion/additional-methods.min.js');    
    }
    
     public function listarliquidarAction() { 
      try {
        $cod_practica= $this->_getParam('cod_practica');
        $dql= "select l, pra from Application_Model_LiquidarPractica l join l.cod_practica pra  where l.cod_practica=:practica";
        
        $query = $this->em->createQuery($dql);
         $query->setParameter('practica', $cod_practica);
        
        $liquidarpractica = $query->getArrayResult();
        
        $this->view->liquidarpractica= $liquidarpractica;
       // var_dump($liquidarpractica);
         $this->view->cod_practica= $cod_practica;
         // var_dump($cod_practica);
       
        
       $dql1 ="select pro, r, p, re from Application_Model_Programacion pro left join pro.ruta r join pro.cod_practica p left join pro.recursos re where pro.cod_practica=:practica";
        
        // Ejecutar el Query, la variable query es donde se carga la consulta.
        $query1 = $this->em->createQuery($dql1);
        
        $query1->setParameter('practica', $cod_practica);
        
        //Resultados de la consulta en un Vector, en este caso en Array
        $programacion = $query1->getArrayResult();
        
        //Imprimir en la pagina lo que esta en la variable en este caso facultades
       // var_dump($facultades);
        //Pasarle a la Vista la informción de la facultad
        $this->view->programacion= $programacion; 
        //var_dump($programacion);
       
             
         } catch (Exception $ex) {
            echo $ex->getMessage(); 
         }
       // var_dump($cod_practica);
        
        
        
        
        
      //  Preparo la Consulta de hallar los recursos
        //Creo una variable que me guarde el total de la practica...
        $total_liquidacion= 0;
        //creo una variable que guarde el viatico del docente..
        $valor_docente = 0;
        //variable del auxilio del estudiante..
       $auxilio_est= 0;
       // var_dump($auxilio_est);
     // Creo una variable para guardar el valor de los recursos
      
    
        if($programacion[0]['ruta']['sitio']== 'Municipio'){
        if(count($programacion)== 1){
           $valor_docente= 51709;
         //  var_dump($valor_docente);
          
        if($programacion[0]['ruta']['sitio']== 'Departamento') {
            if(count($programacion)== 1){
                $valor_docente= 79250;
              //  var_dump($valor_docente);
               
            }else{
              $valor_docente=(count($programacion)* 158574)- 79250; 
             // $auxilio_est=(count($programacion)* 31025)- 31025;
            }     
        }  
        }
         }else{
            $valor_docente=(count($programacion)* 103418)- 51709;
           
        }
         //le paso el dato a la vista
         $this->view->valor_docente= $valor_docente;
        // var_dump($valor_docente);
        // condicional de los auxilio de estudiantes
         $cont = 0;
         foreach ($programacion as $dias){
           //  var_dump($dias['dias_pernoctados']);
             if($dias['dias_pernoctados']== 'No'){
                
             $auxilio_est= 0;
             }else {
              if($dias['dias_pernoctados']== 'Si'){
              $auxilio_est= 31025;
              $auxilio_est= ($auxilio_est) * ($dias['cod_practica']['num_estudiantes']);
                      
            //  var_dump($auxilio_est); 
              $cont = ($cont) + ($auxilio_est);
             // var_dump($cont);
              }   
                 
             }
             
         }
          
        $this->view->auxilio_est= $cont;
       // var_dump($cont);
         
   
       
         $total_recursos= 0;
      // var_dump($valor_recursos);
        // $recursos= array();
        $recusos_programados= 0;
        // var_dump($recursos);
        // realizo un ciclo
       
           foreach ($programacion as $pro){
          
            foreach ($programacion[$recusos_programados]['recursos'] as $recursos){
              $recusos_programados++;
//             var_dump($recursos['valor']);
             $total_recursos= $recursos['valor'] + $total_recursos;
            // var_dump($recursos['valor']);
            
            }
           
          
        } 
      //   var_dump($total_recursos);
         $this->view->total_recursos = $total_recursos;   
       
        // Hago un ciclo
        //calculo los valores
       $total_liquidacion= ($valor_docente) + ($cont) + ($total_recursos);  
       
      // var_dump($total_liquidacion);
        
      $this->view->total_liquidacion= $total_liquidacion;
      // var_dump($total_liquidacion); 
    
      
      $this->view->headLink()->appendStylesheet('/css/jquery.dataTables.min.css');
      $this->view->headLink()->appendStylesheet('/font-awesome/css/font-awesome.css');
      $this->view->headLink()->appendStylesheet('/css/facultad.css');
      $this->view->headScript()->appendFile('/js/jquery.dataTables.min.js');
      $this->view->headScript()->appendFile('/js/facultad.js');
      $this->view->headScript()->appendFile('/js/bootstrap-modal.js');
      $this->view->headScript()->appendFile('/admin/liquidarpractica.js');
      $this->view->headScript()->appendFile('/validacion/jquery.validate.min.js');
      $this->view->headScript()->appendFile('/validacion/localization/messages_es.min.js');
      $this->view->headScript()->appendFile('/validacion/additional-methods.min.js');
      $this->view->headScript()->appendFile('/validacion/bootbox.min.js');
      
    }
    public function listarliquidacionAction(){
      $this->_helper->layout->setLayout('financiera'); 
     
        $dql= "select l, pra from Application_Model_LiquidarPractica l join l.cod_practica pra";
        
        $query = $this->em->createQuery($dql);
        
        $liquidarpractica = $query->getArrayResult();
        
        $this->view->liquidarpractica= $liquidarpractica;
       // var_dump($liquidarpractica);
        
       // $cod_practica= $this->_getParam('cod_practica');
        
       
       $dql1 ="select pro, r, p, re from Application_Model_Programacion pro join pro.ruta r join pro.cod_practica p join pro.recursos re";
        
        // Ejecutar el Query, la variable query es donde se carga la consulta.
        $query1 = $this->em->createQuery($dql1);
        
      //  $query1->setParameter('practica', $cod_practica);
        // $this->view->cod_practica= $cod_practica;
        //Resultados de la consulta en un Vector, en este caso en Array
        $programacion = $query1->getArrayResult();
        
        //Imprimir en la pagina lo que esta en la variable en este caso facultades
       // var_dump($facultades);
        //Pasarle a la Vista la informción de la facultad
        $this->view->programacion= $programacion; 
       //var_dump($programacion);
         $cod= $this->_getParam('cod');
        $dql4= "select l, pra from Application_Model_LiquidarPractica l join l.cod_practica pra  where l.cod_practica=:practica";
        
        $query4 = $this->em->createQuery($dql4);
         $query4->setParameter('practica', $cod);
        
        $cod_practica = $query->getArrayResult();
        
       // $this->view->liquipractica= $liquipractica;
       // var_dump($liquidarpractica);
         $this->view->cod_practica= $cod_practica;
        // var_dump($cod_practica);
        
       
        //  $this->view->programacion= $programacion; 
       // var_dump($programacion);      
      //  Preparo la Consulta de hallar los recursos
        //Creo una variable que me guarde el total de la practica...
        $total_liquidacion= 0;
        //creo una variable que guarde el viatico del docente..
        $valor_docente = 0;
        //variable del auxilio del estudiante..
       $auxilio_est= 0;
       // var_dump($auxilio_est);
     // Creo una variable para guardar el valor de los recursos
      
  
        if($programacion[0]['ruta']['sitio']== 'Municipio'){
       //  var_dump($programacion);
        if(count($programacion)== 1){
           $valor_docente= 51709;
          
        if($programacion[0]['ruta']['sitio']== 'Departamento') {
            if(count($programacion)== 1){
                $valor_docente= 79250;
               
            }else{
              $valor_docente=(count($programacion)* 158574)- 79250; 
             // $auxilio_est=(count($programacion)* 31025)- 31025;
            }     
        }  
        }
         }else{
            $valor_docente=(count($programacion)* 103418)- 51709;
           
        }
         //le paso el dato a la vista
         $this->view->valor_docente= $valor_docente;
       // condicional de los auxilio de estudiantes
         $cont = 0;
         foreach ($programacion as $dias){
           //  var_dump($dias['dias_pernoctados']);
             if($dias['dias_pernoctados']== 'No'){
                
             $auxilio_est= 0;
             }else {
              if($dias['dias_pernoctados']== 'Si'){
              $auxilio_est= 31025;
              $auxilio_est= ($auxilio_est) * ($dias['cod_practica']['num_estudiantes']);
                      
            //  var_dump($auxilio_est); 
              $cont = ($cont) + ($auxilio_est);
             // var_dump($cont);
              }   
                 
             }
             
         }
          
        $this->view->auxilio_est= $cont;
       // var_dump($cont);
         
   
       
         $total_recursos= 0;
      // var_dump($valor_recursos);
        // $recursos= array();
        $recusos_programados= 0;
        // var_dump($recursos);
        // realizo un ciclo
       
           foreach ($programacion as $pro){
          
            foreach ($programacion[$recusos_programados]['recursos'] as $recursos){
              $recusos_programados++;
//             var_dump($recursos['valor']);
             $total_recursos= $recursos['valor'] + $total_recursos;
            
            }
           
          
        } 
      //   var_dump($total_recursos);
         $this->view->total_recursos = $total_recursos;   
       
        // Hago un ciclo
        //calculo los valores
       $total_liquidacion= ($valor_docente) + ($cont) + ($total_recursos);  
       // var_dump($total_liquidacion);
        
      $this->view->total_liquidacion= $total_liquidacion;
        
    
      
      $this->view->headLink()->appendStylesheet('/css/jquery.dataTables.min.css');
      $this->view->headLink()->appendStylesheet('/font-awesome/css/font-awesome.css');
      $this->view->headLink()->appendStylesheet('/css/facultad.css');
      $this->view->headScript()->appendFile('/js/jquery.dataTables.min.js');
      $this->view->headScript()->appendFile('/js/facultad.js');
      $this->view->headScript()->appendFile('/js/bootstrap-modal.js');
      $this->view->headScript()->appendFile('/admin/liquidarpractica.js');
      $this->view->headScript()->appendFile('/validacion/jquery.validate.min.js');
      $this->view->headScript()->appendFile('/validacion/localization/messages_es.min.js');
      $this->view->headScript()->appendFile('/validacion/additional-methods.min.js');
      $this->view->headScript()->appendFile('/validacion/bootbox.min.js');   
    }

    public function guardarliquidarpracticasAction(){
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->layout->disableLayout();
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->viewRenderer->setNoRender(TRUE);
     
     try {
        // $id= $this->_getParam('id'); 
          // Recibo los parametros por ajax
          
        $viatico= $this->_getParam('viatico');
        $estudiantes= $this->_getParam('estudiantes');
        $transporte= $this->_getParam('transporte');
        $estado= $this->_getParam('estado');
        $pagado= $this->_getParam('pagado');
        $legalizado= $this->_getParam('legalizado');
        $fechale= $this->_getParam('fechale');
        $cod_practica= $this->_getParam('cod');
        var_dump($cod_practica);
        //cambio el formato del datetime
        //creo variables fecha pago y nlegalizado
      $fecha_pago= DateTime::createFromFormat('d/m/Y', $pagado);  
      $fecha_legalizado= DateTime::createFromFormat('d/m/Y', $fechale);
        
        $liquidarpractica_objeto= new Application_Model_LiquidarPractica(); 
        $liquidarpractica_objeto->setviaticos($viatico);
        $liquidarpractica_objeto->setaux_estudiante($estudiantes);
        $liquidarpractica_objeto->settransporte_especial($transporte);
        $liquidarpractica_objeto->setestado($estado);
        $liquidarpractica_objeto->setfecha_pago($fecha_pago);
        $liquidarpractica_objeto->setlegalizado($legalizado);
        $liquidarpractica_objeto->setfecha_legalizado($fecha_legalizado);
        $liquidarpractica_objeto->setcod_practica($this->em->getRepository('Application_Model_Practicas')->find($cod_practica));
        
         $this->em->persist($liquidarpractica_objeto);
     //Ejecuta la Orden de guardar..
        $this->em->flush();     
              
        
         
     } catch (Exception $ex) {
         echo $ex->getMessage();
     }
        
        
        
    }
       public function editarliquidacionAction() { 
       $this->_helper->layout->setLayout('financiera'); 
       
     //   $id= $this->_getParam('id_liquidar');
        //var_dump($id);
       
        $dql= "select l from Application_Model_LiquidarPractica l ";
         $query= $this->em->createQuery($dql);
         //Se guarde el id de facultad..
       //  
         //muestre el resultado en un array...
         $liquidar =$query->getArrayResult();
         $this->view->liquidar =$liquidar;
         // var_dump($liquidar);
         
         try {
         $cod= $this->_getParam('cod_practica');
        // var_dump($cod);
         $dql1= "select l, pra from Application_Model_LiquidarPractica l join l.cod_practica pra  where l.cod_practica=:liquidar";
         
         $query1 = $this->em->createQuery($dql1);
         
         $query1->setParameter('liquidar', $cod);
         
         $liquidacion= $query1->getArrayResult();
         
         $this->view->liquidacion =$liquidacion;
       //  var_dump($liquidacion);
             
         } catch (Exception $ex) {
             echo $ex->getMessage(); 
         }
        $dql5= "select p from Application_Model_Practicas p";
        
        $query5 = $this->em->createQuery($dql5);
        
        $practica = $query5->getArrayResult();
        
        $this->view->practica= $practica;
       // var_dump($practica);
        // mostrar el codio de la práctica
        
     $this->view->headLink()->appendStylesheet('/css/bootstrap-datepicker.min.css'); 
     $this->view->headLink()->appendStylesheet('/css/fuelux.min.css'); 
     $this->view->headLink()->appendStylesheet('/css/jquery.dataTables.min.css');
     $this->view->headLink()->appendStylesheet('/font-awesome/css/font-awesome.css');
     $this->view->headLink()->appendStylesheet('/css/facultad.css');
//     $this->view->headLink()->appendStylesheet('/css/bootstrap-datepicker.css.map');
     $this->view->headScript()->appendFile('/js/fuelux.min.js');
     $this->view->headScript()->appendFile('/js/wizard.js');
     $this->view->headScript()->appendFile('/bootstrap/js/moment.min.js');   
     $this->view->headScript()->appendFile('/bootstrap/js/bootstrap-datepicker.js');      
     $this->view->headScript()->appendFile('/bootstrap/js/datepicker.es.min.js');
     $this->view->headScript()->appendFile('/js/jquery.dataTables.min.js');
     $this->view->headScript()->appendFile('/js/bootstrap-modal.js');
     $this->view->headScript()->appendFile('/js/practica.js');
     $this->view->headScript()->appendFile('/admin/liquidarpractica.js');
     $this->view->headScript()->appendFile('/validacion/jquery.validate.min.js');
     $this->view->headScript()->appendFile('/validacion/localization/messages_es.min.js');
     $this->view->headScript()->appendFile('/validacion/additional-methods.min.js'); 
    }
    public function actualizarliquidarpracticasAction(){
          //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->layout->disableLayout();
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->viewRenderer->setNoRender(TRUE);
     
     //Recibir id como parametro
     try {
      $id= $this->_getParam('id');  
     var_dump($id);
     //Se hace un condicional que el id es mayor que cero
     if($id>0){
        
             //Proceso a editar
        $viatico= $this->_getParam('viatico');
        $estudiantes= $this->_getParam('estudiantes');
        $transporte= $this->_getParam('transporte');
        $estado= $this->_getParam('estado');
        $pagado= $this->_getParam('pagado');
        $legalizado= $this->_getParam('legalizado');
        $fechale= $this->_getParam('fechale');
        $cod= $this->_getParam('cod');
        var_dump($cod);
        
        //cambio el formato del datetime
        //creo variables fecha pago y nlegalizado
      $fecha_pago= DateTime::createFromFormat('d/m/Y', $pagado);  
      $fecha_legalizado= DateTime::createFromFormat('d/m/Y', $fechale);
     //var_dump($facultad);
     
     // Almacena en el objecto la facultad que tiene el id..
     $liquidacion_objeto = ($this->em->getRepository('Application_Model_LiquidarPractica')->find($id));
     $liquidacion_objeto->setviaticos($viatico);
     $liquidacion_objeto->setaux_estudiante($estudiantes);
     $liquidacion_objeto->settransporte_especial($transporte);
     $liquidacion_objeto->setestado($estado);
    // var_dump($estado);
     $liquidacion_objeto->setfecha_pago($fecha_pago);
     $liquidacion_objeto->setlegalizado($legalizado);
     $liquidacion_objeto->setfecha_legalizado($fecha_legalizado);
     $liquidacion_objeto->setcod_practica($this->em->getRepository('Application_Model_Practicas')->find($cod));
  /**   $this->em->persist($liquidacion_objeto);
     //Ejecuta la Orden de guardar..
     $this->em->flush();  */
                  
     }
         
     } catch (Exception $ex) {
         echo $ex->getMessage();  
     }
     $this->view->headScript()->appendFile('/admin/liquidarpractica.js');
    }
     
    
}
