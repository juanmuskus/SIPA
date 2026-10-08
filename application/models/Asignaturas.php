<?php

/**
 * @Entity
 * @Table(name="asignatura")
 */

class Application_Model_Asignaturas {
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
   private $cod_asignatura;
   
    /** @Column(type="string", length=100) */
    private $nombre;
   
   /** @Column(type="string", length=100) */
    private $codigo;

    /** @Column(type="string", length=100) */
    private $grupo;
    
    /**
     * Bidirectional - Many users have Many favorite comments (OWNING SIDE)
     *
     * @ManyToOne(targetEntity="Application_Model_Programas")
     * @JoinColumn(name="cod_programa", referencedColumnName="id_programa")
     */
  private $cod_programa;
  
     /**
     * Bidirectional - Many users have Many favorite comments (OWNING SIDE)
     *
     * @ManyToOne(targetEntity="Application_Model_Facultades")
     * @JoinColumn(name="id_facultad", referencedColumnName="id_facultad")
     */
  private $id_facultad;
  
  /**
     * Bidirectional - Many users have Many favorite comments (OWNING SIDE)
     *
     * @ManyToOne(targetEntity="Application_Model_Sedes")
     * @JoinColumn(name="id_sede", referencedColumnName="id_sede")
     */
  private $id_sede;
   
   /** @Column(type="datetime") */
   private $fecha_registro;


  //Set de Nombre   
  public function setnombre($nom){
      $this->nombre =$nom;
  }
  public function __construct() {
        // la variable now, se comporta como un objeto donde la fecha se haga automaticamente..
        $this->fecha_registro =new DateTime('now');
           
    }
    public function setcodigo($cod){
        $this->codigo= $cod;
    }
    public function setgrupo($gru){
        $this->grupo= $gru;
    }

    public function setcod_programa($cod){
        $this->cod_programa =$cod;
    }
    public function setid_facultad($fac){
        $this->id_facultad= $fac;
        
    }
    public function setid_sede($se){
        $this->id_sede= $se;
        
    }
}
