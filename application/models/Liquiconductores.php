<?php

/**
 * @Entity
 * @Table(name="liquidacion_conductor")
 */

class Application_Model_Liquiconductores {
    
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;
    
    /** @Column(type="string", length=256) */
    private $combustible;
    
     /** @Column(type="string", length=256) */
    private $peajes;
    
     /** @Column(type="string", length=256) */
    private $viaticos;
    
     /** @Column(type="string", length=256) */
    private $imprevistos;
    
     /** @Column(type="string", length=50) */
    private $pagado;
    
     /** @Column(type="string", length=50) */
    private $legalizado;
    
     /** @Column(type="datetime") */
    private $fecha_pago;
    
    /** @Column(type="string", length=100) */
    
    private $observacion;
    
     /** @Column(type="datetime") */
    private $fecha_legalizado;
    
     /** @Column(type="datetime") */
    private $fecha_registro;
    
    /**
     * Bidirectional - Many users have Many favorite comments (OWNING SIDE)
     *
     * @ManyToOne(targetEntity="Application_Model_Practicas")
     * @JoinColumn(name="cod_practica", referencedColumnName="cod_practica")
     */
    private $cod_practica;
    
    /**
     * Bidirectional - Many users have Many favorite comments (OWNING SIDE)
     *
     * @ManyToOne(targetEntity="Application_Model_Conductores")
     * @JoinColumn(name="id_conductor", referencedColumnName="id_conductor")
     */
    private $id_conductor;
    
      /**
     * Bidirectional - Many users have Many favorite comments (OWNING SIDE)
     *
     * @ManyToOne(targetEntity="Application_Model_Transporte")
     * @JoinColumn(name="cod_transporte", referencedColumnName="cod_transporte")
     */
    
    private $cod_transporte;
    
    
    //Metodo Público
    public function setcombustible($com){
    $this->combustible =$com;
        
    }
    public function setpeajes($pe){
    $this->peajes=$pe;    
    }
    public function setviaticos($via){
        $this->viaticos=$via;    
    }
    public function setimprevistos($impre){
        $this->imprevistos=$impre;
    }
    public function setpagado($paga){
        $this->pagado=$paga;
    }
    public function setlegalizado($lega){
        $this->legalizado=$lega;
    }
    public function setfecha_pago($fecha){
        $this->fecha_pago=$fecha;
    }
    public function setfecha_legalizado($fe){
        $this->fecha_legalizado=$fe;
    }
    public function setobservacion($obs){
        $this->observacion=$obs;
    }
           
    public function setid_conductor($condu){
        $this->id_conductor=$condu;
    }
    public function setcod_practica($pra){
        $this->cod_practica= $pra;
    }
    public function setcod_transporte($tra){
        $this->cod_transporte=$tra;
    } 


    public function __construct() {
        // la variable now, se comporta como un objeto donde la fecha se haga automaticamente..
        $this->fecha_registro =new DateTime('now');
        
        
    }
    
    
}
