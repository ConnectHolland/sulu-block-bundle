<?php

namespace ConnectHolland\Sulu\BlockBundle;

use Nijens\ProtocolStream\Stream\Stream;
use Nijens\ProtocolStream\StreamManager;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ConnectHollandSuluBlockBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        $streamManager = new StreamManager();
        if (is_null($streamManager->getStream('sulu-block-bundle'))) {
            $rootDirectory = $this->container->get('kernel')->getRootDir();
            $stream = new Stream('sulu-block-bundle', [
                'blocks' => __DIR__.'/Resources/templates/blocks/',
                'properties' => __DIR__.'/Resources/templates/properties/',
                'app-properties' => $rootDirectory.'/Resources/ConnectHollandSuluBlockBundle/templates/properties/',
            ]);

            StreamManager::create()->registerStream($stream);
        }

        $this->container->get('twig.loader')->addPath($this->getPath().'/Resources/views', 'sulu-block-bundle');

        parent::boot();
    }
}
