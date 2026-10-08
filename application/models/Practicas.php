 <?php
 use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(name="practica")
 */

class Application_Model_Practicas {
    
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $cod_practica;
    
    /** @Column(type="string", length=100) */
    private $nombre;
    
    /** @Column(type="string", length=100) */
    private $num_estudiantes;
    
    /** @Column(type="string", length=100) */
    private $nom_solicitante;
     
     /** @Column(type="string", length=3000) */
    private $justificacion;
    
     /** @Column(type="string", length=2000) */
    private $objetivo;
    
     /** @Column(type="string", length=2000) */
    private $actividad_doc;
    
     /** @Column(type="string", length=2000) */
    private $actividad_est;
    
     /** @Column(type="string", length=300) */
    private $tipo_practica;
    
     /** @Column(type="datetime") */
    private $fecha_registro;
    
     /** @Column(type="string", length=200) */
    private $semestre;
    
    /**
     * @OneToMany(targetEntity="Application_Model_Programacion", mappedBy="cod_practica", cascade={"persist"})
     */
   
     private $programaciones;
     
     /**
     * @OneToMany(targetEntity="Application_Model_LiquidarPractica", mappedBy="cod_practica", cascade={"persist"})
     */
     
      private $liquidarpractica;


      /** @Column(type="string", length=256) */
     private $facultad;
     
     /** @Column(type="string", length=256) */
    private $departamento;
    
     /** @Column(type="string", length=256) */
    private  $programa;
    
     /** @Column(type="string", length=256) */
    private $asignatura;
    
      /** @Column(type="string", length=256) */
    private $grupo;
      /**
     * Bidirectional - Many users have Many favorite comments (OWNING SIDE)
     *
     * @ManyToOne(targetEntity="Application_Model_calendar")
     * @JoinColumn(name="id_calendario", referencedColumnName="id")
     */ 
    
    private $id_calendario;
    
   
        //Metodo Público
    public function setnombre($nom){
    $this->nombre =$nom;
        
    }
    public function setnum_estudiantes($num){
        $this->num_estudiantes= $num;
    }

    public function setnom_solicitante($sol){
    $this->nom_solicitante =$sol;
        
    }
    
    public function setjustificacion($jus){
        $this->justificacion= $jus;
        
    }
    public function setobjetivo($obj){
        $this->objetivo= $obj;
        
    }
    public function setactividad_doc($doc){
        $this->actividad_doc= $doc;
        
    }
    public function setactividad_est($est){
        $this->actividad_est= $est;
        
    }
    public function settipo_practica($tipo){
        $this->tipo_practica =$tipo;
        
    }
    public function setsemestre($sem){
        $this->semestre= $sem;
        
    }
    public function setdepartamento($dep){
        $this->departamento= $dep;
        
    }
    public function setasignatura($asigna){
        $this->asignatura= $asigna;
        
    }
    public function setfacultad($fac){
        $this->facultad= $fac;
    }
    public function setprograma($pro){
        $this->programa=$pro;
    }
    public function setgrupo($gru){
        $this->grupo= $gru;
    }

    public function setprogramaciones($prog){
        $this->programaciones=$prog;
    }
    public function getprogramaciones(){
        return $this->programaciones;
    }
    public function setliquidarpractica($liq){
        $this->liquidarpractica=$liq;
    }
    public function getliquidarpractica(){
        return $this->liquidarpractica;
    }

    public function setid_calendario($cal){
        $this->id_calendario= $cal;
        
    }

    public function setcod_practica($id){
        $this->cod_practica= $id;
        
    }

    public function __construct() {
        // la variable now, se comporta como un objeto donde la fecha se haga automaticamente..
        $this->fecha_registro =new DateTime('now');
        $this->programaciones = new ArrayCollection();
        $this->liquidarpractica= new ArrayCollection();
        
        
    }
    
    
    
}
