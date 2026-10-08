<?php

class AutorizarController extends Zend_Controller_Action{
    // Entity Manager
    private $em;

    public function init(){
        // Activar el Entity Manager
        $registry = Zend_Registry::getInstance();
        $this->em = $registry->entitymanager;
        
        
        
    }

    public function indexAction(){
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->layout->disableLayout();
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
    $this->_helper->viewRenderer->setNoRender(TRUE);    
   
    //instancio la sesión 
    $authNamespace = new Zend_Session_Namespace('Zend_Auth');
   
    
    //Creo un swich para que me controle todas los roles
   // var_dump($authNamespace->usuarios[0]['id_rol']['id_rol']);
    switch ($authNamespace->usuarios[0]['id_rol']['id_rol']){
       case "1": 
           $this->_redirect('/inicio/admin');
            break;
       case "2":
            $id_usuario = $authNamespace->usuarios[0]['id_usuario'];
            $dql="select u, r from Application_Model_Usuarios u join u.id_rol r where u.id_usuario=:usuario";
           // var_dump($dql);
            //creo el query con la consulta..
            $query = $this->em->createQuery($dql);
            $query->setParameter('usuario', $id_usuario);
           //resultados de la consulta
           $cod_programa= $query->getArrayResult();
           // var_dump($cod_programa);
           $authNamespace->programa= $cod_programa;
            $this->_redirect('/inicio/departamento');
            break; 
        case "3": 
            echo "hola";
           $this->_redirect('/inicio/logistica');
            break;
        case "4": 
            echo "hola";
            $this->_redirect('/inicio/financiera');
            break;
        
    }
    //hago un condiconal para saber cual es el
    
    //que voy a consultar
    
  
          
    
    
    }
    
   
    
   
}



