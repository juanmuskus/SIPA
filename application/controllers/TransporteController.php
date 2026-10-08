<?php

class TransporteController extends Zend_Controller_Action
{
    // Entity Manager
    private $em;

    public function init()
    {
        // Activar el Entity Manager
        $registry = Zend_Registry::getInstance();
        $this->em = $registry->entitymanager;
        
         $this->_helper->layout->setLayout('prueba');
         $this->view->headLink()->appendStylesheet('/font-awesome/css/font-awesome.css');
         $this->view->headLink()->appendStylesheet('/css/facultad.css');
        
    }

    public function indexAction()
    {
       // para que todo lo que este dentro de este metodo se ejecute en todas las Vistas..
    }
    
    public function agregartransporteAction()
    { 
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
     $this->view->headScript()->appendFile('/logistica/transporte.js');
     $this->view->headScript()->appendFile('/validacion/jquery.validate.min.js');
     $this->view->headScript()->appendFile('/validacion/localization/messages_es.min.js');
     $this->view->headScript()->appendFile('/validacion/additional-methods.min.js');
    }
    public function listartransporteAction()
    { 
       
        
        //Consulta dql para listar las facultades
        $dql ="select t from Application_Model_Transporte t";
        
        // Ejecutar el Query, la variable query es donde se carga la consulta.
        $query = $this->em->createQuery($dql);
        
        //Resultados de la consulta en un Vector, en este caso en Array
        $transporte = $query->getArrayResult();
        
        //Imprimir en la pagina lo que esta en la variable en este caso facultades
       // var_dump($facultades);
        //Pasarle a la Vista la informción de la facultad
        $this->view->transporte= $transporte;
        
      
      $this->view->headLink()->appendStylesheet('/css/jquery.dataTables.min.css');
      $this->view->headLink()->appendStylesheet('/font-awesome/css/font-awesome.css');
      $this->view->headLink()->appendStylesheet('/css/facultad.css');
      $this->view->headScript()->appendFile('/js/jquery.dataTables.min.js');
      $this->view->headScript()->appendFile('/js/facultad.js');
      $this->view->headScript()->appendFile('/js/bootstrap-modal.js');
      $this->view->headScript()->appendFile('/logistica/transporte.js');
      $this->view->headScript()->appendFile('/validacion/jquery.validate.min.js');
      $this->view->headScript()->appendFile('/validacion/localization/messages_es.min.js');
      $this->view->headScript()->appendFile('/validacion/additional-methods.min.js');
      $this->view->headScript()->appendFile('/validacion/bootbox.min.js');
      
    }
    public function guardartransporteAction(){
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->layout->disableLayout();
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->viewRenderer->setNoRender(TRUE);
     
     try {
         
          //$facultad recibe los datos que se les pasa por petición ajax
     $placa =$this->_getParam('placa'); 
     var_dump($placa);
     $descripcion =$this->_getParam('descripcion'); 
     $vehiculo =$this->_getParam('vehiculo'); 
     $estado =$this->_getParam('estado'); 
     $pasajero =$this->_getParam('pasajero'); 
     //var_dump($facultad);
     
     // Instancia del modelo vehiculo. crea una facultad automatico..
     $transporte_objeto = new Application_Model_Transporte();
     //la instancia le asigna una facultad, hacer el nombre de la facultad..
     $transporte_objeto->setplaca($placa);
     $transporte_objeto->setdescripcion($descripcion);
     $transporte_objeto->settipo_vehiculo($vehiculo);
     $transporte_objeto->setestado_vehiculo($estado);
     $transporte_objeto->setcapacidad_pasajeros($pasajero);
     //da la orden de guardar...
      $this->em->persist($transporte_objeto);
    // var_dump($transporte_objeto);
     //Ejecuta la Orden de guardar..
      $this->em->flush();
         
     } catch (Exception $e) {
         echo $e->getMessage();   
     }   
        
        
    }
     public function editartransporteAction() { 
        $id= $this->_getParam('id'); 
         //Realizo la consulta para obtener el codigo de la facultad...
         $dql= "select t from Application_Model_Transporte t where t.cod_transporte=:transporte";
         //Crear el query para que se guarde la consulta...
         $query= $this->em->createQuery($dql);
         //se le pasa el parametro
         $query->setParameter('transporte', $id);
         //muestre el resultado en un array...
         $transporte =$query->getArrayResult();
        // var_dump($facultad);     
      
       /** try{  
     } catch (Exception $e) {
         echo $e->getMessage();
     } */
         //Se le pasa la variable a la vista...
        $this->view->transporte= $transporte; 
         
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
     $this->view->headScript()->appendFile('/logistica/transporte.js');
     $this->view->headScript()->appendFile('/validacion/jquery.validate.min.js');
     $this->view->headScript()->appendFile('/validacion/localization/messages_es.min.js');
     $this->view->headScript()->appendFile('/validacion/additional-methods.min.js');
     $this->view->headScript()->appendFile('/validacion/bootbox.min.js');
    }
    public function actualizartransporteAction(){
          //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->layout->disableLayout();
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->viewRenderer->setNoRender(TRUE);
     
     //Recibir id como parametro
     $id= $this->_getParam('id');   
     //Se hace un condicional que el id es mayor que cero
     if($id>0){
      //Proceso a editar
       //$facultad recibe los datos que se les pasa por petición ajax
     $placa =$this->_getParam('placa'); 
    // var_dump($placa);
     $descripcion =$this->_getParam('descripcion'); 
     $vehiculo =$this->_getParam('vehiculo'); 
     $estado =$this->_getParam('estado'); 
     $pasajero =$this->_getParam('pasajero');  
     //var_dump($facultad);
     
     // Almacena en el objecto la transporte que tiene el id..
     $transporte_objeto = ($this->em->getRepository('Application_Model_Transporte')->find($id));
     $transporte_objeto->setplaca($placa);
     $transporte_objeto->setdescripcion($descripcion);
     $transporte_objeto->settipo_vehiculo($vehiculo);
     $transporte_objeto->setestado_vehiculo($estado);
     $transporte_objeto->setcapacidad_pasajeros($pasajero);
     //da la orden de guardar...
     $this->em->persist($transporte_objeto);
     //Ejecuta la Orden de guardar..
     $this->em->flush();     
     }
     $this->view->headScript()->appendFile('/logistica/transporte.js');
    }
      public function eliminartransporteAction(){
          //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->layout->disableLayout();
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->viewRenderer->setNoRender(TRUE);
     //Recibo el dato por ajax
     try {
     $transporte_id= $this->_getParam('transporte_id');  
     
     $transporte_objeto= ($this->em->getRepository('Application_Model_Transporte')->find($transporte_id));
     
     // da la orden de guardar
     $this->em->remove($transporte_objeto);
     
     //Ejecuta la Orden de Guardar
     $this->em->flush();
         
     } catch (Exception $ex) {
     header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
         
     }
           
    }
}



