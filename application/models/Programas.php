<?php

/**
 * @Entity
 * @Table(name="programas")
 */



class Application_Model_Programas {
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id_programa;
    
    /** @Column(type="string", length=70) */
    
    private $nombre;
    
   /** @Column(type="datetime") */
    
   private $fechacreacion;
   
   /**
     * Bidirectional - Many users have Many favorite comments (OWNING SIDE)
     *
     * @ManyToOne(targetEntity="Application_Model_Facultades")
     * @JoinColumn(name="cod_facultad", referencedColumnName="id_facultad")
     */
  
  
   private $cod_facultad;
   
   //Metodo Público
    public function setnombre($nom){
    $this->nombre =$nom;
        
    }
    public function __construct() {
        // la variable now, se comporta como un objeto donde la fecha se haga automaticamente..
        $this->fechacreacion =new DateTime('now');
        
        
    }
    public function setcod_facultad($cod){
        $this->cod_facultad =$cod;  
    }
          
    
}
