<?php

/**
 * @Entity
 * @Table(name="annio")
 */

class Application_Model_Annio{
     /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
   private $id_annio;
   
    /** @Column(type="string", length=50) */
    private $annio;
  
   //metodos públicos
   public function setid_annio($in){
   $this->id_annio= $in; 
   }
   //Set annio   
  public function setannio($ann){
      $this->annio =$ann;
  }
 
}
