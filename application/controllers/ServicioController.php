<?php

class ServicioController extends Zend_Controller_Action{
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
    
    public function agregarservicioAction(){ 
    
         //Consulta dql para listar las servicioscd 
        $dql ="select p from Application_Model_Programacion p";
        
        // Ejecutar el Query, la variable query es donde se carga la consulta.
        $query = $this->em->createQuery($dql);
        
        //Resultados de la consulta en un Vector, en este caso en Array
        $programacion = $query->getArrayResult();
        
        //Imprimir en la pagina lo que esta en la variable en este caso facultades
       // var_dump($facultades);
        //Pasarle a la Vista la informción de la facultad
        $this->view->programacion= $programacion;
        
        
        
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
     $this->view->headScript()->appendFile('/logistica/servicio.js');
     $this->view->headScript()->appendFile('/validacion/jquery.validate.min.js');
     $this->view->headScript()->appendFile('/validacion/localization/messages_es.min.js');
     $this->view->headScript()->appendFile('/validacion/additional-methods.min.js');
    }
    public function listarservicioAction()
    { 
       
        
        //Consulta dql para listar las facultades
        $dql ="select s, p from Application_Model_Servicios s join s.codigo_prog p";
        
        // Ejecutar el Query, la variable query es donde se carga la consulta.
        $query = $this->em->createQuery($dql);
        
        //Resultados de la consulta en un Vector, en este caso en Array
        $servicios = $query->getArrayResult();
        
        //Imprimir en la pagina lo que esta en la variable en este caso facultades
       // var_dump($facultades);
        //Pasarle a la Vista la informción de la facultad
        $this->view->servicios= $servicios;
        
      
      $this->view->headLink()->appendStylesheet('/css/jquery.dataTables.min.css');
      $this->view->headLink()->appendStylesheet('/font-awesome/css/font-awesome.css');
      $this->view->headLink()->appendStylesheet('/css/facultad.css');
      $this->view->headScript()->appendFile('/js/jquery.dataTables.min.js');
      $this->view->headScript()->appendFile('/js/facultad.js');
      $this->view->headScript()->appendFile('/js/bootstrap-modal.js');
       $this->view->headScript()->appendFile('/logistica/servicio.js');
      $this->view->headScript()->appendFile('/validacion/jquery.validate.min.js');
      $this->view->headScript()->appendFile('/validacion/localization/messages_es.min.js');
      $this->view->headScript()->appendFile('/validacion/additional-methods.min.js');
      $this->view->headScript()->appendFile('/validacion/bootbox.min.js');
      
    }
    public function guardarservicioAction(){
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->layout->disableLayout();
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->viewRenderer->setNoRender(TRUE);
     
     try {
            //$facultad recibe los datos que se les pasa por petición ajax
     $servicio =$this->_getParam('servicio'); 
   // var_dump($servicio);
     $valor =$this->_getParam('valor');
    // var_dump($valor);
     $codigo =  $this->_getParam('codigo');
     //var_dump($facultad);
     $observacion= $this->_getParam('observacion');
     var_dump($observacion);
     
     // Instancia del modelo Facultades. crea una facultad automatico..
     $servicio_objeto = new Application_Model_Servicios();
     //la instancia le asigna una facultad, hacer el nombre de la facultad..
     $servicio_objeto->settipo($servicio);
     $servicio_objeto->setvalor($valor);
     $servicio_objeto->setcodigo_prog(($this->em->getRepository('Application_Model_Programacion')->find($codigo)));
     $servicio_objeto->setobservacion($observacion);
     
     //da la orden de guardar...
     $this->em->persist($servicio_objeto);
     //Ejecuta la Orden de guardar..
    $this->em->flush(); 
         
     } catch (Exception $e) {
         echo $e->getMessage();   
     }  
        
        
    }
     public function editarservicioAction() { 
       
           //Consulta dql para listar las servicioscd 
        $dql ="select p from Application_Model_Programacion p";
        
        // Ejecutar el Query, la variable query es donde se carga la consulta.
        $query = $this->em->createQuery($dql);
        
        //Resultados de la consulta en un Vector, en este caso en Array
        $programacion = $query->getArrayResult();
        
        //Imprimir en la pagina lo que esta en la variable en este caso facultades
       // var_dump($facultades);
        //Pasarle a la Vista la informción de la facultad
        $this->view->programacion= $programacion; 
         
       //instacia para la edición del metodo editar la programación
        $servicio_id= $this->_getParam('id'); 
       // var_dump($servicio_id);
         
       //Consulta dql para listar las facultades
        $dql1 ="select s, p from Application_Model_Servicios s join s.codigo_prog p where s.cod_servicio=:servicio";
        
        // Ejecutar el Query, la variable query es donde se carga la consulta.
        $query1 = $this->em->createQuery($dql1);
        
        $query1->setParameter('servicio', $servicio_id);
        
        //Resultados de la consulta en un Vector, en este caso en Array
        $servicios = $query1->getArrayResult();
        
        //Imprimir en la pagina lo que esta en la variable en este caso facultades
       // var_dump($facultades);
        //Pasarle a la Vista la informción de la facultad
        $this->view->servicios= $servicios;
         
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
     $this->view->headScript()->appendFile('/logistica/servicio.js');
     $this->view->headScript()->appendFile('/validacion/jquery.validate.min.js');
     $this->view->headScript()->appendFile('/validacion/localization/messages_es.min.js');
     $this->view->headScript()->appendFile('/validacion/additional-methods.min.js');
    }
    public function actualizarservicioAction(){
          //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->layout->disableLayout();
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->viewRenderer->setNoRender(TRUE);
     
     //Recibir id como parametro
     $id= $this->_getParam('id');   
     //Se hace un condicional que el id es mayor que cero
     if($id>0){
      //Proceso a editar
       // recibo los datos que se les pasa por petición ajax
      $servicio =$this->_getParam('servicio'); 
      // var_dump($servicio);
      $valor =$this->_getParam('valor');
      // var_dump($valor);
      $codigo =  $this->_getParam('codigo');
      
      $observacion= $this->_getParam('observacion');
     
     // Almacena en el objecto la facultad que tiene el id..
     $servicio_objeto = ($this->em->getRepository('Application_Model_Servicios')->find($id));
     //la instancia le asigna una facultad, hacer el nombre de la facultad..
     $servicio_objeto->settipo($servicio);
     $servicio_objeto->setvalor($valor);
     $servicio_objeto->setcodigo_prog(($this->em->getRepository('Application_Model_Programacion')->find($codigo)));
     $servicio_objeto->setobservacion($observacion);
    // var_dump($servicio_objeto);
     
     //da la orden de guardar...
     $this->em->persist($servicio_objeto);
     //Ejecuta la Orden de guardar..
     $this->em->flush();     
     }
      $this->view->headScript()->appendFile('/logistica/servicio.js');
     
    }
      public function eliminarservicioAction(){
          //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->layout->disableLayout();
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->viewRenderer->setNoRender(TRUE);
     //Recibo el dato por ajax
     try {
     $servicio_id= $this->_getParam('servicio_id');  
     
     $servicio_objeto= ($this->em->getRepository('Application_Model_Servicios')->find($servicio_id));
     
     // da la orden de guardar
     $this->em->remove($servicio_objeto);
     
     //Ejecuta la Orden de Guardar
     $this->em->flush();
         
     } catch (Exception $ex) {
     header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
         
     }
           
    }
}



