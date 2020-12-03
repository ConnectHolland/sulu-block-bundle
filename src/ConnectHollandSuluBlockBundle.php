<?php

namespace ConnectHolland\Sulu\BlockBundle;

use Nijens\ProtocolStream\StreamManager;
use Nijens\ProtocolStream\Stream\Stream;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ConnectHollandSuluBlockBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $rootDirectory = $container->getParameter('kernel.project_dir');
        $this->registerStream($rootDirectory);
    }

    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        $rootDirectory = $this->container->get('kernel')->getProjectDir();
        $this->registerStream($rootDirectory);
        $this->container->get('twig')->getLoader()->addPath($this->getPath().'/Resources/views', 'sulu-block-bundle');

        parent::boot();
    }

    /**
     * Register the stream for the given $rootDirectory.
     *
     * @param string $rootDirectory
     */
    private function registerStream($rootDirectory)
    {
        $streamManager = new StreamManager();
        if (is_null($streamManager->getStream('sulu-block-bundle'))) {
            $stream = new Stream('sulu-block-bundle', [
                'blocks' => __DIR__.'/Resources/templates/blocks/',
                'properties' => __DIR__.'/Resources/templates/properties/',
                'app-properties' => $rootDirectory.'/config/templates/ConnectHollandSuluBlockBundle/properties/',
                'app-property-params' => $rootDirectory.'/config/templates/ConnectHollandSuluBlockBundle/params/',
            ]);

            StreamManager::create()->registerStream($stream);
        }
    }
}
