<?php
declare(strict_types=1);

namespace App\Modules\Admin;

use App\Core\Controller;

class AdminController extends Controller
{
    public function index(): void
    {
        $this->requireAuth([1]);
        $this->render('admin/index', [], 'admin');
    }

    public function admin(): void
    {
        $this->index();
    }
}
