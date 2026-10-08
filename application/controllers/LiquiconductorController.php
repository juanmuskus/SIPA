<?php

class LiquiconductorController extends Zend_Controller_Action
{
    // Entity Manager
    private $em;
    private $pw;
    private $ka;

    public function init()
    {
        // Activar el Entity Manager
        $registry = Zend_Registry::getInstance();
        $this->em = $registry->entitymanager;
        $this->pw= $registry->powercampus_connection;
        $this->ka= $registry->kactus_connection;
        
         $this->_helper->layout->setLayout('prueba');
         $this->view->headLink()->appendStylesheet('/font-awesome/css/font-awesome.css');
         $this->view->headLink()->appendStylesheet('/css/facultad.css');
        
    }

    public function indexAction()
    {
       // para que todo lo que este dentro de este metodo se ejecute en todas las Vistas..
    }
    
    public function agregarliquiconductorAction(){ 
         
     
        
        //preparo la consulta para extraer los conductores..
        $dql3= "select c from Application_Model_Conductores c";
        
        $query3= $this->em->createQuery($dql3);
        
        $conductor = $query3->getArrayResult();
        
        $this->view->conductor =$conductor; 
        
        //Preparo la consulta de los vehiculos
        $dql4= "select t from Application_Model_Transporte t";
        
        $query4= $this->em->createQuery($dql4);
        
        $transporte = $query4->getArrayResult();
        
        $this->view->transporte = $transporte;
      //  var_dump($transporte);
        
         $dql5= "select p from Application_Model_Practicas p";
        
        $query5 = $this->em->createQuery($dql5);
        
        $practica = $query5->getArrayResult();
        
        $this->view->practica= $practica;
        
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
     $this->view->headScript()->appendFile('/logistica/liquidarconductor.js');
     $this->view->headScript()->appendFile('/validacion/jquery.validate.min.js');
     $this->view->headScript()->appendFile('/validacion/localization/messages_es.min.js');
     $this->view->headScript()->appendFile('/validacion/additional-methods.min.js');
    }
    public function listarliquiconductorAction(){ 
        
        try {
               // preparo la consulta para  la liquidación de los conductores
        $dql2= "select l, v, c, pra from Application_Model_Liquiconductores l join l.cod_transporte v join l.id_conductor c join l.cod_practica pra";
        
        $query2= $this->em->createQuery($dql2);
        
        $liquidarconductor = $query2->getArrayResult();
        
        $this->view->liquidarconductor= $liquidarconductor;
       // var_dump($liquidarconductor);
        //creo una variable temporal que me almace el total de la liquidación del conductor 
        $total_liquiconductor= array();
        $liquidar= 0;
        //metiendo indice al ciclo $key
        foreach ($liquidarconductor as $key => $liqui){
             //realizo la suma para conocer el valor total
        $total_liquiconductor[$key]= $liqui['combustible'] + $liqui['peajes'] + $liqui['viaticos'] + $liqui['imprevistos'];
        
        $liquidar++;
        }
       
        
       // var_dump($total_liquiconductor);
       $this->view->total_liquiconductor = $total_liquiconductor;
        
     //  var_dump($total_liquiconductor);
        } catch (Exception $ex) {
            $ex->getMessage();
        }
        
       
        
      
      $this->view->headLink()->appendStylesheet('/css/jquery.dataTables.min.css');
      $this->view->headLink()->appendStylesheet('/font-awesome/css/font-awesome.css');
      $this->view->headLink()->appendStylesheet('/css/facultad.css');
      $this->view->headScript()->appendFile('/js/jquery.dataTables.min.js');
      $this->view->headScript()->appendFile('/js/facultad.js');
      $this->view->headScript()->appendFile('/js/bootstrap-modal.js');
      $this->view->headScript()->appendFile('/logistica/liquidarconductor.js');
      $this->view->headScript()->appendFile('/validacion/jquery.validate.min.js');
      $this->view->headScript()->appendFile('/validacion/localization/messages_es.min.js');
      $this->view->headScript()->appendFile('/validacion/additional-methods.min.js');
      $this->view->headScript()->appendFile('/validacion/bootbox.min.js');
      
    }
    //realizo la funcionalidad de finan
public function verliquidacionAction(){
    $this->_helper->layout->setLayout('financiera'); 
    
    try {
               // preparo la consulta para  la liquidación de los conductores
        $dql2= "select l, v, c, pra from Application_Model_Liquiconductores l join l.cod_transporte v join l.id_conductor c join l.cod_practica pra";
        
        $query2= $this->em->createQuery($dql2);
        
        $liquidarconductor = $query2->getArrayResult();
        
        $this->view->liquidarconductor= $liquidarconductor;
       // var_dump($liquidarconductor);
        //creo una variable temporal que me almace el total de la liquidación del conductor 
        $total_liquiconductor= array();
        $liquidar= 0;
        //metiendo indice al ciclo $key
        foreach ($liquidarconductor as $key => $liqui){
             //realizo la suma para conocer el valor total
        $total_liquiconductor[$key]= $liqui['combustible'] + $liqui['peajes'] + $liqui['viaticos'] + $liqui['imprevistos'];
        
        $liquidar++;
        }
       
        
       // var_dump($total_liquiconductor);
       $this->view->total_liquiconductor = $total_liquiconductor;
        
     //  var_dump($total_liquiconductor);
        } catch (Exception $ex) {
            $ex->getMessage();
        }
        
       
        
      
      $this->view->headLink()->appendStylesheet('/css/jquery.dataTables.min.css');
      $this->view->headLink()->appendStylesheet('/font-awesome/css/font-awesome.css');
      $this->view->headLink()->appendStylesheet('/css/facultad.css');
      $this->view->headScript()->appendFile('/js/jquery.dataTables.min.js');
      $this->view->headScript()->appendFile('/js/facultad.js');
      $this->view->headScript()->appendFile('/js/bootstrap-modal.js');
      $this->view->headScript()->appendFile('/logistica/liquidarconductor.js');
      $this->view->headScript()->appendFile('/validacion/jquery.validate.min.js');
      $this->view->headScript()->appendFile('/validacion/localization/messages_es.min.js');
      $this->view->headScript()->appendFile('/validacion/additional-methods.min.js');
      $this->view->headScript()->appendFile('/validacion/bootbox.min.js');
    
}
    public function listarproliquiconductorAction(){ 
          // llamo la session
         $authNamespace = new Zend_Session_Namespace('Zend_Auth');
         //saco los datos del usuario
         $usuario= $authNamespace->usuarios;
         $rol= $authNamespace->usuarios[0]['id_rol']['id_rol'];
         
         $this->view->rol= $rol;
         
       
               
        //Consulta dql para listar las facultades
        $dql ="select pro, r, p from Application_Model_Programacion pro join pro.ruta r join pro.cod_practica p";
        
        // Ejecutar el Query, la variable query es donde se carga la consulta.
        $query = $this->em->createQuery($dql);
        
        //Resultados de la consulta en un Vector, en este caso en Array
        $programacion = $query->getArrayResult();
        
        //Imprimir en la pagina lo que esta en la variable en este caso facultades
       // var_dump($facultades);
        //Pasarle a la Vista la informción de la facultad
        $this->view->programacion= $programacion;
       // var_dump($programacion);
             
        
        
        
         $dql="select p, cal from Application_Model_Practicas p join p.id_calendario cal";
        
        $query = $this->em->createQuery($dql);
        
        //Resultados de la consulta en un Vector, en este caso en Array
        $practicas = $query->getArrayResult();   
        //Pasarle a la Vista la informción a listar práctica
        $this->view->practicas= $practicas;
      //  var_dump($practicas);
        
        // quey de docentes
        $docentes= array();
        //CONEXION LOCAL
        $sql = "SELECT VIEW_SIPA.cod_empl AS cod, VIEW_SIPA.ape_empl AS ape, VIEW_SIPA.nom_empl AS nom, VIEW_SIPA.tel_empl AS tel FROM KACTUS.dbo.VIEW_SIPA WHERE cod_empl= ?";
      //  $sql = "SELECT DISTINCT KACTUS.dbo.VIEW_SIPA.ape_empl AS ape, KACTUS.dbo.VIEW_SIPA.nom_empl AS nom FROM KACTUS.dbo.VIEW_SIPA ORDER BY ape_empl";
          $stmt = sqlsrv_query( $this->ka, $sql, array($practicas[0]['nom_solicitante']));
          //var_dump($sql);
          while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
              //para quitar las tildes
          $row['cod']= htmlentities(utf8_encode($row['cod']));    
          $row['ape']= htmlentities(utf8_encode($row['ape']));
          $row['nom']= htmlentities(utf8_encode($row['nom']));
          $row['tel']= htmlentities(utf8_encode($row['tel']));
         // $row['Id_Programa']= htmlentities(utf8_encode($row['Id_Programa']));
          $docentes[]= $row;   
         // var_dump($row);
          // $row['ID_Facultad'].", ".$row['Facultad'].", ".$row['Departamento'].", ".$row['Programa'].", ".$row['ID_Departamento']."<br />";
         // var_dump($row);
       }
       sqlsrv_free_stmt( $stmt);
       $this->view->docentes= $docentes; 
      // var_dump($docentes);
        
      
      $this->view->headLink()->appendStylesheet('/css/jquery.dataTables.min.css');
      $this->view->headLink()->appendStylesheet('/font-awesome/css/font-awesome.css');
      $this->view->headLink()->appendStylesheet('/css/facultad.css');
      $this->view->headScript()->appendFile('/js/jquery.dataTables.min.js');
      $this->view->headScript()->appendFile('/js/facultad.js');
      $this->view->headScript()->appendFile('/js/bootstrap-modal.js');
      $this->view->headScript()->appendFile('/logistica/liquidarconductor.js');
      $this->view->headScript()->appendFile('/validacion/jquery.validate.min.js');
      $this->view->headScript()->appendFile('/validacion/localization/messages_es.min.js');
      $this->view->headScript()->appendFile('/validacion/additional-methods.min.js');
      $this->view->headScript()->appendFile('/validacion/bootbox.min.js');
      
    }
    public function listarpracticaAction(){ 
          // llamo la session
         $authNamespace = new Zend_Session_Namespace('Zend_Auth');
         //saco los datos del usuario
         $usuario= $authNamespace->usuarios;
         $rol= $authNamespace->usuarios[0]['id_rol']['id_rol'];
         
         $this->view->rol= $rol;
         
         $dql="select p, cal from Application_Model_Practicas p join p.id_calendario cal";
        
        $query = $this->em->createQuery($dql);
        
        //Resultados de la consulta en un Vector, en este caso en Array
        $practicas = $query->getArrayResult();   
        //Pasarle a la Vista la informción a listar práctica
        $this->view->practicas= $practicas;
      //  var_dump($practicas);
        
        // quey de docentes
        $docentes= array();
        //CONEXION LOCAL
        $sql = "SELECT VIEW_SIPA.cod_empl AS cod, VIEW_SIPA.ape_empl AS ape, VIEW_SIPA.nom_empl AS nom, VIEW_SIPA.tel_empl AS tel FROM KACTUS.dbo.VIEW_SIPA WHERE cod_empl= ?";
      //  $sql = "SELECT DISTINCT KACTUS.dbo.VIEW_SIPA.ape_empl AS ape, KACTUS.dbo.VIEW_SIPA.nom_empl AS nom FROM KACTUS.dbo.VIEW_SIPA ORDER BY ape_empl";
          $stmt = sqlsrv_query( $this->ka, $sql, array($practicas[0]['nom_solicitante']));
          //var_dump($sql);
          while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
              //para quitar las tildes
          $row['cod']= htmlentities(utf8_encode($row['cod']));    
          $row['ape']= htmlentities(utf8_encode($row['ape']));
          $row['nom']= htmlentities(utf8_encode($row['nom']));
          $row['tel']= htmlentities(utf8_encode($row['tel']));
         // $row['Id_Programa']= htmlentities(utf8_encode($row['Id_Programa']));
          $docentes[]= $row;   
         // var_dump($row);
          // $row['ID_Facultad'].", ".$row['Facultad'].", ".$row['Departamento'].", ".$row['Programa'].", ".$row['ID_Departamento']."<br />";
         // var_dump($row);
       }
       sqlsrv_free_stmt( $stmt);
       $this->view->docentes= $docentes; 
      // var_dump($docentes);
        
      
      $this->view->headLink()->appendStylesheet('/css/jquery.dataTables.min.css');
      $this->view->headLink()->appendStylesheet('/font-awesome/css/font-awesome.css');
      $this->view->headLink()->appendStylesheet('/css/facultad.css');
      $this->view->headScript()->appendFile('/js/jquery.dataTables.min.js');
      $this->view->headScript()->appendFile('/js/facultad.js');
      $this->view->headScript()->appendFile('/js/bootstrap-modal.js');
      $this->view->headScript()->appendFile('/logistica/liquidarconductor.js');
      $this->view->headScript()->appendFile('/validacion/jquery.validate.min.js');
      $this->view->headScript()->appendFile('/validacion/localization/messages_es.min.js');
      $this->view->headScript()->appendFile('/validacion/additional-methods.min.js');
      $this->view->headScript()->appendFile('/validacion/bootbox.min.js');
      
    }
    
    public function guardarliquiconductorAction(){
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->layout->disableLayout();
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->viewRenderer->setNoRender(TRUE);
     
     //recibo los datos que se les pasa por petición ajax
     $combustible= $this->_getParam('combustible');
     $peaje= $this->_getParam('peaje');
     $viatico= $this->_getParam('viatico');
     $imprevisto = $this->_getParam('imprevisto');
     $pagado = $this->_getParam('pagado');
     $legalizado= $this->_getParam('legalizado');
     $fechapa= $this->_getParam('fechapa');
     $fechale= $this->_getParam('fechale');
     $conductor= $this->_getParam('conductor');
     $cod_practica= $this->_getParam('cod_practica');
     $vehiculo= $this->_getParam('vehiculo');
     $observacion= $this->_getParam('observacion'); 
     
   
         
      //creo variables fecha pago y nlegalizado
      $fecha_pago= DateTime::createFromFormat('d/m/Y', $fechapa);  
      $fecha_legalizado= DateTime::createFromFormat('d/m/Y', $fechale);
         
     $liquidarconductor_objeto = new Application_Model_Liquiconductores();
     $liquidarconductor_objeto->setcombustible($combustible);
     $liquidarconductor_objeto->setpeajes($peaje);
     $liquidarconductor_objeto->setviaticos($viatico);
     $liquidarconductor_objeto->setimprevistos($imprevisto);
     $liquidarconductor_objeto->setpagado($pagado);
     $liquidarconductor_objeto->setlegalizado($legalizado);
     $liquidarconductor_objeto->setfecha_pago($fecha_pago);
     $liquidarconductor_objeto->setfecha_legalizado($fecha_legalizado);
     $liquidarconductor_objeto->setid_conductor($this->em->getRepository('Application_Model_Conductores')->find($conductor));
     $liquidarconductor_objeto->setcod_practica($this->em->getRepository('Application_Model_Practicas')->find($cod_practica));
     $liquidarconductor_objeto->setcod_transporte($this->em->getRepository('Application_Model_Transporte')->find($vehiculo));        
     $liquidarconductor_objeto->setobservacion($observacion);
   //  var_dump($liquidarconductor_objeto);
     
     $this->em->persist($liquidarconductor_objeto);
     //Ejecuta la Orden de guardar..
     $this->em->flush();   
         
    
        
        
        
    }
     public function editarliquiconductorAction() { 
        $this->_helper->layout->setLayout('financiera');
         
        // preparo la consulta para  la liquidación de los conductores
         $liquidarconductor_id= $this->_getParam('id');
         
        $dql= "select l, v, c, pra from Application_Model_Liquiconductores l join l.cod_transporte v join l.id_conductor c join l.cod_practica pra where l.id=:liquidarconductor";
        
        $query= $this->em->createQuery($dql);
        $query->setParameter('liquidarconductor', $liquidarconductor_id);
        
        $liquidarconductor = $query->getArrayResult();
        
        $this->view->liquidarconductor= $liquidarconductor;
       // var_dump($liquidarconductor);
        
        $dql3= "select c from Application_Model_Conductores c";
        
        $query3= $this->em->createQuery($dql3);
        
        $conductor = $query3->getArrayResult();
        
        $this->view->conductor =$conductor; 
        
         $dql4= "select t from Application_Model_Transporte t";
        
        $query4= $this->em->createQuery($dql4);
        
        $transporte = $query4->getArrayResult();
        
        $this->view->transporte = $transporte;
        
        
         $dql5= "select p from Application_Model_Practicas p";
        
        $query5 = $this->em->createQuery($dql5);
        
        $practica = $query5->getArrayResult();
        
        $this->view->practica= $practica;
         //preparo la consulta para extraer los conductores..
     
         
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
     $this->view->headScript()->appendFile('/logistica/liquidarconductor.js');
     $this->view->headScript()->appendFile('/validacion/jquery.validate.min.js');
     $this->view->headScript()->appendFile('/validacion/localization/messages_es.min.js');
     $this->view->headScript()->appendFile('/validacion/additional-methods.min.js');
     $this->view->headScript()->appendFile('/validacion/bootbox.min.js');
    }
    public function actualizarliquiconductorAction(){
          //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->layout->disableLayout();
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->viewRenderer->setNoRender(TRUE);
     
     try {
          //Recibir id como parametro
     $id= $this->_getParam('id');   
     //Se hace un condicional que el id es mayor que cero
     if($id>0){
      //Proceso a editar
      //recibo los datos que se les pasa por petición ajax
     
     $combustible= $this->_getParam('combustible');
     $peaje= $this->_getParam('peaje');
     $viatico= $this->_getParam('viatico');
     $imprevisto = $this->_getParam('imprevisto');
     $pagado = $this->_getParam('pagado');
     $legalizado= $this->_getParam('legalizado');
     $fechapa= $this->_getParam('fechapa');
     $fechale= $this->_getParam('fechale');
     $condu= $this->_getParam('condu');
   //   var_dump($conductor);
     $practica= $this->_getParam('practica');
     $vehi= $this->_getParam('vehi');
     $observacion= $this->_getParam('observacion'); 
     
     
     // Almacena en el objecto la Liquidardocente que tiene el id..
    //creo variables fecha pago y nlegalizado
      $fecha_pago= DateTime::createFromFormat('d/m/Y', $fechapa);  
      $fecha_legalizado= DateTime::createFromFormat('d/m/Y', $fechale);
         
     $liquidarconductor_objeto = ($this->em->getRepository('Application_Model_Liquiconductores')->find($id));
     $liquidarconductor_objeto->setcombustible($combustible);
     $liquidarconductor_objeto->setpeajes($peaje);
     $liquidarconductor_objeto->setviaticos($viatico);
     $liquidarconductor_objeto->setimprevistos($imprevisto);
     $liquidarconductor_objeto->setpagado($pagado);
     $liquidarconductor_objeto->setlegalizado($legalizado);
     $liquidarconductor_objeto->setfecha_pago($fecha_pago);
     $liquidarconductor_objeto->setfecha_legalizado($fecha_legalizado);
     $liquidarconductor_objeto->setid_conductor($this->em->getRepository('Application_Model_Conductores')->find($condu));
     $liquidarconductor_objeto->setcod_practica($this->em->getRepository('Application_Model_Practicas')->find($practica));
     $liquidarconductor_objeto->setcod_transporte($this->em->getRepository('Application_Model_Transporte')->find($vehi));        
     $liquidarconductor_objeto->setobservacion($observacion);
    // var_dump($liquidarconductor_objeto);
     
    $this->em->persist($liquidarconductor_objeto);
     //Ejecuta la Orden de guardar..
     $this->em->flush(); 
          
         
          }    
         
     } catch (Exception $ex) {
         echo $ex->getMessage();
     }
        $this->view->headScript()->appendFile('/logistica/liquidarconductor.js');
       }
      public function eliminarliquiconductorAction(){
          //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->layout->disableLayout();
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->viewRenderer->setNoRender(TRUE);
     //Recibo el dato por ajax
     try {
     $liquidar_id= $this->_getParam('liquidar_id');  
     
      $liquidarconductor_objeto = ($this->em->getRepository('Application_Model_Liquiconductores')->find($liquidar_id));
     
     // da la orden de guardar
     $this->em->remove($liquidarconductor_objeto);
     
     //Ejecuta la Orden de Guardar
     $this->em->flush();
         
     } catch (Exception $ex) {
     header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
         
     }
           
    }
}



