<?php

class ParticipantesController extends Zend_Controller_Action
{
    // Entity Manager
    private $em;

    public function init()
    {
        // Activar el Entity Manager
        $registry = Zend_Registry::getInstance();
        $this->em = $registry->entitymanager;
       
        
    }

    public function indexAction()
    {
       // para que todo lo que este dentro de este metodo se ejecute en todas las Vistas..
    }
    
   
   
    public function guardarparticipanteAction(){
     //Interprete la respuesta Json
     header('Content-Type: application/json');   
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->layout->disableLayout();
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->viewRenderer->setNoRender(TRUE);
     
     
    
     //Recibo los parametros por ajax, para participante Docente...
     
     try {
     $nombre= $this->_getParam('nombre');
     $identificacion= $this->_getParam('identificacion');
     var_dump($identificacion);
     $tipo_participante= $this->_getParam('tipo_participante');
     
   
     
      $participante_objeto = new Application_Model_Participantes();
      $participante_objeto->setnombre($nombre);
      $participante_objeto->setidentificacion($identificacion);
      $participante_objeto->settipo_participante($tipo_participante);
      
      
     
      
      
      //da la orden de guardar...
     $this->em->persist($participante_objeto);
   //  var_dump($participante_objeto);
     //Ejecuta la Orden de guardar..
     $this->em->flush(); 
     //pasar en json a jquery
   /**  $json= array();
     $json['id_participante']=$participante_objeto->getid_participante();
     $json['nombre']=$nombre;
     echo Zend_Json::encode($json);    */   
     
         
     } catch (Exception $e) {
         echo $e->getMessage();
         
     }
        
    }
    
   
    
}



