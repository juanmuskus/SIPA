<?php

/**
 * @Entity
 * @Table(name="calendario_practica")
 */

class Application_Model_calendar {
    
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;
    
      /** @Column(type="date") */
    private $fecha_inicio;
    
      /** @Column(type="date") */
    private $fecha_fin;
    
    /** @Column(type="string", length=50) */
    
    private $estado;

     /** @Column(type="datetime") */
    private $fecha_registro;
    
     /**
     * Bidirectional - Many users have Many favorite comments (OWNING SIDE)
     *
     * @ManyToOne(targetEntity="Application_Model_Annio")
     * @JoinColumn(name="id_annio", referencedColumnName="id_annio")
     */
    private $id_annio;
    
     /**
     * Bidirectional - Many users have Many favorite comments (OWNING SIDE)
     *
     * @ManyToOne(targetEntity="Application_Model_Periodo")
     * @JoinColumn(name="id_periodo", referencedColumnName="id_periodo")
     */
    private $id_periodo;
    
    //Metodo Público
    public function getid(){
        return $this->id;   
    }
    
   
    public function setfecha_inicio($ini){
    $this->fecha_inicio =$ini;
        
    }
    public function setfecha_fin($fin){
    $this->fecha_fin =$fin;
        
    }
    public function setestado($esta){
        $this->estado= $esta;   
    }

    public function setid_annio($ann){
        $this->id_annio= $ann;
        
    }
    public function setid_periodo($per){
        $this->id_periodo=$per;
    }

    public function __construct() {
        // la variable now, se comporta como un objeto donde la fecha se haga automaticamente..
        
        $this->fecha_registro =new DateTime('now');
        
        
    }
    
    
}
