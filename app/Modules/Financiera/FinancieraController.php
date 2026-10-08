<?php
declare(strict_types=1);

namespace App\Modules\Financiera;

use App\Core\Controller;

class FinancieraController extends Controller
{
    public function indexAction(): void
    {
        $this->requireAuth([1, 4]);
        $this->render('financiera/index', [], 'financiera');
    }

    public function index(): void
    {
        $this->indexAction();
    }
}
