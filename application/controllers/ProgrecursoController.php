<?php

class ProgrecursoController extends Zend_Controller_Action
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
    public function guardarprogrecursoAction(){
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->layout->disableLayout();
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->viewRenderer->setNoRender(TRUE);
       header('Content-Type: application/json');  
     try {
          //$facultad recibe los datos que se les pasa por petición ajax
     $valor =$this->_getParam('valor'); 
     $idrecurso =  $this->_getParam('idrecurso');
    // var_dump($idrecurso);
     
     // Instancia el modelo de programacion de recursos..
     $progrecurso_objeto = new Application_Model_Progrecursos();
     //la instancia le asigna una facultad, hacer el nombre de la facultad..
     $progrecurso_objeto->setvalor($valor);
     $progrecurso_objeto->setid_recursos($this->em->getRepository('Application_Model_Recurespeciales')->find($idrecurso));
     //da la orden de guardar...
     $this->em->persist($progrecurso_objeto);
     //Ejecuta la Orden de guardar..
     $this->em->flush(); 
     
     $json= array();
     $json['id_pro']=$progrecurso_objeto->getid_pro();
     echo Zend_Json::encode($json);  
         
     } catch (Exception $e) {
      
       echo $e->getMessage();  
     } 
        
        
    }
    public function eliminarprogrecursoAction(){
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
    public function visualizarprogrecursoAction(){
        try{
       header('Content-Type: application/json');   
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->layout->disableLayout();
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->viewRenderer->setNoRender(TRUE);  
     
     $tipo_def=$this->_getParam('tipo_def');
     
//     var_dump($tipo_def);
     
     if($tipo_def != -1){
         
     
     
     $dql=sprintf("select r, re from Application_Model_Progrecursos r join r.id_recursos re where r.id_pro in (%s)", $tipo_def);
//     var_dump($dql);
     $dql = str_replace('"', '', $dql);
//     var_dump($dql);
     
     $query = $this->em->createQuery($dql);
//     $query->setParameter('ids', $tipo_def);
     
     $recursos = $query->getArrayResult();
//     var_dump($recursos);
           //procesar array
     $tmp = array();
     foreach($recursos as $r){
        $t = array();
        $t['nombre'] = $r['id_recursos']['nombre'];
        $t['valor'] = $r['valor'];
        $t['id'] = $r['id_pro'];
        $tmp[] = $t;
     }
    
     $recursos = $tmp;     
     }
     else{
         $recursos = array();
     }
     echo Zend_Json::encode($recursos);
     
    }
    catch(Exception $e){
        echo $e->getMessage();
    }
    }
    
}



