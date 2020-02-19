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
        $rootDirectory = $container->getParameter('kernel.root_dir');
        $this->registerStream($rootDirectory);
    }

    /**
     * {@inheritdoc}
     */
    public function boot()
    {
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
                'app-properties' => $rootDirectory.'/Resources/ConnectHollandSuluBlockBundle/templates/properties/',
                'app-property-params' => $rootDirectory.'/Resources/ConnectHollandSuluBlockBundle/templates/params/',
            ]);

            StreamManager::create()->registerStream($stream);
        }
    }
}
