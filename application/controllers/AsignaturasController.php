<?php

class AsignaturasController extends Zend_Controller_Action
{
    private $em;


    public function init()
    {
        // Activar el Entity Manager
        $registry = Zend_Registry::getInstance();
        $this->em = $registry->entitymanager;
        
         $this->_helper->layout->setLayout('admin');
     //  $this->_helper->layout->setLayout('prueba'); 
         $this->view->headLink()->appendStylesheet('/font-awesome/css/font-awesome.css');
        
        
    }

    public function indexAction()
    {
       // para que todo lo que este dentro de este metodo se ejecute en todas las Vistas..
    }
    
    public function agregarasignaturaAction() { 
      // Realizamos la consulta dql, para que se listen los Programas, en la vista Agregar Asignatura..
        $dql ="select f from Application_Model_Programas f";
        
         // Ejecutar el Query, la variable query es donde se carga la consulta.
        $query = $this->em->createQuery($dql);
        
        //Resultados de la consulta en un Vector, en este caso en Array
        $programas = $query->getArrayResult();
        
        // Pasarle la información de programas a la vista ..
        $this->view->programas= $programas;
        
        //preparo la consulta de facultades
        $dql1= "select fa from Application_Model_Facultades fa";
        
        $query1= $this->em->createQuery($dql1);
        
        $facultad =  $query1->getArrayResult();
        
        $this->view->facultad= $facultad;
         //preparo la consulta de sede
        $dql2= "select s from Application_Model_Sedes s";
        
        $query2= $this->em->createQuery($dql2);
        
        $sedes= $query2->getArrayResult();
        
        $this->view->sedes= $sedes;
        
        
     $this->view->headLink()->appendStylesheet('/css/bootstrap-datepicker.min.css'); 
    // $this->view->headLink()->appendStylesheet('/css/fuelux.min.css'); 
     $this->view->headLink()->appendStylesheet('/css/jquery.dataTables.min.css');
     $this->view->headLink()->appendStylesheet('/font-awesome/css/font-awesome.css');
     $this->view->headLink()->appendStylesheet('/css/facultad.css');
//     $this->view->headLink()->appendStylesheet('/css/bootstrap-datepicker.css.map');
    // $this->view->headScript()->appendFile('/js/fuelux.min.js');
    // $this->view->headScript()->appendFile('/js/wizard.js');
     $this->view->headScript()->appendFile('/bootstrap/js/moment.min.js');   
     $this->view->headScript()->appendFile('/bootstrap/js/bootstrap-datepicker.js');      
     $this->view->headScript()->appendFile('/bootstrap/js/datepicker.es.min.js');
     $this->view->headScript()->appendFile('/js/jquery.dataTables.min.js');
     $this->view->headScript()->appendFile('/js/bootstrap-modal.js');
     $this->view->headScript()->appendFile('/js/practica.js');
     $this->view->headScript()->appendFile('/admin/materias.js');
     $this->view->headScript()->appendFile('/validacion/jquery.validate.min.js');
     $this->view->headScript()->appendFile('/validacion/localization/messages_es.min.js');
     $this->view->headScript()->appendFile('/validacion/additional-methods.min.js');
    }
    public function listarasignaturaAction()
    { 
       // Realizamos la consulta dql
        $dql ="select a, cod, fac, se from Application_Model_Asignaturas a join a.cod_programa cod join a.id_facultad fac join a.id_sede se";
        
       // Ejecutamos la consulta con Query
         $query = $this->em->createQuery($dql);
        
       //Resultados de la consulta en un Vector, en este caso en Array
       $asignatura = $query->getArrayResult();
       
      // Pasarle la información de programas a la vista ..
       $this->view->asignatura =$asignatura;
        
        
      
      $this->view->headLink()->appendStylesheet('/css/jquery.dataTables.min.css');
      $this->view->headLink()->appendStylesheet('/font-awesome/css/font-awesome.css');
      $this->view->headLink()->appendStylesheet('/css/facultad.css');
      $this->view->headScript()->appendFile('/js/jquery.dataTables.min.js');
      $this->view->headScript()->appendFile('/js/facultad.js');
      $this->view->headScript()->appendFile('/bootstrap/js/moment.min.js'); 
      $this->view->headScript()->appendFile('/js/bootstrap-modal.js');
      $this->view->headScript()->appendFile('/admin/materias.js');
      $this->view->headScript()->appendFile('/validacion/jquery.validate.min.js');
      $this->view->headScript()->appendFile('/validacion/additional-methods.min.js');
      $this->view->headScript()->appendFile('/validacion/bootbox.min.js');
    }
    public function guardarasignaturaAction(){
       //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->layout->disableLayout();
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->viewRenderer->setNoRender(TRUE);
    
     //Asignatura Recibe los datos por Ajax
     $asignatura= $this->_getParam('asignatura');
     $codigo= $this->_getParam('codigo');
     $grupo= $this->_getParam('grupo');
     $programa= $this->_getParam('programa');  
     $facultad= $this->_getParam('facultad');
     $sede= $this->_getParam('sede');
     
    // Instancia del modelo Facultades. crea una facultad automatico..
     $asignatura_objeto= new Application_Model_Asignaturas();
     
     // La instancia le asigna un nombre a la asignatura
     $asignatura_objeto->setnombre($asignatura);
     $asignatura_objeto->setcodigo($codigo);
     $asignatura_objeto->setgrupo($grupo);
     // Almacena en el objecto la programa que tiene el id..
     $asignatura_objeto->setcod_programa($this->em->getRepository('Application_Model_Programas')->find($programa));
     $asignatura_objeto->setid_facultad($this->em->getRepository('Application_Model_Facultades')->find($facultad));
     $asignatura_objeto->setid_sede($this->em->getRepository('Application_Model_Sedes')->find($sede));
    //var_dump($asignatura_objeto);     
    //da la orden de guardar...
     $this->em->persist($asignatura_objeto);
     //Ejecuta la Orden de guardar..
     $this->em->flush();
     
  /**    try {
     } catch (Exception $e) {
         echo $e->getMessage(); 
         
     }  */  
 
     
    }
    public function editarasignaturaAction(){
      // Realizamos la consulta dql, para que se listen los Programas, en la vista Agregar Asignatura..
        $dql ="select f from Application_Model_Programas f";
        
         // Ejecutar el Query, la variable query es donde se carga la consulta.
        $query = $this->em->createQuery($dql);
        
        //Resultados de la consulta en un Vector, en este caso en Array
        $programas = $query->getArrayResult();
        
        // Pasarle la información de programas a la vista ..
        $this->view->programas= $programas;
        //var_dump($programas);
       // Preparo la consulta
       $dql1= "select fa from Application_Model_Facultades fa";
       
       $quer1= $this->em->createQuery($dql1);
       
       $facultad = $quer1->getArrayResult();
       
       $this->view->facultad = $facultad;
       
        //Preparo la consulta de sede
       $dql3= "select s from Application_Model_Sedes s";
       
       $query3= $this->em->createQuery($dql3);
       
       $sedes = $query3->getArrayResult();
       
       $this->view->sedes= $sedes;
        //instacia para la edición del metodo editar asignatura
        $asignatura_id= $this->_getParam('id');
        
        //Preparo la consulta
       $dql2= "select a, asig, fac, se from Application_Model_Asignaturas a join a.cod_programa asig join a.id_facultad fac join a.id_sede se where a.cod_asignatura=:asignatura";
        
        // Creo el Nuevo Query
        $query2= $this->em->createQuery($dql2);
        // Donde se Guarda el Id de la Asignatura...
        
        $query2->setParameter('asignatura', $asignatura_id);
        
        //Muestre el resultado en un array
        
        $asignatura= $query2->getArrayResult();
        
        $this->view->asignaturas=$asignatura;
       // var_dump($asignatura); 
      $this->view->headLink()->appendStylesheet('/css/jquery.dataTables.min.css');
      $this->view->headLink()->appendStylesheet('/font-awesome/css/font-awesome.css');
      $this->view->headLink()->appendStylesheet('/css/facultad.css');
      $this->view->headScript()->appendFile('/js/jquery.dataTables.min.js');
      $this->view->headScript()->appendFile('/js/facultad.js');
      $this->view->headScript()->appendFile('/js/bootstrap-modal.js');
      $this->view->headScript()->appendFile('/admin/materias.js');
      $this->view->headScript()->appendFile('/validacion/jquery.validate.min.js');
      $this->view->headScript()->appendFile('/validacion/localization/messages_es.min.js');
      $this->view->headScript()->appendFile('/validacion/additional-methods.min.js');
      $this->view->headScript()->appendFile('/validacion/bootbox.min.js');
    }
     public function actualizarasignaturaAction(){
          //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->layout->disableLayout();
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->viewRenderer->setNoRender(TRUE);
     
     //Recibir id como parametro
     $id= $this->_getParam('id');
     // var_dump($id);
     //Se hace un condicional que el id es mayor que cero
     if($id>0){
      //Proceso a editar
       //$Asignatura recibe los datos que se les pasa por petición ajax
     $asignatura =$this->_getParam('asignatura'); 
     $codigo =$this->_getParam('codigo');
     $grupo =$this->_getParam('grupo');
     $programa=$this->_getParam('programa');
     $facultad =$this->_getParam('facultad');
     $sede =$this->_getParam('sede');
     //var_dump($programa);
     
    
         // Almacena en el objecto Asignatura que tiene el id..
     $asignatura_objeto = ($this->em->getRepository('Application_Model_Asignaturas')->find($id));
     //la instancia le asigna una facultad, hacer el nombre de la facultad..
     $asignatura_objeto->setnombre($asignatura);
     $asignatura_objeto->setcodigo($codigo);
     $asignatura_objeto->setgrupo($grupo);
     $asignatura_objeto->setcod_programa($this->em->getRepository('Application_Model_Programas')->find($programa));
     $asignatura_objeto->setid_facultad($this->em->getRepository('Application_Model_Facultades')->find($facultad));
     $asignatura_objeto->setid_sede($this->em->getRepository('Application_Model_Sedes')->find($sede));
    // var_dump($asignatura_objeto);
     
     //da la orden de guardar...
     $this->em->persist($asignatura_objeto);
     //Ejecuta la Orden de guardar..
     $this->em->flush();     
     }   
      $this->view->headScript()->appendFile('/admin/materias.js');  
     }
      public function eliminarasignaturaAction(){
          //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->layout->disableLayout();
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->viewRenderer->setNoRender(TRUE);
     //Recibo el dato por ajax
     try {
     $asignatura_id= $this->_getParam('asignatura_id');  
     
     $asignatura_objeto= ($this->em->getRepository('Application_Model_Asignaturas')->find($asignatura_id));
     
     // da la orden de guardar
     $this->em->remove($asignatura_objeto);
     
     //Ejecuta la Orden de Guardar
     $this->em->flush();
         
     } catch (Exception $ex) {
     header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
         
     }
           
    }
}



