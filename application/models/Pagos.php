<?php

/**
 * @Entity
 * @Table(name="pagos")
 */

class Application_Model_Pagos {
    
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id_pagos;
    
    /** @Column(type="string", length=100) */
    private $estado;
    
    /**
     * Bidirectional - Many users have Many favorite comments (OWNING SIDE)
     *
     * @ManyToOne(targetEntity="Application_Model_Partirespos")
     * @JoinColumn(name="id_responsable", referencedColumnName="id_responsable")
     */
    private $id_responsable;
    
      /**
     * Bidirectional - Many users have Many favorite comments (OWNING SIDE)
     *
     * @ManyToOne(targetEntity="Application_Model_Liquiconductores")
     * @JoinColumn(name="id_conductor", referencedColumnName="id")
     */
    private $id_conductor;
    
   
    
    //Metodo Público
   public function setid_pagos($pagos){
      $this->id_pagos= $pagos; 
   }
   public function setestado($esta){
       $this->estado= $esta;
   }
   public function setid_responsable($res){
       $this->id_responsable= $res;
   }
   public function setid_conductor($con){
       $this->id_conductor= $con;
   }
   
    
    
}
