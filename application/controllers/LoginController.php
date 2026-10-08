<?php

class LoginController extends Zend_Controller_Action
{
    // Entity Manager
    private $em;

    public function init()
    {
        // Activar el Entity Manager
        $registry = Zend_Registry::getInstance();
        $this->em = $registry->entitymanager;
        $this->view->headLink()->appendStylesheet('/font-awesome/css/font-awesome.css');
        $this->view->headLink()->appendStylesheet('/css/facultad.css');
        
        
    }

    public function indexAction(){
    //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información    
    $this->_helper->layout->disableLayout();
    
       // para que todo lo que este dentro de este metodo se ejecute en todas las Vistas..
       $this->view->headLink()->appendStylesheet('/css/fontfamily.css');
       $this->view->headLink()->appendStylesheet('/css/font-face.css');
       $this->view->headLink()->appendStylesheet('/bootstrap/css/bootstrap.min.css');
       $this->view->headLink()->appendStylesheet('/font-awesome/css/font-awesome.css');
       $this->view->headLink()->appendStylesheet('/css/form-elements.css');
       $this->view->headLink()->appendStylesheet('/css/style.css');
       $this->view->headScript()->appendFile('/js/jquery-1.12.3.js');
       $this->view->headScript()->appendFile('/js/bootstrap.min.js');
       $this->view->headScript()->appendFile('/js/jquery.backstretch.js');
       $this->view->headScript()->appendFile('/js/scripts.js');
    }
    
    public function autenticarAction(){
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->layout->disableLayout();
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->viewRenderer->setNoRender(TRUE);
     
     //Recibo los parametros por Ajax
     $user=  $this->_getParam('user');
     $pass= $this->_getParam('pass');
    // var_dump($pass);
     
     //Encripto la contraseña...
     
     $pass= hash('sha256', $pass);
     
     // Preparo la consulta
     $dql="select u, r from Application_Model_Usuarios u join u.id_rol r where u.usuario=:user and u.contrasena=:pass";
    
     $query = $this->em->createQuery($dql);
     //Agrego los Parametros
     $query->setParameter('pass', $pass);
    // var_dump($query);
     $query->setParameter('user', $user);
     
     //Obtengo el resultado del query
     $usuarios = $query->getArrayResult();
     //var_dump(count($usuarios));
      
     
    if(count($usuarios)== 1){
       echo 'Datos Ingresados Correctos';
    //Inicio sesión cuando los datos sean correctos   
       
    $authNamespace = new Zend_Session_Namespace('Zend_Auth');

    $authNamespace->usuarios = $usuarios; 
    //var_dump($usuarios);

       
       
    } else {
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500); 
    }
     // Se la paso al listado de usuarios.
  //   $this->view->usuarios= $usuarios; 
     
    // 
       
     
    }
    
   
}



