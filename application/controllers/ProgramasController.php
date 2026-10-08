<?php

class ProgramasController extends Zend_Controller_Action
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
    
    public function agregarprogramaAction()
    { 
       //Consulta dql para listar las facultades
        $dql ="select f from Application_Model_Facultades f";
        
        // Ejecutar el Query, la variable query es donde se carga la consulta.
        $query = $this->em->createQuery($dql);
        
        //Resultados de la consulta en un Vector, en este caso en Array
        $facultades = $query->getArrayResult();
        
        //Imprimir en la pagina lo que esta en la variable en este caso facultades
       // var_dump($facultades);
        //Pasarle a la Vista la informción de la facultad
        $this->view->facultades= $facultades;
        
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
     $this->view->headScript()->appendFile('/admin/programas.js');
     $this->view->headScript()->appendFile('/validacion/jquery.validate.min.js');
     $this->view->headScript()->appendFile('/validacion/localization/messages_es.min.js');
     $this->view->headScript()->appendFile('/validacion/additional-methods.min.js');
    }
    public function listarprogramaAction()
    { 
        // Realizamos la consulta dql
        $dql ="select p, f from Application_Model_Programas p join p.cod_facultad f";
        
         // Ejecutar el Query, la variable query es donde se carga la consulta.
        $query = $this->em->createQuery($dql);
        
        //Resultados de la consulta en un Vector, en este caso en Array
        $programas = $query->getArrayResult();
        
        // Pasarle la información de programas a la vista ..
        $this->view->programas= $programas;
        
      
      $this->view->headLink()->appendStylesheet('/css/jquery.dataTables.min.css');
      $this->view->headLink()->appendStylesheet('/font-awesome/css/font-awesome.css');
      $this->view->headLink()->appendStylesheet('/css/facultad.css');
      $this->view->headScript()->appendFile('/js/jquery.dataTables.min.js');
      $this->view->headScript()->appendFile('/js/facultad.js');
      $this->view->headScript()->appendFile('/js/bootstrap-modal.js');
      $this->view->headScript()->appendFile('/admin/programas.js');
      $this->view->headScript()->appendFile('/validacion/jquery.validate.min.js');
      $this->view->headScript()->appendFile('/validacion/localization/messages_es.min.js');
      $this->view->headScript()->appendFile('/validacion/additional-methods.min.js');
      $this->view->headScript()->appendFile('/validacion/bootbox.min.js');
    }
   public function guardarprogramaAction(){
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->layout->disableLayout();
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->viewRenderer->setNoRender(TRUE);
     
     //$facultad recibe los datos que se les pasa por petición ajax
     $programa =$this->_getParam('programa');  
   
     $facultad =$this->_getParam('facultad');
      // var_dump($facultad);
         // Instancia del modelo Facultades. crea una facultad automatico..
     $programa_objeto = new Application_Model_Programas();
     //la instancia le asigna una facultad, hacer el nombre de la facultad..
     $programa_objeto->setnombre($programa);
     // Almacena en el objecto la facultad que tiene el id..
     $programa_objeto->setcod_facultad($this->em->getRepository('Application_Model_Facultades')->find($facultad));
    // var_dump($programa_objeto);     
    //da la orden de guardar...
    $this->em->persist($programa_objeto);
     //Ejecuta la Orden de guardar..
     $this->em->flush(); 
     
     //capturar excepciones
   /**  try {
     } catch (Exception $e) {
         echo $e->getMessage();
     }*/
     
   }
    public function editarprogramaAction()
    { 
       
        
       //Consulta dql para listar las facultades
        $dql ="select f from Application_Model_Facultades f";
        
        // Ejecutar el Query, la variable query es donde se carga la consulta.
        $query = $this->em->createQuery($dql);
        
        //Resultados de la consulta en un Vector, en este caso en Array
        $facultades = $query->getArrayResult();
        
        //Imprimir en la pagina lo que esta en la variable en este caso facultades
        // var_dump($facultades);
        //Pasarle a la Vista la informción de la facultad
        $this->view->facultades= $facultades;
       
       // Pasarle la información de programas a la vista ..
        // $this->view->programas= $programas;
        
        
            //Codigo de editar programas
        $programa_id =$this->_getParam('id');
       // var_dump($programa_id);
        //Preparo la consulta 
        $dql2="select f, fac from Application_Model_Programas f join f.cod_facultad fac where f.id_programa=:programa";
        // Creo un Nuevo Query donde se guarda la consulta.
        $query2= $this->em->createQuery($dql2);
        //Donde se guarda el id del Programa...
        $query2->setParameter('programa', $programa_id);
       // var_dump($query);
        //Muestre el resultado en un array
        $programa=  $query2->getArrayResult();
        
       // var_dump();
        
        /**   try{ 
    
     } catch (Exception $e) {
         echo $e->getMessage();
     }  */
    
        $this->view->programa= $programa;
        
        
        
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
     $this->view->headScript()->appendFile('/admin/programas.js');
     $this->view->headScript()->appendFile('/validacion/jquery.validate.min.js');
     $this->view->headScript()->appendFile('/validacion/localization/messages_es.min.js');
     $this->view->headScript()->appendFile('/validacion/additional-methods.min.js');
     $this->view->headScript()->appendFile('/validacion/bootbox.min.js');
    }
     public function actualizarprogramaAction(){
          //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->layout->disableLayout();
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->viewRenderer->setNoRender(TRUE);
     
     //Recibir id como parametro
     $id= $this->_getParam('id');   
     //Se hace un condicional que el id es mayo que cero
     if($id>0){
      //Proceso a editar
       //$facultad recibe los datos que se les pasa por petición ajax
     $programa =$this->_getParam('programa');  
     //var_dump($programa);
     //Nombre de la facultad donde esta asociada la llave foranea...
     $facultad =  $this->_getParam('facultad');
     
     // Almacena en el objecto Programa que tiene el id..
    $programa_objeto = ($this->em->getRepository('Application_Model_Programas')->find($id));
     //la instancia le asigna una facultad, hacer el nombre de la facultad..
     $programa_objeto->setnombre($programa);
     //da la orden de guardar...
     $programa_objeto->setcod_facultad($this->em->getRepository('Application_Model_Facultades')->find($facultad));
             
     $this->em->persist($programa_objeto);
     //Ejecuta la Orden de guardar..
     $this->em->flush();
     
     $this->view->headScript()->appendFile('/admin/programas.js');
     }      
    }
     public function eliminarprogramaAction(){
          //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->layout->disableLayout();
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->viewRenderer->setNoRender(TRUE);
     //Recibo el dato por ajax
     try {
     $programa_id= $this->_getParam('programa_id');  
     
     $programa_objeto= ($this->em->getRepository('Application_Model_Programas')->find($programa_id));
     
     // da la orden de guardar
     $this->em->remove($programa_objeto);
     
     //Ejecuta la Orden de Guardar
     $this->em->flush();
         
     } catch (Exception $ex) {
     header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
         
     }
           
    }

}



