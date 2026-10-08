<?php
declare(strict_types=1);

namespace App\Modules\Practicas;

use App\Core\Controller;
use App\Core\Database;

class ParticipantesController extends Controller
{
    public function guardarparticipanteAction(): void
    {
        $this->requireAuth([1, 2]);

        $nombre = trim((string)$this->param('nombre', ''));
        $identificacion = (int)$this->param('identificacion', 0);
        $tipo = trim((string)$this->param('tipo', 'auxiliar'));

        $id = Database::insert('participante', [
            'nombre'            => $nombre,
            'identificacion'    => $identificacion,
            'tipo_participante' => $tipo,
        ]);

        $this->json(['id' => $id, 'nombre' => $nombre]);
    }
}
