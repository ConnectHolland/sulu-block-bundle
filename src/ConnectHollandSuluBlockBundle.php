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
        $stream = new Stream('sulu-block-bundle', [
            'blocks' => __DIR__.'/Resources/templates/blocks/',
            'properties' => __DIR__.'/Resources/templates/properties/',
        ]);

        StreamManager::create()->registerStream($stream);

        parent::boot();
    }
}
