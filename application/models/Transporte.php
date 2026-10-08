<?php

/**
 * @Entity
 * @Table(name="transporte")
 */

class Application_Model_Transporte {
    
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $cod_transporte;
    
    /** @Column(type="string", length=20) */
    private $placa;
    
     /** @Column(type="string", length=256) */
    private $descripcion;
    
     /** @Column(type="string", length=100) */
    private $tipo_vehiculo;
    
      /** @Column(type="string", length=50) */
    private $estado_vehiculo;

      /** @Column(type="string", length=500) */
    private $capacidad_pasajeros;
    
     /** @Column(type="datetime") */
    private $fecha_registro;
    
    //Metodo Público
    public function setplaca($pla){
    $this->placa =$pla;
        
    }
    public function setdescripcion($des){
        $this->descripcion= $des;    
    }
    public function settipo_vehiculo($ti){
        $this->tipo_vehiculo=$ti;
    }
    public function setestado_vehiculo($est){
        $this->estado_vehiculo= $est;
    }
    public function setcapacidad_pasajeros($capa){
        $this->capacidad_pasajeros=$capa;
    }
    public function __construct() {
        // la variable now, se comporta como un objeto donde la fecha se haga automaticamente..
        $this->fecha_registro =new DateTime('now');
        
        
    }
    
    
}
