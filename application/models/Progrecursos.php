<?php

/**
 * @Entity
 * @Table(name="programacion_recursos")
 */

class Application_Model_Progrecursos{
    
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id_pro;
    
    /** @Column(type="string", length=256) */
    private $valor;
    
       /**
     * Bidirectional - Many users have Many favorite comments (OWNING SIDE)
     *
     * @ManyToOne(targetEntity="Application_Model_Recurespeciales")
     * @JoinColumn(name="id_recursos", referencedColumnName="id_recursos")
     */
    private $id_recursos;
    
     /** @Column(type="datetime") */
    private $fecha_registro;
    //ojo con los nombres -.-
      /**
     * @ManyToMany(targetEntity="Application_Model_Programacion")
     * @JoinTable(name="recursos_programados",
     *      joinColumns={@JoinColumn(name="id_pro", referencedColumnName="id_pro")},
     *      inverseJoinColumns={@JoinColumn(name="codigo_prog", referencedColumnName="codigo_prog")}
     *      )
     */
    
    private $programarecursos;
    
    //Metodo Público
  
    public function setvalor($val){
    $this->valor =$val;
        
    }
    public function setid_recursos($re){
    $this->id_recursos =$re;
        
    }
     public function getid_pro(){
        return $this->id_pro;  
    }
    
    public function getpromarecursos(){
        return $this->programarecursos;
    }
   
    public function __construct() {
        // la variable now, se comporta como un objeto donde la fecha se haga automaticamente..
        $this->fecha_registro =new DateTime('now');
        
        
    }
    
    
}
