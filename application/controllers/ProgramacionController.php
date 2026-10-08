<?php

class ProgramacionController extends Zend_Controller_Action
{
    // Entity Manager
    private $em;

    public function init()
    {
        $this->_helper->layout->setLayout('layout');
        $this->view->headLink()->appendStylesheet('/font-awesome/css/font-awesome.css');
         $this->view->headLink()->appendStylesheet('/css/facultad.css');
        // Activar el Entity Manager
        $registry = Zend_Registry::getInstance();
        $this->em = $registry->entitymanager;
        $this->pw= $registry->powercampus_connection;
        $this->ka= $registry->kactus_connection;
       
        
    }

    public function indexAction()
    {
       // para que todo lo que este dentro de este metodo se ejecute en todas las Vistas..
    }
    
    public function agregarprogramacionAction()
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
     $this->view->headScript()->appendFile('/admin/facultades.js');
     $this->view->headScript()->appendFile('/validacion/jquery.validate.min.js');
     $this->view->headScript()->appendFile('/validacion/localization/messages_es.min.js');
     $this->view->headScript()->appendFile('/validacion/additional-methods.min.js');
    }
    public function listarprogramacionAction(){ 
        try {  // llamo la session
         $authNamespace = new Zend_Session_Namespace('Zend_Auth');
         //saco los datos del usuario
         $usuario= $authNamespace->usuarios;
         $rol= $authNamespace->usuarios[0]['id_rol']['id_rol'];
         
         $this->view->rol= $rol;
       
       //preparo la consulta, para extraer la información de la tabla práctica..
      //preparo la consulta, para extraer la información de la tabla práctica..
        $dql1= "select pro, cod from Application_Model_Programacion pro join pro.cod_practica cod";
        
        $query1 = $this->em->createQuery($dql1);
        
        //Resultados de la consulta en un Vector, en este caso en Array
        $programacion = $query1->getArrayResult();   
        //Pasarle a la Vista la informción a listar programacion
        $this->view->programacion= $programacion; 
        } catch (Exception $ex) {
            $ex->getMessage();
            
        } 
        
     $this->view->headLink()->appendStylesheet('/css/bootstrap-datepicker.min.css');  
     $this->view->headLink()->appendStylesheet('/css/jquery.dataTables.min.css');
     $this->view->headLink()->appendStylesheet('/css/font-awesome.min.css');
     $this->view->headLink()->appendStylesheet('/css/practica.css');
     $this->view->headScript()->appendFile('/js/practica.js');
    // $this->view->headScript()->appendFile('/admin/practicas.js');
      $this->view->headScript()->appendFile('/bootstrap/js/moment.min.js');   
     $this->view->headScript()->appendFile('/bootstrap/js/bootstrap-datepicker.js');      
     $this->view->headScript()->appendFile('/bootstrap/js/datepicker.es.min.js');
     $this->view->headScript()->appendFile('/js/jquery.dataTables.min.js');
     $this->view->headScript()->appendFile('/js/bootstrap-modal.js');
     $this->view->headScript()->appendFile('/validacion/jquery.validate.min.js');
     $this->view->headScript()->appendFile('/validacion/localization/messages_es.min.js');
     $this->view->headScript()->appendFile('/validacion/additional-methods.min.js');
     $this->view->headScript()->appendFile('/validacion/bootbox.min.js');
    
      
    }
    public function guardarprogramacionAction(){
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->layout->disableLayout();
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->viewRenderer->setNoRender(TRUE);
     
     //$facultad recibe los datos que se les pasa por petición ajax
     $facultad =$this->_getParam('facultad');  
     //var_dump($facultad);
     
     // Instancia del modelo Facultades. crea una facultad automatico..
     $facultad_objeto = new Application_Model_Facultades();
     //la instancia le asigna una facultad, hacer el nombre de la facultad..
     $facultad_objeto->setnombre($facultad);
     //da la orden de guardar...
     $this->em->persist($facultad_objeto);
     //Ejecuta la Orden de guardar..
     $this->em->flush();   
        
        
    }
     public function editarprogramacionAction() { 
       
         //capturo el id de la facultad
         $facultad_id =$this->_getParam('id');
         //Realizo la consulta para obtener el codigo de la facultad...
         $dql= "select f from Application_Model_Facultades f where f.id_facultad=:facultad";
         //Crear el query para que se guarde la consulta...
         $query= $this->em->createQuery($dql);
         //Se guarde el id de facultad..
         $query->setParameter('facultad', $facultad_id);
         //muestre el resultado en un array...
         $facultad =$query->getArrayResult();
        // var_dump($facultad);     
      
       /** try{  
     } catch (Exception $e) {
         echo $e->getMessage();
     } */
         //Se le pasa la variable a la vista...
        $this->view->facultad= $facultad; 
         
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
     $this->view->headScript()->appendFile('/admin/facultades.js');
     $this->view->headScript()->appendFile('/validacion/jquery.validate.min.js');
     $this->view->headScript()->appendFile('/validacion/localization/messages_es.min.js');
     $this->view->headScript()->appendFile('/validacion/additional-methods.min.js');
     $this->view->headScript()->appendFile('/validacion/bootbox.min.js');
    }
    public function actualizarprogramacionAction(){
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
     $facultad =$this->_getParam('facultad');  
     //var_dump($facultad);
     
     // Almacena en el objecto la facultad que tiene el id..
     $facultad_objeto = ($this->em->getRepository('Application_Model_Facultades')->find($id));
     //la instancia le asigna una facultad, hacer el nombre de la facultad..
     $facultad_objeto->setnombre($facultad);
     //da la orden de guardar...
     $this->em->persist($facultad_objeto);
     //Ejecuta la Orden de guardar..
     $this->em->flush();     
     }      
    }
      public function eliminarprogramacionAction(){
          //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->layout->disableLayout();
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->viewRenderer->setNoRender(TRUE);
     //Recibo el dato por ajax
     try {
     $facultad_id= $this->_getParam('facultad_id');  
     
     $facultad_objeto= ($this->em->getRepository('Application_Model_Facultades')->find($facultad_id));
     
     // da la orden de guardar
     $this->em->remove($facultad_objeto);
     
     //Ejecuta la Orden de Guardar
     $this->em->flush();
         
     } catch (Exception $ex) {
     header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
         
     }
           
    }
}



