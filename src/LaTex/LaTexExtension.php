<?php

namespace App\MarkdownExtensions\LaTex;

use League\CommonMark\Environment\EnvironmentBuilderInterface;
use League\CommonMark\Extension\ExtensionInterface;

class LaTexExtension implements ExtensionInterface
{
    public function register(EnvironmentBuilderInterface $environment): void
    {
        $environment
            ->addInlineParser(new LaTexInlineParser(), 190)
            ->addBlockStartParser(new LaTexBlockStartParser(), 200)
            ->addRenderer(LaTexInline::class, new LaTexInlineRenderer(), 200)
            ->addRenderer(LaTexBlock::class, new LaTexBlockRenderer());
    }
}
