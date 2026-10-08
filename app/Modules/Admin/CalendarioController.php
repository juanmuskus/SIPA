<?php
declare(strict_types=1);

namespace App\Modules\Admin;

use App\Core\Controller;
use App\Core\Database;

class CalendarioController extends Controller
{
    public function indexAction(): void
    {
        $this->listarcalendarAction();
    }

    public function listarcalendarAction(): void
    {
        $this->requireAuth([1]);

        $sql = "SELECT c.*, a.annio AS annio_nombre, p.periodo AS periodo_nombre 
                FROM calendario_practica c 
                LEFT JOIN annio a ON c.id_annio = a.id_annio 
                LEFT JOIN periodo p ON c.id_periodo = p.id_periodo 
                ORDER BY c.id DESC";
        $calendarios = Database::fetchAll($sql);

        $this->render('admin/calendario/listar', ['calendarios' => $calendarios], 'admin');
    }

    public function agregarcalendarAction(): void
    {
        $this->requireAuth([1]);

        $annios = Database::fetchAll("SELECT * FROM annio ORDER BY annio DESC");
        $periodos = Database::fetchAll("SELECT * FROM periodo ORDER BY periodo ASC");

        $this->render('admin/calendario/agregar', [
            'annios'   => $annios,
            'periodos' => $periodos
        ], 'admin');
    }

    public function guardarcalendarAction(): void
    {
        $this->requireAuth([1]);

        $idAnnio = (int)$this->param('annio', 0);
        $idPeriodo = (int)$this->param('periodo', 0);
        $fechaInicio = (string)$this->param('fecha_inicio', '');
        $fechaFinal = (string)$this->param('fecha_final', '');

        // Convert d/m/Y to Y-m-d if needed
        $fInicio = $this->formatDate($fechaInicio);
        $fFinal = $this->formatDate($fechaFinal);

        Database::insert('calendario_practica', [
            'id_annio'       => $idAnnio,
            'id_periodo'     => $idPeriodo,
            'fecha_inicio'   => $fInicio,
            'fecha_fin'      => $fFinal,
            'estado'         => 1,
            'fecha_registro' => date('Y-m-d H:i:s'),
        ]);

        if ($this->request->isAjax()) {
            echo "Calendario guardado con éxito";
            exit;
        }

        $this->redirect('/calendar/listarcalendar');
    }

    public function editarcalendarAction(): void
    {
        $this->requireAuth([1]);

        $id = (int)$this->param('id', 0);
        $calendario = Database::fetch("SELECT * FROM calendario_practica WHERE id = :id", [':id' => $id]);

        if (!$calendario) {
            $this->redirect('/calendar/listarcalendar');
        }

        $annios = Database::fetchAll("SELECT * FROM annio ORDER BY annio DESC");
        $periodos = Database::fetchAll("SELECT * FROM periodo ORDER BY periodo ASC");

        $this->render('admin/calendario/editar', [
            'calendario' => $calendario,
            'annios'     => $annios,
            'periodos'   => $periodos
        ], 'admin');
    }

    public function actualizarcalendarAction(): void
    {
        $this->requireAuth([1]);

        $id = (int)$this->param('id', 0);
        $idAnnio = (int)$this->param('annio', 0);
        $idPeriodo = (int)$this->param('periodo', 0);
        $estado = (int)$this->param('estado', 1);
        $fechaInicio = (string)$this->param('fecha_inicio', '');
        $fechaFinal = (string)$this->param('fecha_final', '');

        $fInicio = $this->formatDate($fechaInicio);
        $fFinal = $this->formatDate($fechaFinal);

        Database::update('calendario_practica', [
            'id_annio'     => $idAnnio,
            'id_periodo'   => $idPeriodo,
            'estado'       => $estado,
            'fecha_inicio' => $fInicio,
            'fecha_fin'    => $fFinal,
        ], 'id = :id', [':id' => $id]);

        if ($this->request->isAjax()) {
            echo "Calendario actualizado con éxito";
            exit;
        }

        $this->redirect('/calendar/listarcalendar');
    }

    public function eliminarcalendarAction(): void
    {
        $this->requireAuth([1]);

        $id = (int)$this->param('calendar_id', $this->param('id', 0));
        if ($id > 0) {
            Database::delete('calendario_practica', 'id = :id', [':id' => $id]);
        }

        if ($this->request->isAjax()) {
            echo "Calendario eliminado con éxito";
            exit;
        }

        $this->redirect('/calendar/listarcalendar');
    }

    private function formatDate(string $dateStr): string
    {
        $dateStr = trim($dateStr);
        if (str_contains($dateStr, '/')) {
            $parts = explode('/', $dateStr);
            if (count($parts) === 3) {
                return sprintf('%04d-%02d-%02d', (int)$parts[2], (int)$parts[1], (int)$parts[0]);
            }
        }
        return $dateStr ?: date('Y-m-d');
    }
}
