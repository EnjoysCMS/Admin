<?php


namespace App\Module\Admin\Controller;


use App\Module\Admin\BaseController;
use App\Module\Admin\Core\Groups\Add;
use App\Module\Admin\Core\Groups\Delete;
use App\Module\Admin\Core\Groups\Edit;
use Doctrine\ORM\EntityManager;
use Enjoys\Forms\Renderer\RendererInterface;
use Enjoys\Http\ServerRequestInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;


class Groups extends BaseController
{

    /**
     * @var \Doctrine\ORM\EntityRepository|\Doctrine\Persistence\ObjectRepository
     */
    private $groupsRepository;

    public function __construct(
        Environment $twig,
        ServerRequestInterface $serverRequest,
        EntityManager $entityManager,
        UrlGeneratorInterface $urlGenerator,
        RendererInterface $renderer
    ) {
        parent::__construct($twig, $serverRequest, $entityManager, $urlGenerator, $renderer);
        $this->groupsRepository = $entityManager->getRepository(\EnjoysCMS\Core\Entities\Group::class);
    }

    public function list(): string
    {
        return $this->view(
            '@a/groups/list.twig',
            [
                'groups' => $this->groupsRepository->findAll(),
                '_title' => 'Группы | Admin | ' . \EnjoysCMS\Core\Components\Helpers\Setting::get('sitename')
            ]
        );
    }

    public function edit(): string
    {
        return $this->view(
            '@a/groups/edit.twig',
            $this->getContext(
                new Edit(
                    $this->entityManager,
                    $this->groupsRepository,
                    $this->serverRequest,
                    $this->urlGenerator,
                    $this->renderer
                )
            )
        );
    }


    public function add(): string
    {
        return $this->view(
            '@a/groups/add.twig',
            $this->getContext(
                new Add(
                    $this->groupsRepository,
                    $this->entityManager,
                    $this->serverRequest,
                    $this->urlGenerator,
                    $this->renderer
                )
            )
        );
    }

    public function delete(): string
    {
        return $this->view(
            '@a/groups/delete.twig',
            $this->getContext(
                new Delete(
                    $this->groupsRepository,
                    $this->entityManager,
                    $this->serverRequest,
                    $this->urlGenerator,
                    $this->renderer
                )
            )
        );
    }

}
