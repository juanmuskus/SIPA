<?php

/**
 * @Entity
 * @Table(name="periodo")
 */

class Application_Model_Periodo {
     /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
   private $id_periodo;
   
    /** @Column(type="string", length=2) */
    private $periodo;

   
   //metodos Públicos
   public function setid_periodo($per){
   $this->id_periodo= $per; 
   }
   //Set periodo  
  public function setperiodo($pe){
      $this->periodo =$pe;
  }
  
    
}
