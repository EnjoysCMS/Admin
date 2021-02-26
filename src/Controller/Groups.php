<?php


namespace App\Modules\Admin\Controller;


use App\Modules\Admin\BaseController;

class Groups extends BaseController
{
    private function view(string $twigTemplatePath, array $context = [])
    {
        return $this->twig->render($twigTemplatePath, $context);
    }

    public function list(): string
    {

        return $this->view('@a/groups/list.twig');
    }
}
