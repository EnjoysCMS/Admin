<?php


namespace App\Module\Admin\Core\Blocks;


use App\Module\Admin\Core\ModelInterface;
use Doctrine\ORM\EntityManager;
use Enjoys\Config\Config;
use Enjoys\Config\Parse\YAML;
use Enjoys\Forms\Renderer\RendererInterface;
use Enjoys\Http\ServerRequestInterface;
use EnjoysCMS\Core\Entities\Blocks;
use Psr\Log\LoggerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SetupBlocks implements ModelInterface
{


    private LoggerInterface $logger;

    public function __construct(
        LoggerInterface $logger
    ) {
        $this->logger = $logger->withName('Blocks Config');
    }

    /**
     * @throws \Exception
     */
    public function getContext(): array
    {
        $allBlocks = new Config($this->logger);
        $configs = array_merge(
            [$_ENV['PROJECT_DIR'] . '/app/blocks.yml'],
            glob($_ENV['PROJECT_DIR'] . '/modules/*/blocks.yml'),
        );

        foreach ($configs as $config) {
            $allBlocks->addConfig($config, [], YAML::class);
        }

        return ['blocks' => $allBlocks->getConfig()];
    }
}
