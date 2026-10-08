<?php

class Powercampus_Powercampus {
   private $database;
  // private $usuario;
  // private $contrasena;
   private $serverName;
   private static $instancia;
   private $_registry;

    
    //Creo el constructor
    public function __construct() {
        // la variable now, se comporta como un objeto donde la fecha se haga automaticamente..
        $this->database= "Campus";
      //  $this->usuario= "lila";
      //  $this->contrasena= "lila12345";
        $this->serverName= "LILA\SQLEXPRESS";
        
        $this->_initRegistry();
        
        //llamar el metodo conectar
        $this->conectar();
               
    }
    
     protected function _initRegistry(){
        $registry = Zend_Registry::getInstance();
        $this->_registry=$registry;
        return $registry;
    }
    
    public static function getInstance()
   {
      if (  !self::$instancia instanceof self)
      {
         self::$instancia = new self;
      }
      return self::$instancia;
   }
   
   //hago un metodo para las conexiones con power campues
   public function conectar(){
   
         //Conexión con la Base de datos del software academico power Campus
         //serverName\instanceName
         $ServerName= $this->serverName;
       //  $connection = array( "Database"=>  $this->database, "UID"=>$this->usuario, "PWD"=>$this->contrasena);
         $connection = array( "Database"=>  $this->database);
         $conn = sqlsrv_connect($ServerName, $connection);

          if( $conn ) {
     
          //echo "Conexión establecida.<br />";
          $this->_registry->powercampus_connection = $conn;
          
            }else{
                 echo "Conexión no se pudo establecer.<br />";
                 die( print_r( sqlsrv_errors(), true));
            }
       
       
       
   }
//    public function _initPowecampus(){
//    $registry = Zend_Registry::getregistry(); 
//    $registry->powercampus = $this;
//   
//   }
   
    public function __clone()
   {
      trigger_error("Operación Invalida: No puedes clonar una instancia de ". get_class($this) ." class.", E_USER_ERROR );
   }
   
    public function __wakeup()
   {
      trigger_error("No puedes deserializar una instancia de ". get_class($this) ." class.");
   }
  
}


