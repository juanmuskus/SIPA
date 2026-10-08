<?php

class ConductorController extends Zend_Controller_Action
{
    // Entity Manager
    private $em;

    public function init()
    {
        /* Initialize action controller here */
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
    
    public function agregarconductorAction(){ 
      
        
       
        
   //  $this->view->headLink()->appendStylesheet('/css/bootstrap-datepicker.min.css'); 
     $this->view->headLink()->appendStylesheet('/css/fuelux.min.css'); 
     $this->view->headLink()->appendStylesheet('/css/jquery.dataTables.min.css');
     $this->view->headLink()->appendStylesheet('/css/font-awesome.min.css');
     $this->view->headLink()->appendStylesheet('/font-awesome/css/font-awesome.css');
     $this->view->headLink()->appendStylesheet('/css/bootstrap-datepicker.css.map');
     $this->view->headScript()->appendFile('/js/fuelux.min.js');
     $this->view->headScript()->appendFile('/js/wizard.js');
     $this->view->headScript()->appendFile('/bootstrap/js/moment.min.js');   
     $this->view->headScript()->appendFile('/bootstrap/js/bootstrap-datepicker.js');      
     $this->view->headScript()->appendFile('/bootstrap/js/datepicker.es.min.js');
     $this->view->headScript()->appendFile('/js/jquery.dataTables.min.js');
     $this->view->headScript()->appendFile('/js/bootstrap-modal.js');
     $this->view->headScript()->appendFile('/logistica/conductor.js');
     $this->view->headScript()->appendFile('/validacion/jquery.validate.min.js');
     $this->view->headScript()->appendFile('/validacion/localization/messages_es.min.js');
     $this->view->headScript()->appendFile('/validacion/additional-methods.min.js');
     
    }
    public function listarconductorAction(){ 
     
       
        //Consulta dql para listar los conductores
        $dql ="select c from Application_Model_Conductores c";
        
        // Ejecutar el Query, la variable query es donde se carga la consulta.
        $query = $this->em->createQuery($dql);
        
        //Resultados de la consulta en un Vector, en este caso en Array
        $conductores = $query->getArrayResult();
        
        //Imprimir en la pagina lo que esta en la variable en este caso facultades
       // var_dump($facultades);
        //Pasarle a la Vista la informción de la facultad
        $this->view->conductores= $conductores;   
       // var_dump($conductores);
        
      $this->view->headLink()->appendStylesheet('/css/jquery.dataTables.min.css');
      $this->view->headLink()->appendStylesheet('/font-awesome/css/font-awesome.css');
      $this->view->headLink()->appendStylesheet('/css/facultad.css');
      $this->view->headScript()->appendFile('/js/jquery.dataTables.min.js');
      $this->view->headScript()->appendFile('/js/facultad.js');
      $this->view->headScript()->appendFile('/js/bootstrap-modal.js');
       $this->view->headScript()->appendFile('/logistica/conductor.js');
      $this->view->headScript()->appendFile('/validacion/jquery.validate.min.js');
      $this->view->headScript()->appendFile('/validacion/localization/messages_es.min.js');
      $this->view->headScript()->appendFile('/validacion/additional-methods.min.js');
      $this->view->headScript()->appendFile('/validacion/bootbox.min.js');
    }
       public function guardarconductorAction(){
    //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->layout->disableLayout();
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->viewRenderer->setNoRender(TRUE);
     
    //Recibo los Parametros por Petición Ajax
     $nom=$this->_getParam('nom'); 
     $ape=$this->_getParam('ape'); 
     $ide=$this->_getParam('ide'); 
     $tele=$this->_getParam('tele'); 
     $dir=$this->_getParam('dir'); 
     
   // Instancia del modelo Conductores. crea un conductor automatico..
     $conductor_objeto= new Application_Model_Conductores();
     $conductor_objeto->setnombre($nom);
     $conductor_objeto->setapellido($ape);
     $conductor_objeto->setidentificacion($ide);
     $conductor_objeto->settelefono($tele);
     $conductor_objeto->setdireccion($dir); 
    
      $this->em->persist($conductor_objeto);
       //Ejecuta la Orden de guardar..
       $this->em->flush();
    }
     public function editarconductorAction(){ 
     //Realizo la consulta para obtener el codigo de la facultad...
         $id= $this->_getParam('id');
         
         $dql= "select c from Application_Model_Conductores c where c.id_conductor=:conductor";
         //Crear el query para que se guarde la consulta...
         $query= $this->em->createQuery($dql);
         //Se guarde el id de facultad..
         $query->setParameter('conductor', $id);
         //muestre el resultado en un array...
         $conductores =$query->getArrayResult();
        // var_dump($facultad);     
      
       /** try{  
     } catch (Exception $e) {
         echo $e->getMessage();
     } */
         //Se le pasa la variable a la vista...
        $this->view->conductores= $conductores;     
       // var_dump($conductores);
     
     $this->view->headLink()->appendStylesheet('/css/fuelux.min.css'); 
     $this->view->headLink()->appendStylesheet('/css/jquery.dataTables.min.css');
     $this->view->headLink()->appendStylesheet('/css/font-awesome.min.css');
     $this->view->headLink()->appendStylesheet('/font-awesome/css/font-awesome.css');
     $this->view->headLink()->appendStylesheet('/css/bootstrap-datepicker.css.map');
     $this->view->headScript()->appendFile('/js/fuelux.min.js');
     $this->view->headScript()->appendFile('/js/wizard.js');
     $this->view->headScript()->appendFile('/bootstrap/js/moment.min.js');   
     $this->view->headScript()->appendFile('/bootstrap/js/bootstrap-datepicker.js');      
     $this->view->headScript()->appendFile('/bootstrap/js/datepicker.es.min.js');
     $this->view->headScript()->appendFile('/js/jquery.dataTables.min.js');
     $this->view->headScript()->appendFile('/js/bootstrap-modal.js');
     $this->view->headScript()->appendFile('/logistica/conductor.js');
     $this->view->headScript()->appendFile('/validacion/jquery.validate.min.js');
     $this->view->headScript()->appendFile('/validacion/localization/messages_es.min.js');
     $this->view->headScript()->appendFile('/validacion/additional-methods.min.js');
    }
 
     public function actualizarconductorAction(){
          //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->layout->disableLayout();
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->viewRenderer->setNoRender(TRUE);
     
   
         //Recibir id como parametro
     $id= $this->_getParam('id');   
     //Se hace un condicional que el id es mayor que cero
     if($id>0){
      //Proceso a editar
    //Recibo los Parametros por Petición Ajax
     $nombre =$this->_getParam('nombre'); 
      var_dump($nombre);
     $apellido =$this->_getParam('apellido');
     var_dump($apellido);
     $identificacion =$this->_getParam('identificacion'); 
     var_dump($identificacion);
     $telefono =$this->_getParam('telefono');
      var_dump($telefono);
     $direccion =$this->_getParam('direccion'); 
     var_dump($direccion);
     
     // Almacena en el objecto la facultad que tiene el id..
     $conductor_objeto =($this->em->getRepository('Application_Model_Conductores')->find($id));
     //la instancia le asigna una facultad, hacer el nombre de la facultad..
     $conductor_objeto->setnombre($nombre);
     $conductor_objeto->setapellido($apellido);
     $conductor_objeto->setidentificacion($identificacion);
     $conductor_objeto->settelefono($telefono);
     $conductor_objeto->setdireccion($direccion); 
     var_dump($conductor_objeto);
     //da la orden de guardar...
     $this->em->persist($conductor_objeto);
     //Ejecuta la Orden de guardar..
     $this->em->flush();      
     }
     $this->view->headScript()->appendFile('/logistica/conductor.js');
         
     
    }
      public function eliminarconductorAction(){
          //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->layout->disableLayout();
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->viewRenderer->setNoRender(TRUE);
     //Recibo el dato por ajax
     try {
     $conductor_id= $this->_getParam('conductor_id');  
     
     $conductor_objeto= ($this->em->getRepository('Application_Model_Conductores')->find($conductor_id));
     
     // da la orden de guardar
     $this->em->remove($conductor_objeto);
     
     //Ejecuta la Orden de Guardar
     $this->em->flush();
         
     } catch (Exception $ex) {
     header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
         
     }
           
    }

}



