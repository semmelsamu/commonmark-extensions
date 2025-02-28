<?php

namespace Semmelsamu\CommonmarkExtensions\Callout;

use League\CommonMark\Extension\ExtensionInterface;
use League\CommonMark\Environment\EnvironmentBuilderInterface;

final class CalloutExtension implements ExtensionInterface
{
    public function register(EnvironmentBuilderInterface $environment): void
    {
        $environment
            ->addBlockStartParser(new CalloutStartParser(), 80)
            ->addRenderer(Callout::class, new CalloutRenderer());
    }
}
