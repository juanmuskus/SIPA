<?php

/**
 * @Entity
 * @Table(name="servicio")
 */

class Application_Model_Servicios {
    
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $cod_servicio;
    
    /** @Column(type="string", length=100) */
    private $tipo;
    
    /** @Column(type="string", length=256) */
    private $valor;
    
    /** @Column(type="string", length=256) */
    private $observacion;

    /** @Column(type="datetime") */
    private $fecha_registro;
    
    /**
     * Bidirectional - Many users have Many favorite comments (OWNING SIDE)
     *
     * @ManyToOne(targetEntity="Application_Model_Programacion")
     * @JoinColumn(name="codigo_prog", referencedColumnName="codigo_prog")
     */
    private $codigo_prog;


    //Metodo Público
    public function settipo($ti){
    $this->tipo =$ti;
        
    }
    public function setvalor($val){
        $this->valor= $val;
    }
    public function setobservacion($obs){
        $this->observacion= $obs;
    }

    public function setcodigo_prog($codigo){
        $this->codigo_prog= $codigo;
    }

    public function __construct() {
        // la variable now, se comporta como un objeto donde la fecha se haga automaticamente..
        $this->fecha_registro =new DateTime('now');
        
        
    }
    
    
}
