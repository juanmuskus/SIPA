<?php

/**
 * @Entity
 * @Table(name="grupo")
 */

class Application_Model_Grupo {
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
   private $id_grupo;
   
    /** @Column(type="string", length=20) */
    private $nombre;
   
  
   
  
   //Set id_rol
   public function setid_grupo($gru){
       $this->id_grupo= $gru; 
   }
   //Set de Nombre   
  public function setnombre($nom){
      $this->nombre =$nom;
  }
   
    
}
