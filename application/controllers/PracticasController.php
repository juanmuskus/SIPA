 <?php

class PracticasController extends Zend_Controller_Action
{
    // Entity Manager
    private $em;
    private $pw;
    private $ka;

    public function init()
    {
        $this->_helper->layout->setLayout('layout');
        $this->view->headLink()->appendStylesheet('/font-awesome/css/font-awesome.css');
         $this->view->headLink()->appendStylesheet('/css/facultad.css');
        /* Initialize action controller here */
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
    
    public function agregarpracticaAction(){ 
     //Mantego la sesion en la pagina de agregar practica
      // $authNamespace = new Zend_Session_Namespace('Zend_Auth');
     // llamo la session
   
         $authNamespace = new Zend_Session_Namespace('Zend_Auth');
         //saco los datos del usuario
         $usuario= $authNamespace->usuarios;
         $rol= $authNamespace->usuarios[0]['id_rol']['id_rol'];
         $this->view->rol= $rol;
       //  var_dump($rol);
        // var_dump($rol);
        // var_dump($rol);
    
      
        //Realizamos la consulta dql, para que me liste los participantes docentes...
    /**    $dql1= "select p from Application_Model_Participantes p where p.tipo_participante=:docente";
         
         // Ejecutar el Query, la variable query es donde se carga la consulta.
        $query1 = $this->em->createQuery($dql1);
        $query1->setParameter('docente', 'docente'); 
        //Resultados de la consulta en un Vector, en este caso en Array
         $participantes = $query1->getArrayResult();
       // var_dump($participantes);
        // Pasarle la información de programas a la vista..
        $this->view->participantes= $participantes;  */
        
        
        //realizamos una consulta dql, para que se listen los participantes auxiliares
        $dql2= "select p from Application_Model_Participantes p where p.tipo_participante=:auxiliar";
         // Ejecutar el Query, la variable query es donde se carga la consulta.
        $query2 = $this->em->createQuery($dql2);
        $query2->setParameter('auxiliar', 'auxiliar'); 
        //Resultados de la consulta en un Vector, en este caso en Array
         $participantess = $query2->getArrayResult();
       // var_dump($participantes);
        // Pasarle la información de programas a la vista..
        $this->view->participantess= $participantess;
        
         //Realizamos Una Consulta dql, Para que listen los participantes Asesores
         $dql3= "select p from Application_Model_Participantes p where p.tipo_participante=:asesor";
         // Ejecutar el Query, la variable query es donde se carga la consulta.
        $query3 = $this->em->createQuery($dql3);
        $query3->setParameter('asesor', 'asesor'); 
        //Resultados de la consulta en un Vector, en este caso en Array
         $participante = $query3->getArrayResult();
       // var_dump($participantes);
        // Pasarle la información de programas a la vista..
        $this->view->participante= $participante;
        //visualizo los docentes responsables
        $docentes= array();
        //CONEXION LOCAL
        $sql = "SELECT DISTINCT VIEW_SIPA.cod_empl AS cod, VIEW_SIPA.ape_empl AS ape, VIEW_SIPA.nom_empl AS nom FROM VIEW_SIPA ORDER BY VIEW_SIPA.ape_empl";
      //  $sql = "SELECT DISTINCT KACTUS.dbo.VIEW_SIPA.ape_empl AS ape, KACTUS.dbo.VIEW_SIPA.nom_empl AS nom FROM KACTUS.dbo.VIEW_SIPA ORDER BY ape_empl";
          $stmt = sqlsrv_query( $this->ka, $sql);
          //var_dump($sql);
          while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
              //para quitar las tildes
          $row['cod']= htmlentities(utf8_encode($row['cod']));    
          $row['ape']= htmlentities(utf8_encode($row['ape']));
          $row['nom']= htmlentities(utf8_encode($row['nom']));
         // $row['Id_Programa']= htmlentities(utf8_encode($row['Id_Programa']));
          $docentes[]= $row;   
         // var_dump($row);
          // $row['ID_Facultad'].", ".$row['Facultad'].", ".$row['Departamento'].", ".$row['Programa'].", ".$row['ID_Departamento']."<br />";
         // var_dump($row);
       }
       sqlsrv_free_stmt( $stmt);
       $this->view->docentes= $docentes; 
       //.................................//
        // var_dump($docentes);
        
        // var_dump($datos);
        
         //hago un condicional
         if($rol == 1){
            //preparo la consulta de sistema power campus
       //  $sql = "SELECT V_Facultades.ID AS id_facultad, V_Facultades.Facultad AS nombre  FROM V_Facultades  ORDER BY ID";
          //base de datos Local
          $sql="SELECT V_Facultades.ID AS id_facultad, V_Facultades.Facultad AS nombre FROM V_Facultades ORDER BY ID";
         // var_dump($sql);
         $stmt = sqlsrv_query($this->pw, $sql);
         $datos = array();
         while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
         $datos[]= $row;   
         // echo $row['ID'].", ".$row['Facultad']."<br />";
         //var_dump($row);
       }
       sqlsrv_free_stmt( $stmt);
       
       $this->view->facultad= $datos;   
      
         }else {
             if($rol== 2){
         $datoss = array(); 
         // var_dump($datoss);
          //preparo la consulta para obtener la facultad asociada al programa..
        // $sql = "SELECT DISTINCT V_Facultades.Facultad as nombre, V_Facultades.ID as id_facultad FROM V_Departamentos INNER JOIN  V_Facultades ON V_Departamentos.ID_Facultad=V_Facultades.ID INNER JOIN V_Programas ON V_Departamentos.ID_Departamento=V_Programas.ID_Departamento where V_Programas.ID_Programa= ?";
          $sql = "SELECT DISTINCT V_Facultades.Facultad as nombre, V_Facultades.ID as id_facultad, V_Departamentos.ID_Departamento AS id_dep, V_Departamentos.Departamento AS dep, V_Programas.ID_Programa AS id_pro, V_Programas.Programa AS pro FROM V_Departamentos INNER JOIN  V_Facultades ON V_Departamentos.ID_Facultad=V_Facultades.ID INNER JOIN V_Programas ON V_Departamentos.ID_Departamento=V_Programas.ID_Departamento where V_Programas.ID_Programa= ?";
          $stmt = sqlsrv_query( $this->pw, $sql, array($authNamespace->programa[0]["cod_progra_power"]));
        // $authNamespace->programa;
       //  var_dump($authNamespace->programa[0]["cod_progra_power"]);
          while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
          
          $row['id_facultad']= htmlentities(utf8_encode($row['id_facultad']));  
          $row['nombre']= htmlentities(utf8_encode($row['nombre']));
          $row['id_dep']= htmlentities(utf8_encode($row['id_dep']));
          $row['dep']= htmlentities(utf8_encode($row['dep']));
          $row['id_pro']= htmlentities(utf8_encode($row['id_pro']));
          $row['pro']= htmlentities(utf8_encode($row['pro']));
         
           $datoss[]= $row;   
         // echo $row['ID'].", ".$row['Facultad']."<br />";
         //var_dump($row);
       }
      // var_dump($datos);
       sqlsrv_free_stmt( $stmt);
        
         $this->view->facultad= $datoss;
       //  var_dump($datoss);
         //var_dump($rol);
       
        // var_dump($rol);           
             }
             } 
         
        
        
 
        // Preparo la consulta de Asignaturas
        $dql5= "select a from Application_Model_Asignaturas a";
         // Ejecutamos la consulta con Query
         $query5 = $this->em->createQuery($dql5);
        
       //Resultados de la consulta en un Vector, en este caso en Array
       $asignatura = $query5->getArrayResult();
       
      // Pasarle la información de programas a la vista ..
       $this->view->asignatura =$asignatura;
       
       try {
           //Preparo la consulta del calendario activo dql
      $dql6= "select c, a, p from Application_Model_calendar c left join c.id_annio a left join c.id_periodo p where c.estado=:estado";                                                                                      
       
      // $dql6= "select c, a, p from Application_Model_calendar c left join c.id_annio a left join c.id_periodo p where c.id=:id";
       $query6 = $this->em->createQuery($dql6);
       
//       $query6->setParameter('id', 'id');
       $query6->setParameter('estado', '1');
       
       //muestre el resultado en un array...
      $calendario =$query6->getArrayResult();
      
      //Pasarle a la Vista la informción de la Calendario
      $this->view->calendario= $calendario;
    //  var_dump($calendario);
           
       } catch (Exception $ex) {
         $ex->getMessage();  
           
       }
      
        //Preparo la consulta dql
      $dql7= "select r from Application_Model_Rutas r";
       
       $query7 = $this->em->createQuery($dql7);
       
       //muestre el resultado en un array...
      $rutas =$query7->getArrayResult();
      
      //Pasarle a la Vista la informción de la Calendario
      $this->view->rutas= $rutas; 
      
        //Preparo la consulta dql
      $dql8= "select r from Application_Model_Recurespeciales r";
       
       $query8 = $this->em->createQuery($dql8);
       
       //muestre el resultado en un array...
      $recursos =$query8->getArrayResult();
      
      //Pasarle a la Vista la informción de la Calendario
      $this->view->recursos= $recursos; 
        
   
       
        
        
     $this->view->headLink()->appendStylesheet('/css/bootstrap-datepicker.min.css'); 
     $this->view->headLink()->appendStylesheet('/css/fuelux.min.css'); 
     $this->view->headLink()->appendStylesheet('/css/jquery.dataTables.min.css');
     $this->view->headLink()->appendStylesheet('/css/font-awesome.min.css');
     $this->view->headLink()->appendStylesheet('/css/font-face.css');
      $this->view->headLink()->appendStylesheet('/font-awesome/css/font-awesome.css');
//     $this->view->headLink()->appendStylesheet('/css/bootstrap-datepicker.css.map');
     $this->view->headScript()->appendFile('/js/fuelux.min.js');
     $this->view->headScript()->appendFile('/js/wizard.js');
     $this->view->headScript()->appendFile('/bootstrap/js/moment.min.js');   
     $this->view->headScript()->appendFile('/bootstrap/js/bootstrap-datepicker.js');      
     $this->view->headScript()->appendFile('/bootstrap/js/datepicker.es.min.js');
     $this->view->headScript()->appendFile('/js/practica.js');
     $this->view->headScript()->appendFile('/admin/practicas.js');
     $this->view->headScript()->appendFile('/practica/participantes.js');
     $this->view->headScript()->appendFile('/practica/progrecurso.js');
     $this->view->headScript()->appendFile('/js/jquery.dataTables.min.js');
     $this->view->headScript()->appendFile('/js/bootstrap-modal.js');
     $this->view->headScript()->appendFile('/validacion/jquery.validate.min.js');
     $this->view->headScript()->appendFile('/validacion/localization/messages_es.min.js');
     $this->view->headScript()->appendFile('/validacion/additional-methods.min.js');
     $this->view->headScript()->appendFile('/validacion/bootbox.min.js');

    }
    public function listarpracticaAction(){ 
        try {
             // llamo la session
         $authNamespace = new Zend_Session_Namespace('Zend_Auth');
         //saco los datos del usuario
         $usuario= $authNamespace->usuarios;
         $rol= $authNamespace->usuarios[0]['id_rol']['id_rol'];
         
         $this->view->rol= $rol;
        
    //preparo la consulta, para extraer la información de la tabla práctica..
         
       // $dql= "select p, pro, pa, cal, from Application_Model_Practicas p join p.programaciones pro join pro.participantes pa join p.id_calendario cal order by p.cod_practica";
       try {
        $dql="select p, cal, liq from Application_Model_Practicas p join p.id_calendario cal left join p.liquidarpractica liq";
        
        $query = $this->em->createQuery($dql);
        
        //Resultados de la consulta en un Vector, en este caso en Array
        $practicas = $query->getArrayResult();   
        //Pasarle a la Vista la informción a listar práctica
        $this->view->practicas= $practicas;
       // var_dump($practicas);
       // var_dump($practicas);
       } catch (Exception $e) {
         echo $e->getMessage();  
       }
        
     //preparo la consulta, para extraer la información de la tabla práctica..
        $dql1= "select pro from Application_Model_Programacion pro";
        
        $query1 = $this->em->createQuery($dql1);
        
        //Resultados de la consulta en un Vector, en este caso en Array
        $programacion = $query1->getArrayResult();   
        //Pasarle a la Vista la informción a listar programacion
        $this->view->programacion= $programacion;  
        
    /**     $dql2= "select p from Application_Model_Participantes p where p.tipo_participante=:docente";
         
         // Ejecutar el Query, la variable query es donde se carga la consulta.
        $query2 = $this->em->createQuery($dql2);
        $query2->setParameter('docente', 'docente'); 
        //Resultados de la consulta en un Vector, en este caso en Array
         $participantes = $query2->getArrayResult();
       // var_dump($participantes);
        // Pasarle la información de programas a la vista..
        $this->view->participantes= $participantes; */
        
        
        //realizamos una consulta dql, para que se listen los participantes auxiliares
        $dql3= "select p from Application_Model_Participantes p where p.tipo_participante=:auxiliar";
         // Ejecutar el Query, la variable query es donde se carga la consulta.
        $query3 = $this->em->createQuery($dql3);
        $query3->setParameter('auxiliar', 'auxiliar'); 
        //Resultados de la consulta en un Vector, en este caso en Array
         $participantess = $query3->getArrayResult();
       // var_dump($participantes);
        // Pasarle la información de programas a la vista..
        $this->view->participantess= $participantess;
        
         //Realizamos Una Consulta dql, Para que listen los participantes Asesores
         $dql4= "select p from Application_Model_Participantes p where p.tipo_participante=:asesor";
         // Ejecutar el Query, la variable query es donde se carga la consulta.
        $query4 = $this->em->createQuery($dql4);
        $query4->setParameter('asesor', 'asesor'); 
        //Resultados de la consulta en un Vector, en este caso en Array
         $participante = $query4->getArrayResult();
       // var_dump($participantes);
        // Pasarle la información de programas a la vista..
        $this->view->participante= $participante;
        
        //codigo de la liquidación de prácticas
        $dql5= "select l, pra from Application_Model_LiquidarPractica l join l.cod_practica pra";
        
        $query5 = $this->em->createQuery($dql5);
        
        $liquidarpractica = $query5->getArrayResult();
        
        $this->view->liquidarpractica= $liquidarpractica;
       // var_dump($liquidarpractica);
            
        } catch (Exception $ex) {
            $ex->getMessage();
            
        }
        // query de docentes
        $docentes= array();
        //CONEXION LOCAL
        $sql = "SELECT VIEW_SIPA.cod_empl AS cod, VIEW_SIPA.ape_empl AS ape, VIEW_SIPA.nom_empl AS nom, VIEW_SIPA.tel_empl AS tel FROM KACTUS.dbo.VIEW_SIPA WHERE cod_empl= ?";
      //  $sql = "SELECT DISTINCT KACTUS.dbo.VIEW_SIPA.ape_empl AS ape, KACTUS.dbo.VIEW_SIPA.nom_empl AS nom FROM KACTUS.dbo.VIEW_SIPA ORDER BY ape_empl";
          $stmt = sqlsrv_query( $this->ka, $sql, array($practicas[0]['nom_solicitante']));
          //var_dump($sql);
          while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
              //para quitar las tildes
          $row['cod']= htmlentities(utf8_encode($row['cod']));    
          $row['ape']= htmlentities(utf8_encode($row['ape']));
          $row['nom']= htmlentities(utf8_encode($row['nom']));
          $row['tel']= htmlentities(utf8_encode($row['tel']));
         // $row['Id_Programa']= htmlentities(utf8_encode($row['Id_Programa']));
          $docentes[]= $row;   
         // var_dump($row);
          // $row['ID_Facultad'].", ".$row['Facultad'].", ".$row['Departamento'].", ".$row['Programa'].", ".$row['ID_Departamento']."<br />";
         // var_dump($row);
       }
       sqlsrv_free_stmt( $stmt);
       $this->view->docentes= $docentes;
         
        
                
     
     
     $this->view->headLink()->appendStylesheet('/css/jquery.dataTables.min.css');
     $this->view->headLink()->appendStylesheet('/css/font-awesome.min.css');
     $this->view->headLink()->appendStylesheet('/css/practica.css');
     $this->view->headScript()->appendFile('/js/practica.js');
     $this->view->headScript()->appendFile('/admin/practicas.js');
     $this->view->headScript()->appendFile('/js/jquery.dataTables.min.js');
     $this->view->headScript()->appendFile('/js/bootstrap-modal.js');
     $this->view->headScript()->appendFile('/validacion/jquery.validate.min.js');
     $this->view->headScript()->appendFile('/validacion/localization/messages_es.min.js');
     $this->view->headScript()->appendFile('/validacion/additional-methods.min.js');
     $this->view->headScript()->appendFile('/validacion/bootbox.min.js');
    
    }
public function verliquidacionAction(){
     $cod_practica= $this->_getParam('cod_practica');
        $dql= "select l, pra from Application_Model_LiquidarPractica l join l.cod_practica pra  where l.cod_practica=:practica";
        
        $query = $this->em->createQuery($dql);
         $query->setParameter('practica', $cod_practica);
        
        $liquidarpractica = $query->getArrayResult();
        
        $this->view->liquidarpractica= $liquidarpractica;
       // var_dump($liquidarpractica);
         $this->view->cod_practica= $cod_practica;
         // var_dump($cod_practica);
       
        
       $dql1 ="select pro, r, p, re from Application_Model_Programacion pro join pro.ruta r join pro.cod_practica p join pro.recursos re where pro.cod_practica=:practica";
        
        // Ejecutar el Query, la variable query es donde se carga la consulta.
        $query1 = $this->em->createQuery($dql1);
        
        $query1->setParameter('practica', $cod_practica);
        
        //Resultados de la consulta en un Vector, en este caso en Array
        $programacion = $query1->getArrayResult();
        
        //Imprimir en la pagina lo que esta en la variable en este caso facultades
       // var_dump($facultades);
        //Pasarle a la Vista la informción de la facultad
        $this->view->programacion= $programacion; 
        //var_dump($programacion);
        
      //  Preparo la Consulta de hallar los recursos
        //Creo una variable que me guarde el total de la practica...
        $total_liquidacion= 0;
        //creo una variable que guarde el viatico del docente..
        $valor_docente = 0;
        //variable del auxilio del estudiante..
       $auxilio_est= 0;
       // var_dump($auxilio_est);
     // Creo una variable para guardar el valor de los recursos
      
    
        if($programacion[0]['ruta']['sitio']== 'Municipio'){
        if(count($programacion)== 1){
           $valor_docente= 51709;
         //  var_dump($valor_docente);
          
        if($programacion[0]['ruta']['sitio']== 'Departamento') {
            if(count($programacion)== 1){
                $valor_docente= 79250;
              //  var_dump($valor_docente);
               
            }else{
              $valor_docente=(count($programacion)* 158574)- 79250; 
             // $auxilio_est=(count($programacion)* 31025)- 31025;
            }     
        }  
        }
         }else{
            $valor_docente=(count($programacion)* 103418)- 51709;
           
        }
         //le paso el dato a la vista
         $this->view->valor_docente= $valor_docente;
        // condicional de los auxilio de estudiantes
         $cont = 0;
         foreach ($programacion as $dias){
           //  var_dump($dias['dias_pernoctados']);
             if($dias['dias_pernoctados']== 'No'){
                
             $auxilio_est= 0;
             }else {
              if($dias['dias_pernoctados']== 'Si'){
              $auxilio_est= 31025;
              $auxilio_est= ($auxilio_est) * ($dias['cod_practica']['num_estudiantes']);
                      
            //  var_dump($auxilio_est); 
              $cont = ($cont) + ($auxilio_est);
             // var_dump($cont);
              }   
                 
             }
             
         }
          
        $this->view->auxilio_est= $cont;
       // var_dump($cont);
         $total_recursos= 0;
      // var_dump($valor_recursos);
        // $recursos= array();
        $recusos_programados= 0;
        // var_dump($recursos);
        // realizo un ciclo
       
           foreach ($programacion as $pro){
          
            foreach ($programacion[$recusos_programados]['recursos'] as $recursos){
              $recusos_programados++;
//             var_dump($recursos['valor']);
             $total_recursos= $recursos['valor'] + $total_recursos;
            // var_dump($recursos['valor']);
            
            }
           
          
        } 
      //   var_dump($total_recursos);
         $this->view->total_recursos = $total_recursos;   
       
        // Hago un ciclo
        //calculo los valores
       $total_liquidacion= ($valor_docente) + ($cont) + ($total_recursos);  
       
      // var_dump($total_liquidacion);
        
      $this->view->total_liquidacion= $total_liquidacion;
     //  var_dump($total_liquidacion); 
    
    
    
     $this->view->headLink()->appendStylesheet('/css/jquery.dataTables.min.css');
     $this->view->headLink()->appendStylesheet('/css/font-awesome.min.css');
     $this->view->headLink()->appendStylesheet('/css/practica.css');
     $this->view->headScript()->appendFile('/js/practica.js');
     $this->view->headScript()->appendFile('/admin/practicas.js');
     $this->view->headScript()->appendFile('/js/jquery.dataTables.min.js');
     $this->view->headScript()->appendFile('/js/bootstrap-modal.js');
     $this->view->headScript()->appendFile('/validacion/jquery.validate.min.js');
     $this->view->headScript()->appendFile('/validacion/localization/messages_es.min.js');
     $this->view->headScript()->appendFile('/validacion/additional-methods.min.js');
     $this->view->headScript()->appendFile('/validacion/bootbox.min.js');    
    
}

    public function guardarpracticaAction(){
     echo "holas";
    //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->layout->disableLayout();
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->viewRenderer->setNoRender(TRUE);
     
     //Recibo los parametros por petición ajax
     $datos= $this->_getParam('datos');
     $id= $this->_getParam('id');
     parse_str($datos, $output);
//     var_dump($output);
     $programacion= $this->_getParam('programacion');
//     var_dump($programacion);
     
     /*
      * 
      * Datos de la practica
      * 
      
      array(18) {
  ["nombre"]=>
  string(30) "Bustamante EscobarMaria Camila"
  ["fac"]=>
  string(1) "3"
  ["dep"]=>
  string(4) "1553"
  ["pro"]=>
  string(3) "784"
  ["sem"]=>
  string(1) "9"
  ["asigna"]=>
  string(6) "2426BC"
  ["gru"]=>
  string(4) "aj-2"
  ["num"]=>
  string(2) "25"
  ["nom"]=>
  string(6) "Prueba"
  ["tipo"]=>
  string(1) "0"
  ["obj"]=>
  string(6) "Prueba"
  ["jus"]=>
  string(6) "Prueba"
  ["adoc"]=>
  string(6) "Prueba"
  ["est"]=>
  string(6) "Prueba"
  ["example_length"]=>
  string(2) "10"
  ["reco"]=>
  string(1) "0"
  ["auxi"]=>
  string(1) "0"
  ["ases"]=>
  string(1) "0"
}
      * 
      * Datos de la programacion
      * 
array(3) {
  [0]=>
  array(13) {
    [0]=>
    string(1) "1"
    [1]=>
    string(1) "3"
    [2]=>
    string(10) "18/04/2017"
    [3]=>
    string(6) "Prueba"
    [4]=>
    string(2) "Si"
    [5]=>
    string(0) ""
    [6]=>
    string(1) "5"
    [7]=>
    string(1) "4"
    [8]=>
    string(6) "Prueba"
    [9]=>
    string(4) "Okis"
    [10]=>
    string(2) "Si"
    [11]=>
    string(3) "129"
    [12]=>
    string(1) "3"
  }
  [1]=>
  array(13) {
    [0]=>
    string(1) "2"
    [1]=>
    string(1) "4"
    [2]=>
    string(10) "19/04/2017"
    [3]=>
    string(0) ""
    [4]=>
    string(2) "Si"
    [5]=>
    string(0) ""
    [6]=>
    string(2) "23"
    [7]=>
    string(2) "16"
    [8]=>
    string(6) "Prueba"
    [9]=>
    string(4) "Okis"
    [10]=>
    string(2) "Si"
    [11]=>
    string(7) "131,133"
    [12]=>
    string(1) "4"
  }
  [2]=>
  array(13) {
    [0]=>
    string(1) "3"
    [1]=>
    string(1) "5"
    [2]=>
    string(10) "20/04/2017"
    [3]=>
    string(0) ""
    [4]=>
    string(2) "No"
    [5]=>
    string(10) "20/04/2017"
    [6]=>
    string(2) "24"
    [7]=>
    string(2) "22"
    [8]=>
    string(6) "Prueba"
    [9]=>
    string(4) "Okis"
    [10]=>
    string(2) "No"
    [11]=>
    string(7) "135,138"
    [12]=>
    string(1) "5"
  }
} 
      
      */
     
     
      try {
       //creo una consulta para extraer el calendario   
     //Preparo la consulta del calendario activo dql
      $dql= "select c, a, p from Application_Model_calendar c left join c.id_annio a left join c.id_periodo p where c.estado=:estado";                                                                                      
       
      // $dql6= "select c, a, p from Application_Model_calendar c left join c.id_annio a left join c.id_periodo p where c.id=:id";
       $query = $this->em->createQuery($dql);
       
//       $query6->setParameter('id', 'id');
       $query->setParameter('estado', '1');
       
       //muestre el resultado en un array...
      $calendario =$query->getArrayResult();
     // var_dump($calendario);
     
      
     //encapsulo los parametros en un objeto
     $practica_objeto= new Application_Model_Practicas();
     $practica_objeto->setid_calendario($this->em->getRepository('Application_Model_calendar')->find($calendario[0]['id']));
     $practica_objeto->setnombre($output['nom']);
     $practica_objeto->setnum_estudiantes($output['num']);
     $practica_objeto->setnom_solicitante($output['nombre']);
     $practica_objeto->setjustificacion($output['jus']);
     $practica_objeto->setobjetivo($output['obj']);
     $practica_objeto->setactividad_doc($output['adoc']);
     $practica_objeto->setactividad_est($output['est']);
     $practica_objeto->settipo_practica($output['tipo']);
     $practica_objeto->setsemestre($output['sem']);
     $practica_objeto->setfacultad($output['fac']);
     $practica_objeto->setdepartamento($output['dep']);
     $practica_objeto->setprograma($output['pro']);  
     $practica_objeto->setasignatura($output['asigna']);
     $practica_objeto->setgrupo($output['gru']);
     
     if($id > 0){
         var_dump("hola");
         $practica_objeto->setcod_practica($id);
         //delete dependencias de programacion
         //recursos_programados
         $dql_delete_1 = "delete rp from Application_Model_Progrecursos rp join rp.programarecursos pr join pr.cod_practica p where p.cod_practica = :practica";
         $query_1 = $this->em->createQuery($dql_delete_1);
         $query_1->execute();
         //programacion_participante
         //delete programaciones
         $dql_delete_2 = "delete pr,par from Application_Model_Programacion pr join pr.participantes par join pr.cod_practica p where p.cod_practica = :practica";
         $query_2 = $this->em->createQuery($dql_delete_2);
         $query_2->execute();
         
     }
     
        
          
//    var_dump($programacion[0]);
    // var_dump($valor['1']);
     foreach ($programacion as $key => $valor){
         
//         var_dump($key);
//         var_dump($programacion[$key]);
//         var_dump($valor);
//         var_dump("recorrido");
//         var_dump($programacion[$key]['1']);
//         var_dump($valor['1']);
          // var_dump($valor['5']);
        // var_dump($valor);
         $programacion_objeto= new Application_Model_Programacion();
         $programacion_objeto->setcod_practica($practica_objeto);
         $programacion_objeto->setnum_dias($valor['0']);
         if($programacion[$key]['1'] > 0){
             $programacion_objeto->setrecorrido($programacion[$key]['1']);
         }
         
         $programacion_objeto->setruta($this->em->getRepository('Application_Model_Rutas')->find($programacion[$key]['1']));
         $programacion_objeto->setdepartamental($valor['8']);
         $fecha_salida= DateTime::createFromFormat('d/m/Y', $valor['2']);
         $programacion_objeto->setfecha_salida($fecha_salida);
         $programacion_objeto->setlugar_encuentro($valor['3']);
         $programacion_objeto->setdias_pernoctados($valor['4']); 
        
          //creo la validación para la comprobación de que la fecha de llegada 
         if($valor['5'] == ""){
           $fecha_llegada= null;  
             
         }else{
           $fecha_llegada= DateTime::createFromFormat('d/m/Y', $valor['5']);
         }
         $programacion_objeto->setfecha_llegada($fecha_llegada);
       //  $programacion_objeto->settipo($valor['6']);
        // $programacion_objeto->setvalor($valor['7']);
         $programacion_objeto->setobservaciones($valor['9']);
         //declaro una variable
          $recursos= explode(",", $valor['11']);
//          var_dump($recursos);
          foreach ($recursos as $r){
          //condicional cuando recursos es diferente de null
          if($r != "" ){
           $programacion_objeto->getrecursos()->add($this->em->getRepository('Application_Model_Progrecursos')->find($r));   
          }
          }
          
       //  $programacion_objeto->getparticipantes()->add($this->em->getRepository('Application_Model_Participantes')->find($valor['8']));
        //  var_dump($valor['0']);
         
         if($valor['6'] > 0){
            $programacion_objeto->getparticipantes()->add($this->em->getRepository('Application_Model_Participantes')->find($valor['6']));
         }
         if($valor['7'] > 0){
            $programacion_objeto->getparticipantes()->add($this->em->getRepository('Application_Model_Participantes')->find($valor['7']));
         }
         $practica_objeto->getprogramaciones()->add($programacion_objeto);
         
         var_dump($practica_objeto == null);
         //da la orden de guardar...
            $this->em->persist($practica_objeto);
       //Ejecuta la Orden de guardar..
           $this->em->flush();
       
        }  
     
      } catch (Exception $ex) {
         echo $ex;  
     
     }
     catch(PDOException $e){
         echo $e->getMessage();
     }
     
     //Hacer el ciclo para guardar las programaciones...
    
         
    
   
    }
    
 public function cargardatosprogramacionAction(){
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->layout->disableLayout();
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
     $this->_helper->viewRenderer->setNoRender(TRUE);
      header('Content-Type: application/json'); 
     $practica = $this->_getParam('p');
//     var_dump($practica);
     try{
     if($practica > 0){
         $res = array();
         $dql = "select p,pr,r,par,rec,re from Application_Model_Practicas p 
             join p.programaciones pr left join pr.ruta r left join pr.participantes par
             left join pr.recursos rec left join rec.id_recursos re
             where p.cod_practica = :practica";
         $query = $this->em->createQuery($dql);
         $query->setParameter('practica', $practica);
         $programaciones = $query->getArrayResult();
//         var_dump($programaciones);
         $res = $programaciones[0];
         echo json_encode($res);
     }
     }
     catch(Exception $e){
         echo $e->getMessage();
     }
 }
    
 public function editarpracticaAction(){
        try{
            
        
          // llamo la session
         $authNamespace = new Zend_Session_Namespace('Zend_Auth');
         //saco los datos del usuario
         $usuario= $authNamespace->usuarios;
         $rol= $authNamespace->usuarios[0]['id_rol']['id_rol'];
         
         $this->view->rol= $rol;
         
         //recibo el id de la programación de la prácticas
         
         
           //Preparo la consulta dql
      $dql7= "select r from Application_Model_Rutas r";
       
       $query7 = $this->em->createQuery($dql7);
       
       //muestre el resultado en un array...
      $rutas =$query7->getArrayResult();
      
      //Pasarle a la Vista la informción de la Calendario
      $this->view->rutas= $rutas; 
      
        //Preparo la consulta dql
      $dql8= "select r from Application_Model_Recurespeciales r";
       
       $query8 = $this->em->createQuery($dql8);
       
       //muestre el resultado en un array...
      $recursos =$query8->getArrayResult();
      
      //Pasarle a la Vista la informción de la Calendario
      $this->view->recursos= $recursos; 
      //Preparo la consulta dql
       // $dql= "select p, pro, pa, cal, from Application_Model_Practicas p join p.programaciones pro join pro.participantes pa join p.id_calendario cal order by p.cod_practica";
         $dql6= "select c, a, p from Application_Model_calendar c left join c.id_annio a left join c.id_periodo p where c.estado=:estado";                                                                                      
       
      // $dql6= "select c, a, p from Application_Model_calendar c left join c.id_annio a left join c.id_periodo p where c.id=:id";
       $query6 = $this->em->createQuery($dql6);
       
//       $query6->setParameter('id', 'id');
       $query6->setParameter('estado', '1');
       
       //muestre el resultado en un array...
      $calendario =$query6->getArrayResult();
      
      //Pasarle a la Vista la informción de la Calendario
      $this->view->calendario= $calendario;
      
   //capturo el id de la facultad
         $practica_id =$this->_getParam('id');
       //  var_dump($practica_id);
         //Realizo la consulta para obtener el codigo de la facultad...
         $dql1= "select p, cal from Application_Model_Practicas p join p.id_calendario cal where p.cod_practica=:practica";
         //Crear el query para que se guarde la consulta...
         $query1= $this->em->createQuery($dql1);
         //Se guarde el id de facultad..
         $query1->setParameter('practica', $practica_id);
         //muestre el resultado en un array...
       
        $practicas = $query1->getArrayResult();   
        //Pasarle a la Vista la informción a listar práctica
        $this->view->practicas= $practicas;  
        $this->view->practica_id = $practica_id;
       // var_dump($practicas);
        
        //Facultad
          $datoss = array(); 
         // var_dump($datoss);
          //preparo la consulta para obtener la facultad asociada al programa..
         $sql = "SELECT DISTINCT V_Facultades.Facultad as nombre, V_Facultades.ID as id_facultad, V_Departamentos.ID_Departamento AS id_dep, V_Departamentos.Departamento AS dep, V_Programas.ID_Programa AS id_pro, V_Programas.Programa AS pro FROM V_Departamentos INNER JOIN  V_Facultades ON V_Departamentos.ID_Facultad=V_Facultades.ID INNER JOIN V_Programas ON V_Departamentos.ID_Departamento=V_Programas.ID_Departamento where V_Programas.ID_Programa= ?";
          $stmt = sqlsrv_query( $this->pw, $sql, array($authNamespace->programa[0]["cod_progra_power"]));
        // $authNamespace->programa;
       //  var_dump($authNamespace->programa[0]["cod_progra_power"]);
          while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
          
          $row['id_facultad']= htmlentities(utf8_encode($row['id_facultad']));  
          $row['nombre']= htmlentities(utf8_encode($row['nombre']));
          $row['id_dep']= htmlentities(utf8_encode($row['id_dep']));
          $row['dep']= htmlentities(utf8_encode($row['dep']));
          $row['id_pro']= htmlentities(utf8_encode($row['id_pro']));
          $row['pro']= htmlentities(utf8_encode($row['pro']));
           $datoss[]= $row;   
         // echo $row['ID'].", ".$row['Facultad']."<br />";
         //var_dump($row);
       }
      // var_dump($datos);
       sqlsrv_free_stmt( $stmt);
        
         $this->view->facultad= $datoss;
         
      //Consulta para obtener la asignatura
        $datos = array(); 
          //preparo la consulta para obtener la facultad asociada al programa..
         $sql = "SELECT V_Asignaturas.Id_Asignatura AS id_asigna, V_Asignaturas.Asignatura AS asigna FROM V_Asignaturas INNER JOIN V_Programas ON V_Asignaturas.Id_Programa=V_Programas.ID_Programa where V_Asignaturas.Id_Asignatura= ?";
          $stmt = sqlsrv_query( $this->pw, $sql, array($practicas[0]["asignatura"]));
        // $authNamespace->programa;
       //  var_dump($authNamespace->programa[0]["cod_progra_power"]);
          while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
            //  var_dump($sql);
          $row['id_asigna']= htmlentities(utf8_encode($row['id_asigna']));  
          $row['asigna']= htmlentities(utf8_encode($row['asigna']));
          
           $datos[]= $row;   
         // echo $row['ID'].", ".$row['Facultad']."<br />";
         //var_dump($row);
       }
      // var_dump($datos);
       sqlsrv_free_stmt( $stmt);
        
         $this->view->asignatura= $datos; 
         
        //realizamos una consulta dql, para que se listen los participantes auxiliares
        $dql2= "select p from Application_Model_Participantes p where p.tipo_participante=:auxiliar";
         // Ejecutar el Query, la variable query es donde se carga la consulta.
        $query2 = $this->em->createQuery($dql2);
        $query2->setParameter('auxiliar', 'auxiliar'); 
        //Resultados de la consulta en un Vector, en este caso en Array
         $participantess = $query2->getArrayResult();
       // var_dump($participantes);
        // Pasarle la información de programas a la vista..
        $this->view->participantess= $participantess;
        
         //Realizamos Una Consulta dql, Para que listen los participantes Asesores
         $dql3= "select p from Application_Model_Participantes p where p.tipo_participante=:asesor";
         // Ejecutar el Query, la variable query es donde se carga la consulta.
        $query3 = $this->em->createQuery($dql3);
        $query3->setParameter('asesor', 'asesor'); 
        //Resultados de la consulta en un Vector, en este caso en Array
         $participante = $query3->getArrayResult();
       // var_dump($participantes);
        // Pasarle la información de programas a la vista..
        $this->view->participante= $participante; 
         
        //Consulta para saber el docente escogido
        
    //  $nombre_solicitante= $this->_getParam('nombre_solicitante');
    //  var_dump($nombre_solicitante);
      
        $docentes= array();
        //CONEXION LOCAL
        $sql = "SELECT VIEW_SIPA.cod_empl AS cod, VIEW_SIPA.ape_empl AS ape, VIEW_SIPA.nom_empl AS nom FROM KACTUS.dbo.VIEW_SIPA WHERE cod_empl= ?";
      //  $sql = "SELECT DISTINCT KACTUS.dbo.VIEW_SIPA.ape_empl AS ape, KACTUS.dbo.VIEW_SIPA.nom_empl AS nom FROM KACTUS.dbo.VIEW_SIPA ORDER BY ape_empl";
          $stmt = sqlsrv_query( $this->ka, $sql, array($practicas[0]['nom_solicitante']));
          //var_dump($sql);
          while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
              //para quitar las tildes
          $row['cod']= htmlentities(utf8_encode($row['cod']));    
          $row['ape']= htmlentities(utf8_encode($row['ape']));
          $row['nom']= htmlentities(utf8_encode($row['nom']));
         // $row['Id_Programa']= htmlentities(utf8_encode($row['Id_Programa']));
          $docentes[]= $row;   
         // var_dump($row);
          // $row['ID_Facultad'].", ".$row['Facultad'].", ".$row['Departamento'].", ".$row['Programa'].", ".$row['ID_Departamento']."<br />";
         // var_dump($row);
       }
       sqlsrv_free_stmt( $stmt);
       $this->view->docentes= $docentes; 
            
       
        
     // Realizamos la consulta dql, para que se listen los Programas, en la vista Agregar Asignatura..

         
     //preparo la consulta, para extraer la información de la tabla práctica..
        $dql_fecha_llegada= "select pro, cod, max(pro.fecha_llegada) as fecha_llegada, min(pro.fecha_salida) as fecha_salida from Application_Model_Programacion pro join pro.cod_practica cod where cod.cod_practica = :practica";
        $query_fecha_llegada = $this->em->createQuery($dql_fecha_llegada);
        $query_fecha_llegada->setParameter('practica', 26);
        //Resultados de la consulta en un Vector, en este caso en Array
        $programacion = $query_fecha_llegada->getArrayResult();   
//        var_dump($programacion[0]['fecha_salida']);
        //Pasarle a la Vista la informción a listar programacion
        $programacion[0]['fecha_llegada'] = new Datetime($programacion[0]['fecha_llegada']);
        $programacion[0]['fecha_salida'] = new Datetime($programacion[0]['fecha_salida']);
        $this->view->programacion= $programacion;  
       // var_dump($programacion);
        
        
       // var_dump($programacion);
       
      } catch (Exception $ex) {
            echo $ex->getMessage();
        }
 
     $this->view->headLink()->appendStylesheet('/css/bootstrap-datepicker.min.css'); 
     $this->view->headLink()->appendStylesheet('/css/fuelux.min.css'); 
     $this->view->headLink()->appendStylesheet('/css/jquery.dataTables.min.css');
     $this->view->headLink()->appendStylesheet('/css/font-awesome.min.css');
     $this->view->headLink()->appendStylesheet('/font-awesome/css/font-awesome.css');
//     $this->view->headLink()->appendStylesheet('/css/bootstrap-datepicker.css.map');
     $this->view->headScript()->appendFile('/js/fuelux.min.js');
     $this->view->headScript()->appendFile('/js/wizard.js');
     $this->view->headScript()->appendFile('/bootstrap/js/moment.min.js');   
     $this->view->headScript()->appendFile('/bootstrap/js/bootstrap-datepicker.js');      
     $this->view->headScript()->appendFile('/bootstrap/js/datepicker.es.min.js');
     $this->view->headScript()->appendFile('/js/practica.js');
     $this->view->headScript()->appendFile('/admin/practicas_editar.js');
     $this->view->headScript()->appendFile('/practica/participantes.js');
     $this->view->headScript()->appendFile('/practica/progrecurso.js');
     $this->view->headScript()->appendFile('/js/jquery.dataTables.min.js');
     $this->view->headScript()->appendFile('/js/bootstrap-modal.js');
     $this->view->headScript()->appendFile('/validacion/jquery.validate.min.js');
     $this->view->headScript()->appendFile('/validacion/localization/messages_es.min.js');
     $this->view->headScript()->appendFile('/validacion/additional-methods.min.js');
     $this->view->headScript()->appendFile('/validacion/bootbox.min.js');     
     
 }
 public function actualizarpracticaAction(){
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
   $this->view->headScript()->appendFile('/admin/practicas.js');
          
    }
    
    public function obtenerverificacioncalendarioAction(){
        header('Content-Type: application/json'); 
       $this->_helper->layout->disableLayout();
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
       $this->_helper->viewRenderer->setNoRender(TRUE);
      
       try {
       $fecha_inicio = $this->getParam('fecha_inicio');
       $fecha_final = $this->getParam('fecha_final');
       
       $dql = "select c from Application_Model_Calendar c where c.estado = 1 and c.fecha_inicio <= :fecha and c.fecha_fin >= :fecha";
       //var_dump($dql);
       $query = $this->em->createQuery($dql);
       $query->setParameter('fecha', $fecha_inicio);

       $check = $query->getArrayResult();  
      // echo json_encode($check);   
       //codigo de fecha de llegada
       $dql1="select c from Application_Model_Calendar c where c.estado = 1 and c.fecha_fin >=  :fecha and c.fecha_inicio <= :fecha";
     //  var_dump($dql1);
       $query1= $this->em->createQuery($dql1);
       $query1->setParameter('fecha', $fecha_final);
       $check1 = $query1->getArrayResult(); 
     //  echo json_encode($check1);
     //  var_dump(count($check));
      // var_dump(count($check1));
       if(count($check) > 0 || count($check1) > 0){
           $envio= array(1);
            echo json_encode($envio); 
       } 
 else {
        $envio= array();
         echo json_encode($envio);   
       }
           
       } catch (Exception $ex) {
          echo $ex->getMessage(); 
       }
               
       
    }
    public function obtenerprogramasAction(){
        header('Content-Type: application/json'); 
       $this->_helper->layout->disableLayout();
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
       $this->_helper->viewRenderer->setNoRender(TRUE);  
         
         $departamento= $this->getParam('departamento');
          // llamo la session
         $authNamespace = new Zend_Session_Namespace('Zend_Auth');
         //saco los datos del usuario
         $usuario= $authNamespace->usuarios;
         $rol= $authNamespace->usuarios[0]['id_rol']['id_rol'];
         
        //realizo la validacion para obtener el programa asociado al departamento
         if($rol == 1){
          $programas= array();
         $sql = "SELECT * FROM V_Departamentos INNER JOIN  V_Facultades ON V_Departamentos.ID_Facultad=V_Facultades.ID INNER JOIN V_Programas ON V_Departamentos.ID_Departamento=V_Programas.ID_Departamento where V_Departamentos.ID_Departamento= ?";
          $stmt = sqlsrv_query( $this->pw, $sql,  array($departamento));
          //var_dump($sql);
          while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
              //para quitar las tildes
          $row['ID_Facultad']= htmlentities(utf8_encode($row['ID_Facultad']));  
          $row['Facultad']= htmlentities(utf8_encode($row['Facultad']));
          $row['Departamento']= htmlentities(utf8_encode($row['Departamento']));
          $row['Programa']= htmlentities(utf8_encode($row['Programa']));
          $row['ID_Departamento']= htmlentities(utf8_encode($row['ID_Departamento']));
          $programas[]= $row;    
          // $row['ID_Facultad'].", ".$row['Facultad'].", ".$row['Departamento'].", ".$row['Programa'].", ".$row['ID_Departamento']."<br />";
         // var_dump($row);
       }
       echo json_encode($programas);
      
       sqlsrv_free_stmt( $stmt);   
         }else{
             if($rol == 2){
                 
            $programas = array(); 
            //preparo la consulta en el power campus..
            // $sql = "SELECT V_Programas.ID_Programa AS ID_Programa, V_Programas.Programa AS Programa FROM V_Departamentos INNER JOIN  V_Programas ON V_Departamentos.ID_Departamento=V_Programas.ID_Departamento WHERE V_Programas.ID_Programa= ?";
            $sql = "SELECT V_Programas.ID_Programa AS ID_Programa, V_Programas.Programa AS Programa FROM V_Departamentos INNER JOIN V_Programas ON V_Departamentos.ID_Departamento=V_Programas.ID_Departamento WHERE V_Programas.ID_Programa= ?";
            $stmt = sqlsrv_query($this->pw, $sql, array($authNamespace->programa[0]["cod_progra_power"]));
            $authNamespace->programa;
          //  var_dump($authNamespace);
            while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
         
            $row['Programa']= htmlentities(utf8_encode($row['Programa']));
            $row['ID_Programa']= htmlentities(utf8_encode($row['ID_Programa']));
         
            $programas[]= $row;   
       }
    
         sqlsrv_free_stmt( $stmt);
       
         echo json_encode($programas);   
                 
             }
         }     
            
    }
    public function obtenerdepartamentoAction(){
         header('Content-Type: application/json'); 
        $this->_helper->layout->disableLayout();
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
       $this->_helper->viewRenderer->setNoRender(TRUE);  
        //recibo el departamento por peticiòn ajax
        $id_facultad= $this->getParam('facultad');
    
       // llamo la session
         $authNamespace = new Zend_Session_Namespace('Zend_Auth');
         //saco los datos del usuario
         $usuario= $authNamespace->usuarios;
         $rol= $authNamespace->usuarios[0]['id_rol']['id_rol'];
        if($rol == 1){
            //declaro el vector de los departamentos
        $departamentos= array();
       // var_dump($departamentos);
        $sql = "SELECT V_Departamentos.ID_Departamento AS ID, V_Departamentos.Departamento AS Departa, V_Departamentos.ID_Facultad As id_fa  FROM V_Departamentos where V_Departamentos.ID_Facultad= ?";
          $stmt = sqlsrv_query( $this->pw, $sql,  array($id_facultad));
          //var_dump($sql);
          while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ){
              //para quitar las tildes
          $row['Departa']= htmlentities(utf8_encode($row['Departa']));
          $row['ID']= htmlentities(utf8_encode($row['ID']));
          $row['id_fa']= htmlentities(utf8_encode($row['id_fa']));
          $departamentos[]= $row;   
         // var_dump($row);
          // $row['ID_Facultad'].", ".$row['Facultad'].", ".$row['Departamento'].", ".$row['Programa'].", ".$row['ID_Departamento']."<br />";
         // var_dump($row);
       }
       echo json_encode($departamentos);
      
       sqlsrv_free_stmt( $stmt);
        }  else {
            if($rol == 2){
          try{        
          $departamento = array(); 
        // var_dump($departamento);
          //preparo la consulta para obtener la facultad asociada al programa..
         $sql = "SELECT V_Departamentos.Departamento as Departa, V_Departamentos.ID_Departamento as ID FROM V_Departamentos INNER JOIN  V_Facultades ON V_Departamentos.ID_Facultad=V_Facultades.ID INNER JOIN V_Programas ON V_Departamentos.ID_Departamento=V_Programas.ID_Departamento where V_Programas.ID_Programa= ?";
         $stmt = sqlsrv_query($this->pw, $sql, array($authNamespace->programa[0]["cod_progra_power"]));
          $authNamespace->programa;
          while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
         
          $row['Departa']= htmlentities(utf8_encode($row['Departa']));
          $row['ID']= htmlentities(utf8_encode($row['ID']));
         
           $departamento[]= $row;   
        
       }
      // var_dump($datos);
       sqlsrv_free_stmt( $stmt);
       
         echo json_encode($departamento);
       
       
        
      
        // var_dump($departamento);
                    
                } catch (Exception $e) {
                echo $e->getMessage();    
                }   
                
            }
        }
         
    }
    public function obtenersemestreAction(){
         header('Content-Type: application/json'); 
        $this->_helper->layout->disableLayout();
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
       $this->_helper->viewRenderer->setNoRender(TRUE);  
        //recibo el departamento por peticiòn ajax
        $id_programa= $this->getParam('programas');
       // var_dump($id_facultad);
        //declaro el vector de los departamentos
        $semestre= array();
        $sql = "SELECT DISTINCT V_Asignaturas.Semestre AS sem FROM  V_Asignaturas where Id_Programa= ? ORDER BY Semestre";
          $stmt = sqlsrv_query( $this->pw, $sql,  array($id_programa));
          //var_dump($sql);
          while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
              //para quitar las tildes
          $row['sem']= htmlentities(utf8_encode($row['sem']));
          
          $semestre[]= $row;   
         // var_dump($row);
          // $row['ID_Facultad'].", ".$row['Facultad'].", ".$row['Departamento'].", ".$row['Programa'].", ".$row['ID_Departamento']."<br />";
         // var_dump($row);
       }
       echo json_encode($semestre);
      
       sqlsrv_free_stmt( $stmt);
        
    }
     public function obtenerasignaturaAction(){
         header('Content-Type: application/json'); 
        $this->_helper->layout->disableLayout();
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
       $this->_helper->viewRenderer->setNoRender(TRUE);  
        //recibo el departamento por peticiòn ajax
        $semestre= $this->getParam('semestre');
        $id_programa= $this->getParam('programa');
       // var_dump($id_programa);
      
       // var_dump($id_facultad);
        //declaro el vector de los departamentos
        $asignatura= array();
        $sql = "SELECT DISTINCT V_Asignaturas.Id_Asignatura AS id_asigna, V_Asignaturas.Asignatura AS asigna FROM V_Asignaturas WHERE Semestre= ? AND Id_Programa= ?";
          $stmt = sqlsrv_query( $this->pw, $sql,  array($semestre, $id_programa));
          //var_dump($sql);
          while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
              //para quitar las tildes
          $row['asigna']= htmlentities(utf8_encode($row['asigna']));
          $row['id_asigna']= htmlentities(utf8_encode($row['id_asigna']));
         // $row['Id_Programa']= htmlentities(utf8_encode($row['Id_Programa']));
          $asignatura[]= $row;   
         // var_dump($asignatura);
          // $row['ID_Facultad'].", ".$row['Facultad'].", ".$row['Departamento'].", ".$row['Programa'].", ".$row['ID_Departamento']."<br />";
         // var_dump($row);
       }
       echo json_encode($asignatura);
      
       sqlsrv_free_stmt( $stmt);
        
    }
     public function obtenergruposAction(){
         header('Content-Type: application/json'); 
        $this->_helper->layout->disableLayout();
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
       $this->_helper->viewRenderer->setNoRender(TRUE);  
        //recibo el departamento por peticiòn ajax
        try {
            $asignatura= $this->getParam('asignatura');
        
      // var_dump($asignatura);
        $grupos= array();
      $sql = "SELECT V_Grupos.Grupo AS gru FROM V_Grupos WHERE V_Grupos.ID_Asignatura=?";
          $stmt = sqlsrv_query( $this->pw, $sql,  array($asignatura));
          //var_dump($sql);
          while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
              //para quitar las tildes
          $row['gru']= htmlentities(utf8_encode($row['gru']));
        
          $grupos[]= $row;   
         // var_dump($row);
         
       }
       echo json_encode($grupos);
      
       sqlsrv_free_stmt( $stmt);
            
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }
     public function obtenermatriculadosAction(){
         header('Content-Type: application/json'); 
        $this->_helper->layout->disableLayout();
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
       $this->_helper->viewRenderer->setNoRender(TRUE);  
        //recibo el departamento por peticiòn ajax
        $grupo= $this->getParam('grupo');
        
      // var_dump($asignatura);
      
       // var_dump($id_facultad);
        //declaro el vector de los departamentos
        $matriculados= array();
       // $sql = "SELECT V_Grupos.Matriculados AS mat FROM V_Grupos WHERE V_Grupos.ID_Asignatura=?";
        $sql = "SELECT DISTINCT V_Grupos.Matriculados AS mat FROM V_Grupos WHERE V_Grupos.Grupo= ?";
          $stmt = sqlsrv_query( $this->pw, $sql,  array($grupo));
          //var_dump($sql);
          while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
              //para quitar las tildes
          $row['mat']= htmlentities(utf8_encode($row['mat']));
         // $row['ID_Asignatura']= htmlentities(utf8_encode($row['ID_Asignatura']));
         // $row['Id_Programa']= htmlentities(utf8_encode($row['Id_Programa']));
          $matriculados[]= $row;   
         // var_dump($row);
          // $row['ID_Facultad'].", ".$row['Facultad'].", ".$row['Departamento'].", ".$row['Programa'].", ".$row['ID_Departamento']."<br />";
         // var_dump($row);
       }
       echo json_encode($matriculados);
      
       sqlsrv_free_stmt( $stmt);
        
    }
  /** public function obtenerdocenteAction(){
         header('Content-Type: application/json'); 
        $this->_helper->layout->disableLayout();
     //Le dice a las acciones que no se muestre en la vista html, sino que va a mostrar otro tipo de información
       $this->_helper->viewRenderer->setNoRender(TRUE);  
        //recibo el departamento por peticiòn ajax
        $nombre_solicitante= $this->_getParam('nombre_solicitante');
        
      
        //declaro el vector de los departamentos
        $docentes= array();
       // $sql = "SELECT V_Grupos.Matriculados AS mat FROM V_Grupos WHERE V_Grupos.ID_Asignatura=?";
        $sql = "SELECT VIEW_SIPA.cod_empl AS cod, VIEW_SIPA.ape_empl AS ape, VIEW_SIPA.nom_empl AS nom FROM KACTUS.dbo.VIEW_SIPA";
          $stmt = sqlsrv_query( $this->ka, $sql,  array($nombre_solicitante));
          //var_dump($sql);
          while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
              //para quitar las tildes
          $row['cod']= htmlentities(utf8_encode($row['cod']));    
          $row['ape']= htmlentities(utf8_encode($row['ape']));
          $row['nom']= htmlentities(utf8_encode($row['nom']));
         // $row['ID_Asignatura']= htmlentities(utf8_encode($row['ID_Asignatura']));
         // $row['Id_Programa']= htmlentities(utf8_encode($row['Id_Programa']));
          $docentes[]= $row;   
         // var_dump($row);
          // $row['ID_Facultad'].", ".$row['Facultad'].", ".$row['Departamento'].", ".$row['Programa'].", ".$row['ID_Departamento']."<br />";
         // var_dump($row);
       }
       echo json_encode($docentes);
      
       sqlsrv_free_stmt( $stmt);
        
    } */
  
}



