<?php

/**
 * @Entity
 * @Table(name="participante")
 */

class Application_Model_Participantes {
    
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id_participante;
    
    /** @Column(type="string", length=100) */
    private $identificacion;

     /** @Column(type="string", length=100) */
    private $nombre;
    
      /** @Column(type="string", length=50) */
    private $tipo_participante;
    
    
    //Metodo Público
    public function getid_participante(){
        return $this->id_participante;
    }
    public function setidentificacion($ide){
        $this->identificacion =$ide;
    }
    public function setnombre($nom){
    $this->nombre =$nom;
        
    }
    public function settipo_participante($tipo){
        $this->tipo_participante= $tipo;
    }
    
   
    
    
}
