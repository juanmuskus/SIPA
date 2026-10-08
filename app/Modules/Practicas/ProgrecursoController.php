<?php
declare(strict_types=1);

namespace App\Modules\Practicas;

use App\Core\Controller;
use App\Core\Database;

class ProgrecursoController extends Controller
{
    public function guardarprogrecursoAction(): void
    {
        $this->requireAuth([1, 2]);

        $valor = (float)$this->param('valor', 0);
        $idRecurso = (int)$this->param('idrecurso', 0);

        $id = Database::insert('programacion_recursos', [
            'valor'          => $valor,
            'id_recursos'    => $idRecurso,
            'fecha_registro' => date('Y-m-d H:i:s'),
        ]);

        $this->json(['id_pro' => $id]);
    }

    public function eliminarprogrecursoAction(): void
    {
        $this->requireAuth([1, 2]);

        $id = (int)$this->param('id', $this->param('facultad_id', 0));
        if ($id > 0) {
            Database::delete('programacion_recursos', 'id_pro = :id', [':id' => $id]);
        }
        $this->json(['status' => 'ok']);
    }

    public function visualizarprogrecursoAction(): void
    {
        $this->requireAuth([1, 2]);

        $tipoDef = (string)$this->param('tipo_def', '-1');

        if ($tipoDef !== '-1' && $tipoDef !== '') {
            $ids = array_filter(array_map('intval', explode(',', str_replace(['"', "'"], '', $tipoDef))));
            if (!empty($ids)) {
                $placeholders = implode(',', $ids);
                $sql = "SELECT pr.id_pro AS id, pr.valor, r.nombre 
                        FROM programacion_recursos pr 
                        JOIN recursos_especiales r ON pr.id_recursos = r.id_recursos 
                        WHERE pr.id_pro IN ({$placeholders})";
                $recursos = Database::fetchAll($sql);
                $this->json($recursos);
                return;
            }
        }

        $this->json([]);
    }
}
