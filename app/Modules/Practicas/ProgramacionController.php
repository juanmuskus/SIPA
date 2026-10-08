<?php
declare(strict_types=1);

namespace App\Modules\Practicas;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Session;

class ProgramacionController extends Controller
{
    public function listarprogramacionAction(): void
    {
        $this->requireAuth([1, 2, 3]);

        $practicaId = (int)$this->param('p', $this->param('id', 0));
        $practica = Database::fetch("SELECT * FROM practica WHERE cod_practica = :id", [':id' => $practicaId]);

        $programaciones = Database::fetchAll("SELECT p.*, r.origen, r.destino, r.sitio, r.ruta AS ruta_nombre
                                              FROM programacion p 
                                              LEFT JOIN ruta r ON p.recorrido = r.cod_ruta 
                                              WHERE p.cod_practica = :id 
                                              ORDER BY p.num_dias ASC", [':id' => $practicaId]);

        // Load participants and special resources for each day
        foreach ($programaciones as &$prog) {
            $progId = (int)$prog['codigo_prog'];
            $prog['participantes'] = Database::fetchAll("SELECT par.* 
                                                          FROM programacion_participante pp 
                                                          JOIN participante par ON pp.id_participante = par.id_participante 
                                                          WHERE pp.codigo_prog = :p", [':p' => $progId]);
            $prog['recursos'] = Database::fetchAll("SELECT pr.valor, re.nombre 
                                                    FROM recursos_programados rp 
                                                    JOIN programacion_recursos pr ON rp.id_pro = pr.id_pro 
                                                    JOIN recursos_especiales re ON pr.id_recursos = re.id_recursos 
                                                    WHERE rp.codigo_prog = :p", [':p' => $progId]);
        }

        $roleId = Session::roleId();
        $layout = match ($roleId) {
            1 => 'admin',
            2 => 'departamento',
            3 => 'logistica',
            default => 'admin'
        };

        $this->render('practicas/programacion_listar', [
            'practica'       => $practica,
            'programaciones' => $programaciones,
        ], $layout);
    }
}
