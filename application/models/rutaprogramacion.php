<?php

/**
 * @Entity
 * @Table(name="ruta_programacion")
 */

class Application_Model_rutaprogramacion{
    
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $idruta_programacion;
    
     /**
     * Bidirectional - Many users have Many favorite comments (OWNING SIDE)
     *
     * @ManyToOne(targetEntity="Application_Model_Programacion")
     * @JoinColumn(name="codigo_prog", referencedColumnName="codigo_prog")
     */
    private $codigo_prog;
    
       /**
     * Bidirectional - Many users have Many favorite comments (OWNING SIDE)
     *
     * @ManyToOne(targetEntity="Application_Model_Rutas")
     * @JoinColumn(name="cod_ruta", referencedColumnName="cod_ruta")
     */
    private $cod_ruta;
    
   
    //Metodo Público
  
    public function setcodigo_prog($pro){
    $this->codigo_prog =$pro;
        
    }
    
     public function setcod_ruta($ru){
    $this->cod_ruta =$ru;
        
    }
       
}
