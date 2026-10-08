<?php

class UsuariosController extends Zend_Controller_Action
{
    private $em;
    private $pw;


    public function init()
    {
        // Activar el Entity Manager
        $registry = Zend_Registry::getInstance();
        $this->em = $registry->entitymanager;
        $this->pw= $registry->powercampus_connection;
        
        $this->_helper->layout->setLayout('admin');
     //  $this->_helper->layout->setLayout('prueba'); 
        $this->view->headLink()->appendStylesheet('/font-awesome/css/font-awesome.css');
        $this->view->headLink()->appendStylesheet('/css/facultad.css');
        
        
        
    }

    public function indexAction()
    {
       // para que todo lo que este dentro de este metodo se ejecute en todas las Vistas..
    }
    
    public function agregarusuarioAction()
    { 
       //Consulta dql para listar las facultades
       /** $dql1 ="select p from Application_Model_Programas p";
        
        // Ejecutar el Query, la variable query es donde se carga la consulta.
        $query1 = $this->em->createQuery($dql1);
        
        //Resultados de la consulta en un Vector, en este caso en Array
      $programas = $query1->getArrayResult();
        
        //Imprimir en la pagina lo que esta en la variable en este caso facultades
       // var_dump($facultades);
        //Pasarle a la Vista la informción de la facultad
        $this->view->programas= $programas; */
        
            //preparo la consulta de power campus a programas
       //  $sql = "SELECT DISTINCT ID_Programa AS id, Programa AS nombre FROM V_Programas  ORDER BY Programa";
         //preparo la consulta de la base de datos Campus, de SQL Server
         $sql = "SELECT DISTINCT V_Programas.ID_Programa AS id, V_Programas.Programa AS nombre FROM V_Programas  ORDER BY Programa";
          $stmt = sqlsrv_query( $this->pw, $sql );
         $datos = array();
          while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
           $datos[]= $row;   
         // echo $row['ID'].", ".$row['Facultad']."<br />";
         //var_dump($row);
       }
      // var_dump($datos);
       sqlsrv_free_stmt( $stmt);
        
         $this->view->programas= $datos;  
        
        //
        //Consulta dql para listar las facultades
        $dql2 ="select r from Application_Model_Roles r";
        
        // Ejecutar el Query, la variable query es donde se carga la consulta.
        $query2 = $this->em->createQuery($dql2);
        
        //Resultados de la consulta en un Vector, en este caso en Array
      $roles = $query2->getArrayResult();
        
        //Imprimir en la pagina lo que esta en la variable en este caso facultades
       // var_dump($facultades);
        //Pasarle a la Vista la informción de la facultad
        $this->view->roles= $roles;
        
        
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
     $this->view->headScript()->appendFile('/admin/usuarios.js');
     $this->view->headScript()->appendFile('/validacion/jquery.validate.min.js');
     $this->view->headScript()->appendFile('/validacion/localization/messages_es.min.js');
     $this->view->headScript()->appendFile('/validacion/additional-methods.min.js');
    }
    
    public function agregaruserdepAction(){ 
       
        //
        //Consulta dql para listar las facultades
        $dql2 ="select r from Application_Model_Roles r";
        
        // Ejecutar el Query, la variable query es donde se carga la consulta.
        $query2 = $this->em->createQuery($dql2);
        
        //Resultados de la consulta en un Vector, en este caso en Array
      $roles = $query2->getArrayResult();
        
        //Imprimir en la pagina lo que esta en la variable en este caso facultades
       // var_dump($facultades);
        //Pasarle a la Vista la informción de la facultad
        $this->view->roles= $roles;
        
        
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
     $this->view->headScript()->appendFile('/admin/usuarios.js');
     $this->view->headScript()->appendFile('/validacion/jquery.validate.min.js');
     $this->view->headScript()->appendFile('/validacion/localization/messages_es.min.js');
     $this->view->headScript()->appendFile('/validacion/additional-methods.min.js');
    }
    public function listarusuarioAction()
    {  
         //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
//     $this->_helper->layout->disableLayout();
//     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
//     $this->_helper->viewRenderer->setNoRender(TRUE);
//       
          $authNamespace = new Zend_Session_Namespace('Zend_Auth');
         //saco los datos del usuario
         $usuario= $authNamespace->usuarios;
         $rol= $authNamespace->usuarios[0]['id_rol']['id_rol'];
         $this->view->rol= $rol;
        
        // Con left join salen los datos sin existir las llaves foraneas
        try {
            //Preparo la consulta 
        $dql="select u, r from Application_Model_Usuarios u left join u.id_rol r";
        
         // Ejecutar el Query, la variable query es donde se carga la consulta.
        $query = $this->em->createQuery($dql);
        
        
        
        //Resultados de la consulta en un Vector, en este caso en Array
        $usuarios = $query->getArrayResult();
        //var_dump($usuarios);
        
        // Pasarle la información de programas a la vista ..
        $this->view->usuarios= $usuarios;
      //  var_dump($usuarios);    
        } catch (Exception $ex) {
            $ex->getMessage();
        }
     /**   $sql = "SELECT DISTINCT V_Programas.ID_Programa AS id, V_Programas.Programa AS nombre FROM V_Programas  ORDER BY Programa";
          $stmt = sqlsrv_query( $this->pw, $sql, array($authNamespace->programa[0]["cod_progra_power"]));
         $datos = array();
          while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
           $datos[]= $row; 
          $row['id']= htmlentities(utf8_encode($row['id'])); 
          $row['nombre']= htmlentities(utf8_encode($row['nombre']));
         //var_dump($row);
       }
      // var_dump($datos);
       sqlsrv_free_stmt( $stmt);
        
         $this->view->programas= $datos;  */
       //  var_dump($datos);
      
      $this->view->headLink()->appendStylesheet('/css/jquery.dataTables.min.css');
      $this->view->headLink()->appendStylesheet('/font-awesome/css/font-awesome.css');
      $this->view->headLink()->appendStylesheet('/css/facultad.css');
      $this->view->headScript()->appendFile('/js/jquery.dataTables.min.js');
      $this->view->headScript()->appendFile('/js/facultad.js');
      $this->view->headScript()->appendFile('/js/bootstrap-modal.js');
      $this->view->headScript()->appendFile('/admin/usuarios.js');
      $this->view->headScript()->appendFile('/validacion/jquery.validate.min.js');
      $this->view->headScript()->appendFile('/validacion/localization/messages_es.min.js');
      $this->view->headScript()->appendFile('/validacion/additional-methods.min.js');
      $this->view->headScript()->appendFile('/validacion/bootbox.min.js');
    }
   public function guardarusuarioAction(){
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->layout->disableLayout();
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->viewRenderer->setNoRender(TRUE);
     
     //$usuario recibe los datos que se les pasa por petición ajax
     $nom =$this->_getParam('nom');
     $ape =$this->_getParam('ape');
     $ide =$this->_getParam('ide');
     $correo =$this->_getParam('correo');
     $usuario =$this->_getParam('usuario');
     $pass =$this->_getParam('pass');
     //var_dump($pass);
     $programa =$this->_getParam('programa');
     $rol =$this->_getParam('rol');
      // var_dump($facultad);
         // Instancia del modelo Facultades. crea una facultad automatico..
     $usuario_objeto = new Application_Model_Usuarios();
     //la instancia le asigna una facultad, hacer el nombre de la facultad..
     $usuario_objeto->setnombre(htmlentities($nom));
     $usuario_objeto->setapellidos(htmlentities($ape));
     $usuario_objeto->setidentificacion($ide);
     $usuario_objeto->setcorreo($correo);
     $usuario_objeto->setusuario(htmlentities($usuario));
     $usuario_objeto->setcontrasena(hash('sha256', $pass));
     $usuario_objeto->setcod_progra_power($programa);
     $usuario_objeto->setid_rol($this->em->getRepository('Application_Model_Roles')->find($rol));
         
    
     // Almacena en el objecto la usuario que tiene el id..
    // var_dump($usuario_objeto);     
    //da la orden de guardar...
   $this->em->persist($usuario_objeto);
     //Ejecuta la Orden de guardar..
     $this->em->flush(); 
     
     //capturar excepciones
   /**  try {
     } catch (Exception $e) {
         echo $e->getMessage();
     } */
     
   }
   public function guardaruserdepAction(){
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->layout->disableLayout();
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->viewRenderer->setNoRender(TRUE);
     
    
    
     //$usuario recibe los datos que se les pasa por petición ajax
     $nom =$this->_getParam('nom');
     $ape =$this->_getParam('ape');
     $ide =$this->_getParam('ide');
     $correo =$this->_getParam('correo');
     $usuario =$this->_getParam('usuario');
     $pass =$this->_getParam('pass');
     //var_dump($pass);
     $rol =$this->_getParam('rol');
      // var_dump($facultad);
         // Instancia del modelo Facultades. crea una facultad automatico..
     $usuariodep_objeto = new Application_Model_Usuarios();
     //la instancia le asigna una facultad, hacer el nombre de la facultad..
     $usuariodep_objeto->setnombre(htmlentities($nom));
     $usuariodep_objeto->setapellidos(htmlentities($ape));
     $usuariodep_objeto->setidentificacion($ide);
     $usuariodep_objeto->setcorreo($correo);
     $usuariodep_objeto->setusuario(htmlentities($usuario));
     $usuariodep_objeto->setcontrasena(hash('sha256', $pass));
     $usuariodep_objeto->setid_rol($this->em->getRepository('Application_Model_Roles')->find($rol));
     
      $this->em->persist($usuariodep_objeto);
     //Ejecuta la Orden de guardar..
      $this->em->flush(); 
    
     // Almacena en el objecto la usuario que tiene el id..
    // var_dump($usuario_objeto);     
    //da la orden de guardar...
  
     
     //capturar excepciones
   /**  try {
     } catch (Exception $e) {
         echo $e->getMessage();
     } */
     
   }
    public function editarusuarioAction(){ 
        
        try {
              $sql = "SELECT DISTINCT V_Programas.ID_Programa AS id, V_Programas.Programa AS nombre FROM V_Programas  ORDER BY Programa";
          $stmt = sqlsrv_query( $this->pw, $sql );
         $datos = array();
          while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
           $datos[]= $row;   
         // echo $row['ID'].", ".$row['Facultad']."<br />";
         //var_dump($row);
       }
      // var_dump($datos);
       sqlsrv_free_stmt( $stmt);
        
         $this->view->programas= $datos;  
        // var_dump($datos);
         
         //Consulta dql para listar las Roles
        $dql4 ="select r from Application_Model_Roles r";
        
        // Ejecutar el Query, la variable query es donde se carga la consulta.
        $query4 = $this->em->createQuery($dql4);
        
        //Resultados de la consulta en un Vector, en este caso en Array
       $roles = $query4->getArrayResult();
      // var_dump($roles);
        //Imprimir en la pagina lo que esta en la variable en este caso facultades
       // var_dump($facultades);
        //Pasarle a la Vista la informción de la facultad
        $this->view->roles= $roles;
       // var_dump($roles);
        
        $usuario_id =$this->_getParam('id');
       //Preparo la consulta 
        $dql6="select u, r from Application_Model_Usuarios u left join u.id_rol r where u.id_usuario=:usuario";
        
         // Ejecutar el Query, la variable query es donde se carga la consulta.
        $query6 = $this->em->createQuery($dql6);
        
        $query6->setParameter('usuario', $usuario_id);
        
        //Resultados de la consulta en un Vector, en este caso en Array
        $usuarios = $query6->getArrayResult();
        //var_dump($usuarios);
        
        // Pasarle la información de programas a la vista ..
        $this->view->usuarios= $usuarios; 
      //  var_dump($usuarios);
        
        } catch (Exception $ex) {
            $ex->getMessage();
        }
       //Consulta dql para listar las facultades
       
        
       /**   try{ 
    
     } catch (Exception $e) {
         echo $e->getMessage();
     }  */
    
      
        
        
        
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
     $this->view->headScript()->appendFile('/admin/usuarios.js');
     $this->view->headScript()->appendFile('/validacion/jquery.validate.min.js');
     $this->view->headScript()->appendFile('/validacion/localization/messages_es.min.js');
     $this->view->headScript()->appendFile('/validacion/additional-methods.min.js');
     $this->view->headScript()->appendFile('/validacion/bootbox.min.js');
    }  
     public function actualizarusuarioAction(){
          //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->layout->disableLayout();
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->viewRenderer->setNoRender(TRUE);
     
     //Recibir id como parametro
     $id= $this->_getParam('id'); 
     
     //Se hace un condicional que el id es mayo que cero
     if($id>0){
     //$usuario recibe los datos que se les pasa por petición ajax
     $nom =$this->_getParam('nom');
     $ape =$this->_getParam('ape');
     $ide =$this->_getParam('ide');
     $correo =$this->_getParam('correo');
     $usuario =$this->_getParam('usuario');
    // $pass =$this->_getParam('pass');
     $programa =$this->_getParam('programa');
     $rol =$this->_getParam('rol');
     
     // Almacena en el objecto usuario que tiene el id..
     $usuario_objeto= ($this->em->getRepository('Application_Model_Usuarios')->find($id));
     $usuario_objeto->setnombre($nom);
     $usuario_objeto->setapellidos($ape);
     $usuario_objeto->setidentificacion($ide);
     $usuario_objeto->setcorreo($correo);
     $usuario_objeto->setusuario($usuario);
     $usuario_objeto->setcod_programa($this->em->getRepository('Application_Model_Programas')->find($programa));
     $usuario_objeto->setid_rol($this->em->getRepository('Application_Model_Roles')->find($rol));
    // var_dump($usuario_objeto);
     
     $this->em->persist($usuario_objeto);
     //Ejecuta la Orden de guardar..
     $this->em->flush();
     } 
   $this->view->headScript()->appendFile('/admin/usuarios.js');
          
    }
    public function resetearusuarioAction(){
      
     
        $usuario_id =$this->_getParam('id');
       //Preparo la consulta 
        $dql="select u from Application_Model_Usuarios u where u.id_usuario=:usuario";
        
         // Ejecutar el Query, la variable query es donde se carga la consulta.
        $query = $this->em->createQuery($dql);
        
        $query->setParameter('usuario', $usuario_id);
        
        //Resultados de la consulta en un Vector, en este caso en Array
        $usuarios = $query->getArrayResult();
        //var_dump($usuarios);
        
        // Pasarle la información de programas a la vista ..
        $this->view->usuarios= $usuarios; 
       //Consulta dql para listar las facultades 
    /**  try{ 
     } catch (Exception $e) {
         echo $e->getMessage();
     } */
      
        
    //Librerias de la vista resear Usuario....    
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
     $this->view->headScript()->appendFile('/admin/usuarios.js');
     $this->view->headScript()->appendFile('/validacion/jquery.validate.min.js');
     $this->view->headScript()->appendFile('/validacion/localization/messages_es.min.js');
     $this->view->headScript()->appendFile('/validacion/additional-methods.min.js');
     $this->view->headScript()->appendFile('/validacion/bootbox.min.js');
        
    }
    public function actualizarresAction(){
      $this->_helper->layout->disableLayout();
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->viewRenderer->setNoRender(TRUE);
     
     //recibo los datos por petición Ajax
     $id= $this->_getParam('id'); 
     
     //Se hace un condicional que el id es mayo que cero
     if($id>0){
     //$usuario recibe los datos que se les pasa por petición ajax
     
     $pass =$this->_getParam('pass');
     $pas =$this->_getParam('pas');
    // var_dump($pas);
     $pa =  $this->_getParam('pa');
    // var_dump($pa);
     
     //Armo el query consulta la contraseña de la base de datos
      $dql="select u from Application_Model_Usuarios u where u.id_usuario=:usuario";
        
         // Ejecutar el Query, la variable query es donde se carga la consulta.
        $query = $this->em->createQuery($dql);
        
        $query->setParameter('usuario', $id);
        
       $usuarios = $query->getArrayResult();
       //la mejor forma de saber la estructura de un vector.
      // var_dump($usuarios);
       $pas_actual= $usuarios[0]['contrasena'];
      // var_dump($pass);
       $pas_ingresa= hash('sha256', $pass);
      // var_dump($pas_actual);
       var_dump($pas);
       var_dump($pa);
       if($pas_actual == $pas_ingresa && $pas == $pa){
           try {
                // Almacena en el objecto usuario que tiene el id..
        $usuario_objeto= ($this->em->getRepository('Application_Model_Usuarios')->find($id));
        $usuario_objeto->setcontrasena(hash('sha256', $pas));
       
       // var_dump('hola');
   
    // var_dump($usuario_objeto);
     
     $this->em->persist($usuario_objeto);
     //Ejecuta la Orden de guardar..
      $this->em->flush(); 
               
           } catch (Exception $e) {
               echo $e->get_message(); 
           }
           
       }else{
          header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500); 
       }
        }
      $this->view->headScript()->appendFile('/admin/usuarios.js');
    }
    //reseteo de contraseñas por el Administrador
    public function nuevacontrasenaAction(){
        
        $usuario_id =$this->_getParam('id');
       //Preparo la consulta 
        $dql="select u from Application_Model_Usuarios u where u.id_usuario=:usuario";
        
         // Ejecutar el Query, la variable query es donde se carga la consulta.
        $query = $this->em->createQuery($dql);
        
        $query->setParameter('usuario', $usuario_id);
        
        //Resultados de la consulta en un Vector, en este caso en Array
        $usuarios = $query->getArrayResult();
       // var_dump($usuarios);
        
        // Pasarle la información de programas a la vista ..
        $this->view->usuarios= $usuarios;
        
        
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
     $this->view->headScript()->appendFile('/admin/usuarios.js');
     $this->view->headScript()->appendFile('/validacion/jquery.validate.min.js');
     $this->view->headScript()->appendFile('/validacion/localization/messages_es.min.js');
     $this->view->headScript()->appendFile('/validacion/additional-methods.min.js');
     $this->view->headScript()->appendFile('/validacion/bootbox.min.js');
        
    }
    //Actualizar nueva contraseña
    public function actualizarcontrasenaAction(){
     $this->_helper->layout->disableLayout();
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->viewRenderer->setNoRender(TRUE);
     
      $id= $this->_getParam('id'); 
     
     //Se hace un condicional que el id es mayo que cero
     if($id>0){
     //$usuario recibe los datos que se les pasa por petición ajax
     
     
  
     $pas =$this->_getParam('pas');
     
     //Armo el query consulta la contraseña de la base de datos
      $dql="select u from Application_Model_Usuarios u where u.id_usuario=:usuario";
        
         // Ejecutar el Query, la variable query es donde se carga la consulta.
        $query = $this->em->createQuery($dql);
        
        $query->setParameter('usuario', $id);
      
   
          // Almacena en el objecto usuario que tiene el id..
        $usuario_objeto= ($this->em->getRepository('Application_Model_Usuarios')->find($id));
        $usuario_objeto->setcontrasena(hash('sha256', $pas));
    
        // var_dump($usuario_objeto);
     
   // $this->em->persist($usuario_objeto);
     //Ejecuta la Orden de guardar..
   //   $this->em->flush(); 
              
    }
     $this->view->headScript()->appendFile('/admin/usuarios.js');
        
        
    }



    public function eliminarusuarioAction(){
          //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->layout->disableLayout();
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->viewRenderer->setNoRender(TRUE);
     //Recibo el dato por ajax
     try {
     $usuario_id= $this->_getParam('usuario_id');  
     
     $usuario_objeto= ($this->em->getRepository('Application_Model_Usuarios')->find($usuario_id));
     
     // da la orden de guardar
     $this->em->remove($usuario_objeto);
     
     //Ejecuta la Orden de Guardar
     $this->em->flush();
         
     } catch (Exception $ex) {
     header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
         
     }
           
    }

}



