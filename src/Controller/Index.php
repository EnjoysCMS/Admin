<?php


namespace App\Modules\Admin\Controller;


use App\Modules\Admin\BaseController;

class Index extends BaseController
{

    public function dashboard(): string
    {
        return $this->twig->render('@a/dashboard/dashboard.twig');
    }




}
