<?php

/**
 * @Entity
 * @Table(name="ruta")
 */

class Application_Model_Rutas {
    
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $cod_ruta;
    
    /** @Column(type="string", length=50) */
    private $origen;
    
     /** @Column(type="string", length=50) */
    private $destino;
    
      
     /** @Column(type="string", length=256) */
    private $ruta;
    
    /** @Column(type="string", length=256) */
    private $sitio;

     /** @Column(type="datetime") */
    private $fecha_registro;
    
    //Metodo Público
    public function setorigen($ori){
    $this->origen =$ori;
        
    }
    public function setdestino($des){
    $this->destino= $des;    
        
    }
    public function setruta($rut){
     $this->ruta=$rut;
    }
    public function setsitio($si){
        $this->sitio=$si;
    }


        public function __construct() {
        // la variable now, se comporta como un objeto donde la fecha se haga automaticamente..
        $this->fecha_registro =new DateTime('now');
        
        
    }
    
    
}
