<?php

/**
 * @Entity
 * @Table(name="conductor")
 */

class Application_Model_Conductores {
    
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id_conductor;
   
     /** @Column(type="string", length=256) */
    private $identificacion; 
    
    /** @Column(type="string", length=45) */
    private $nombre;
    
    /** @Column(type="string", length=50) */
    private $apellido;
    
     /** @Column(type="string", length=50) */
    private $telefono;
    
     /** @Column(type="string", length=50) */
    private $direccion;

     /** @Column(type="datetime") */
    private $fecha_registro;
    
    //Metodo Público
    public function setidentificacion($ide){
        $this->identificacion= $ide;
    }
    public function setnombre($nom){
    $this->nombre =$nom;
        
    }
    public function setapellido($ape){
     $this->apellido =$ape;   
    }
    public function settelefono($tel){
        $this->telefono= $tel;  
    }
    public function setdireccion($dir){
        $this->direccion= $dir;
    }

    public function __construct() {
        // la variable now, se comporta como un objeto donde la fecha se haga automaticamente..
        $this->fecha_registro =new DateTime('now');
        
        
    }
    
    
}
