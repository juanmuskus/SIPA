<?php

/**
 * @Entity
 * @Table(name="liquidar_practica")
 */

class Application_Model_LiquidarPractica {
    
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id_liquidar;
    
     /** @Column(type="string", length=256) */
    private $viaticos;
    
    /** @Column(type="string", length=256) */
    private $aux_estudiante;
    
     /** @Column(type="string", length=256) */
    private $transporte_especial;
    
    /** @Column(type="string", length=45) */
    private $estado;


    /** @Column(type="datetime") */
    private $fecha_pago;
    
      /** @Column(type="datetime") */
    private $fecha_legalizado;
    
      /** @Column(type="datetime") */
    private $fecha_modificacion;
    
      /** @Column(type="string", length=256) */
    private $legalizado;
    
     
     /**
     * Bidirectional - Many users have Many favorite comments (OWNING SIDE)
     *
     * @ManyToOne(targetEntity="Application_Model_Practicas", inversedBy="liquidarpractica")
     * @JoinColumn(name="cod_practica", referencedColumnName="cod_practica")
     */
    private $cod_practica;
    /**
     * Bidirectional - Many users have Many favorite comments (OWNING SIDE)
     *
     * @ManyToOne(targetEntity="Application_Model_Participantes")
     * @JoinColumn(name="id_participante", referencedColumnName="id_participante")
     
    private $id_participante; */
     /**
     * Bidirectional - Many users have Many favorite comments (OWNING SIDE)
     *
     * @ManyToOne(targetEntity="Application_Model_Progrecursos")
     * @JoinColumn(name="id_pro", referencedColumnName="id_pro")
    
     private $id_pro;  */


    //Metodo Público
    public function setviaticos($via){
        $this->viaticos= $via;
    } 
     
    public function setaux_estudiante($aux){
    $this->aux_estudiante =$aux;
        
    }
    public function settransporte_especial($tra){
        $this->transporte_especial=$tra;
    }
    public function setestado($esta){
        $this->estado= $esta;
    }

    public function setfecha_pago($fe){
        $this->fecha_pago=$fe;  
    }
    public function setfecha_legalizado($lega){
        $this->fecha_legalizado=$lega;
    }
    public function setlegalizado($le){
        $this->legalizado=$le;
    }
    public function setcod_practica($cod){
        $this->cod_practica=$cod;
    }
  /**   public function setid_participante($par){
        $this->id_participante=$par;
    } 
     public function setid_pro($pro){
        $this->id_pro=$pro;
    } */

    public function __construct() {
        // la variable now, se comporta como un objeto donde la fecha se haga automaticamente..
        $this->fecha_modificacion =new DateTime('now');
           
    }
    
    
}
