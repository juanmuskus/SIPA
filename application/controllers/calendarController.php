<?php

class calendarController extends Zend_Controller_Action
{
    // Entity Manager
    private $em;

    public function init()
    {
        
        // Activar el Entity Manager
        $registry = Zend_Registry::getInstance();
        $this->em = $registry->entitymanager;
        
         $this->_helper->layout->setLayout('admin');
         $this->view->headLink()->appendStylesheet('/font-awesome/css/font-awesome.css');
         //$this->view->headLink()->appendStylesheet('/css/facultad.css');
        
    }

    public function indexAction()
    {
       // para que todo lo que este dentro de este metodo se ejecute en todas las Vistas..
    }
    
    public function agregarcalendarAction(){
        
        //Consulta dql para listar los calendarios
      $dql= "select a from Application_Model_Annio a";
      
      $query= $this->em->createQuery($dql);
      
      $annio= $query->getArrayResult();
      
      $this->view->annio= $annio;
      
      //preparo la consulta dql, para obtener el periodo
      $dql1= "select p from Application_Model_Periodo p";
      
      $query1= $this->em->createQuery($dql1);
      
      $periodo= $query1->getArrayResult();
      
      $this->view->periodo= $periodo;
      
     
        
         //Enlaces    
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
     $this->view->headScript()->appendFile('/admin/calendario.js');
     $this->view->headScript()->appendFile('/validacion/jquery.validate.min.js');
     $this->view->headScript()->appendFile('/validacion/localization/messages_es.min.js');
     $this->view->headScript()->appendFile('/validacion/additional-methods.min.js');
        
    }

    public function listarcalendarAction()
    { 
         //Consulta dql para listar los calendarios
        $dql ="select c, a, p from Application_Model_calendar c left join c.id_annio a left join c.id_periodo p";
        //var_dump($dql);
        // Ejecutar el Query, la variable query es donde se carga la consulta.
        $query = $this->em->createQuery($dql);
        
        //Resultados de la consulta en un Vector, en este caso en Array
        $calendario = $query->getArrayResult();
        
        
        $this->view->calendario= $calendario;
       
        
      //Los Enlaces
      $this->view->headLink()->appendStylesheet('/css/jquery.dataTables.min.css');
      $this->view->headLink()->appendStylesheet('/font-awesome/css/font-awesome.css');
      $this->view->headLink()->appendStylesheet('/css/facultad.css');
      $this->view->headScript()->appendFile('/js/jquery.dataTables.min.js');
      $this->view->headScript()->appendFile('/js/facultad.js');
      $this->view->headScript()->appendFile('/js/bootstrap-modal.js');
      $this->view->headScript()->appendFile('/admin/calendario.js');
      $this->view->headScript()->appendFile('/validacion/jquery.validate.min.js');
      $this->view->headScript()->appendFile('/validacion/localization/messages_es.min.js');
      $this->view->headScript()->appendFile('/validacion/additional-methods.min.js');
      $this->view->headScript()->appendFile('/validacion/bootbox.min.js');
      
    }
    public function guardarcalendarAction(){
    //  header('Content-Type: application/json');    
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->layout->disableLayout();
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->viewRenderer->setNoRender(TRUE);
     
      //Preparo la consulta dql, para obtener el calendario activo
      
      $dql= "select a from Application_Model_calendar a where a.estado=:estado";
      
      $query= $this->em->createQuery($dql);
      
      $query->setParameter('estado', '1');
      
      $calendario_activo= $query->getArrayResult();
      var_dump($calendario_activo);
      $this->view->estado= $calendario_activo;

     //Recibo los parametros por ajax
     $annio =$this->_getParam('annio'); 
     $per =$this->_getParam('per');
     $estado= $this->_getParam('estado');
    // var_dump($estado);
     $ini =$this->_getParam('ini');
     $final =$this->_getParam('fin');
     try{
        //formato para convertir string a datetime
         $fecha_inicio = new DateTime($ini);
//         $fecha_inicio->format('d/m/Y');
         $fecha_actual= new\DateTime('now');
         $fecha_ahora= $fecha_actual->getTimestamp();
         //Conseguir la pocision del vector...
        $fecha_fin_calendario= $calendario_activo[0]['fecha_fin'];
        $fecha_final_calendario= $fecha_fin_calendario->getTimestamp();
         
     
        $fecha_fin = DateTime::createFromFormat('d/m/Y', $final);
     } catch (Exception $ex) {
        echo $ex->getMessage();
     }
      
    // var_dump($ini);
    // var_dump($final);
     
     
     //condicional para validar la fecha de inicio, con la fecha de fin
        
    try{
        
        $fecha_ini = strtotime($ini);
       // var_dump($fecha_ini);
        $fecha_fi =  $fecha_fin->getTimestamp();
                
      //  var_dump($fecha_fin);
        
       // var_dump(strtotime($final));
        var_dump($fecha_ini);
        var_dump($fecha_fi);
        var_dump($fecha_final_calendario);
        var_dump($fecha_ahora);
    if($fecha_ini < $fecha_fi && $fecha_final_calendario < $fecha_ahora){
        
            
          //  echo 'Las Fechas Son correctas';
        $calendario_objeto = new Application_Model_calendar();
        $calendario_objeto->setid_annio($this->em->getRepository('Application_Model_Annio')->find($annio));
        $calendario_objeto->setid_periodo($this->em->getRepository('Application_Model_Periodo')->find($per));
        $calendario_desactivado= $this->em->getRepository('Application_Model_calendar')->find($calendario_activo[0]['id']);
        $calendario_desactivado->setestado('0');
        $calendario_objeto->setestado('1');
        $calendario_objeto->setfecha_inicio($fecha_inicio);
        $calendario_objeto->setfecha_fin($fecha_fin);
         var_dump($calendario_objeto);
       $this->em->persist($calendario_objeto);
       $this->em->persist($calendario_desactivado);
        //Ejecuta la Orden de guardar..
       $this->em->flush();   
        
      
           }  else {
           header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
        } 
     
        
    }catch(Exception $e){
        echo $e->getMessage();
    }
        
    /**    $json= array();
        $json['id']=$calendario_objeto->getid();
        $json['annio']=$annio;
        //var_dump($json);
         echo Zend_Json::encode($json); */
           
                
      
        
        //Imprimir en la pagina lo que esta en la variable en este caso facultades
       // var_dump($facultades);
        //Pasarle a la Vista la informción de la facultad    
        
    }
     public function editarcalendarAction() { 
       //le paso el id, por petición Ajax
         //Consulta dql para listar los calendarios
      $dql= "select a from Application_Model_Annio a";
      
      $query= $this->em->createQuery($dql);
      
      $annio= $query->getArrayResult();
      
      $this->view->annio= $annio;
      
      //preparo la consulta dql, para obtener el periodo
      $dql1= "select p from Application_Model_Periodo p";
      
      $query1= $this->em->createQuery($dql1);
      
      $periodo= $query1->getArrayResult();
      
      $this->view->periodo= $periodo;  
         
         
      $calendario_id =$this->_getParam('id');
      //Preparo la Consulta....
      $dql2="select c, a, p from Application_Model_calendar c join c.id_annio a join c.id_periodo p where c.id=:calendario";
      //Crear el query para que se guarde la consulta...
      $query2= $this->em->createQuery($dql2);
      //Se guarde el id de calendario..
      $query2->setParameter('calendario', $calendario_id);
      //muestre el resultado en un array...
      $calendario =$query2->getArrayResult();
      
      //Pasarle a la Vista la informción de la Calendario
      $this->view->calendario= $calendario;
      
      
      
         
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
     //$this->view->headScript()->appendFile('/js/practica.js');
     $this->view->headScript()->appendFile('/admin/calendario.js');
     $this->view->headScript()->appendFile('/validacion/jquery.validate.min.js');
     $this->view->headScript()->appendFile('/validacion/localization/messages_es.min.js');
     $this->view->headScript()->appendFile('/validacion/additional-methods.min.js');
    }
    public function actualizarcalendarAction(){
   //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->layout->disableLayout();
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->viewRenderer->setNoRender(TRUE);
       //Recibir id como parametro
     $ide= $this->_getParam('ide');   
     //Se hace un condicional que el id es mayor que cero
     if($ide>0){
      //Proceso a editar
       //$facultad recibe los datos que se les pasa por petición ajax
     $id_annio =$this->_getParam('id_annio');  
     var_dump($id_annio);
     $id_periodo =$this->_getParam('id_periodo');
     var_dump($id_periodo);
     $estado= $this->_getParam('estado');
     var_dump($estado);
     $ini =$this->_getParam('ini');
     var_dump($ini);
     $fin =$this->_getParam('fin');
     var_dump($fin);
     try{
         //formato para convertir string a datetime
         $fecha_inicio = DateTime::createFromFormat('d/m/Y', $ini);
         $fecha_fin =  DateTime::createFromFormat('d/m/Y', $fin);

          
       if($fecha_inicio->getTimestamp() < $fecha_fin->getTimestamp()){
           
        echo 'Las Fechas Son correctas';   
        // Almacena en el objecto del calendario que tiene el id..
     $calendario_objeto = ($this->em->getRepository('Application_Model_calendar')->find($ide));
     //la instancia le asigna una facultad, hacer el nombre de la facultad..
     $calendario_objeto->setid_annio($this->em->getRepository('Application_Model_Annio')->find($id_annio));
     $calendario_objeto->setid_periodo($this->em->getRepository('Application_Model_Periodo')->find($id_periodo));
     $calendario_objeto->setestado($estado);
     $calendario_objeto->setfecha_inicio($fecha_inicio);
     $calendario_objeto->setfecha_fin($fecha_fin);
     //da la orden de guardar...
     $this->em->persist($calendario_objeto);
//     var_dump($calendario_objeto);
     //Ejecuta la Orden de guardar..
     $this->em->flush();  
       }  else {
         header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);  
       } 
     } catch (Exception $ex) {
        echo $ex->getMessage();
     }
     // var_dump($ini);
      //var_dump($fin);
     
         
     }
     $this->view->headScript()->appendFile('/admin/calendario.js');
    }
    
  
  public function eliminarcalendarAction(){
   //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
    $this->_helper->layout->disableLayout();
    //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
    $this->_helper->viewRenderer->setNoRender(TRUE); 
    
    try {
         //Recibo los parametros por Ajax
    $calendario_id= $this->_getParam('calendario_id');
    
    //meto el id en un objeto
    $calendario_objeto= ($this->em->getRepository('Application_Model_calendar')->find($calendario_id));
    
    // da la orden de eliminar
     $this->em->remove($calendario_objeto);
     
     //Ejecuta la Orden de Guardar
     $this->em->flush();
    } catch (Exception $ex) {
       //Mensaje de Error en el Servidor  
      header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);   
        
    } 
    }
   
}




