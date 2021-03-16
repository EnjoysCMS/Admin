<?php

declare(strict_types=1);

namespace App\Module\Admin\Controller;


use EnjoysCMS\Core\Components\Helpers\Redirect;
use App\Module\Admin\BaseController;
use App\Module\Admin\Core\Blocks\AddBlocks;
use App\Module\Admin\Core\Blocks\BlockLocations;
use App\Module\Admin\Core\Blocks\EditBlock;
use App\Module\Admin\Core\Blocks\ManageBlocks;

class Blocks extends BaseController
{
    public function manage()
    {
        return $this->view(
            '@a/blocks/manage.twig',
            $this->getContext(
                new ManageBlocks($this->entityManager)
            )
        );
    }

    /**
     * @throws \Exception
     */
    public function delete()
    {
        /** @var \EnjoysCMS\Core\Entities\Blocks $block */
        if(null === $block = $this->entityManager->getRepository(\EnjoysCMS\Core\Entities\Blocks::class)->find($this->serverRequest->get('id'))){
            throw new \InvalidArgumentException('Invalid Arguments');
        }

        if(!$block->isRemovable()){
            throw new \Exception('Block not removable');
        }

        $this->entityManager->remove($block);
        $this->entityManager->flush();

        Redirect::http($this->urlGenerator->generate('admin/blocks'));
//        return $this->view(
//            '@a/blocks/manage.twig',
//            $this->getContext(
//                new ManageBlocks($this->entityManager)
//            )
//        );
    }

    /**
     * @throws \Exception
     */
    public function clone()
    {
        /** @var \EnjoysCMS\Core\Entities\Blocks $block */
        if(null === $block = $this->entityManager->getRepository(\EnjoysCMS\Core\Entities\Blocks::class)->find($this->serverRequest->get('id'))){
            throw new \InvalidArgumentException('Invalid Arguments');
        }

        $cloned = clone $block;
        $cloned->setRemovable(true);
        $cloned->setCloned(true);
        $this->entityManager->persist($cloned);
        $this->entityManager->flush();

        \App\Components\Helpers\ACL::registerAcl(
            $cloned->getBlockActionAcl(),
            $cloned->getBlockCommentAcl()
        );



        Redirect::http($this->urlGenerator->generate('admin/blocks'));
//        return $this->view(
//            '@a/blocks/manage.twig',
//            $this->getContext(
//                new ManageBlocks($this->entityManager)
//            )
//        );
    }


    public function edit()
    {
        return $this->view(
            '@a/blocks/edit.twig',
            $this->getContext(
                new EditBlock($this->twig, $this->entityManager, $this->serverRequest, $this->urlGenerator, $this->renderer)
            )
        );
    }

    public function add()
    {
        return $this->view(
            '@a/blocks/add.twig',
            $this->getContext(
                new AddBlocks($this->entityManager, $this->serverRequest, $this->urlGenerator, $this->renderer)
            )
        );
    }


    public function location()
    {
        return $this->view(
            '@a/blocks/locations.twig',
            $this->getContext(
                new BlockLocations($this->entityManager, $this->serverRequest, $this->urlGenerator, $this->renderer)
            )
        );
    }

    public function setUp()
    {
    }

}
