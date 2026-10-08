<?php

/**
 * @Entity
 * @Table(name="sede")
 */

class Application_Model_Sedes {
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
   private $id_sede;
   
    /** @Column(type="string", length=100) */
    private $nombre;

    /** @Column(type="datetime") */
   private $fecha_creacion;
   
  
   //Set id_rol
   public function setid_sede($se){
   $this->id_sede= $se; 
   }
   //Set de Nombre   
  public function setnombre($nom){
      $this->nombre =$nom;
  }
  public function __construct() {
        // la variable now, se comporta como un objeto donde la fecha se haga automaticamente..
        $this->fecha_creacion =new DateTime('now');
           
    }  
    
}
