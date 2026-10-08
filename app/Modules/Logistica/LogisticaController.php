<?php
declare(strict_types=1);

namespace App\Modules\Logistica;

use App\Core\Controller;

class LogisticaController extends Controller
{
    public function indexAction(): void
    {
        $this->requireAuth([1, 3]);
        $this->render('logistica/index', [], 'logistica');
    }

    public function index(): void
    {
        $this->indexAction();
    }
}
