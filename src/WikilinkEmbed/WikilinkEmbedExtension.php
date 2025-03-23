<?php

declare(strict_types=1);

namespace Semmelsamu\CommonmarkExtensions\WikilinkEmbed;

use League\CommonMark\Environment\EnvironmentBuilderInterface;
use League\CommonMark\Extension\ConfigurableExtensionInterface;
use League\Config\ConfigurationBuilderInterface;
use Nette\Schema\Expect;
use Semmelsamu\CommonmarkExtensions\WikilinkEmbed\Embed;
use Semmelsamu\CommonmarkExtensions\WikilinkEmbed\EmbedCustomRenderer;
use Semmelsamu\CommonmarkExtensions\WikilinkEmbed\EmbedFallbackRenderer;

final class WikilinkEmbedExtension implements ConfigurableExtensionInterface
{
    public function configureSchema(ConfigurationBuilderInterface $builder): void
    {
        $builder->addSchema('wikilink_embed', Expect::structure([
            'resolve' => Expect::callable()->default(function (string $wikilink) {
                return $wikilink;
            }),
            'renderers' => Expect::arrayOf(
                Expect::callable()->required()
            )->default([])
        ]));
    }

    public function register(EnvironmentBuilderInterface $environment): void
    {
        $config = $environment->getConfiguration()->get('wikilink_embed');

        $environment->addBlockStartParser(new WikilinkEmbedStartParser(
            $config['resolve']
        ), 100);

        foreach ($config['renderers'] as $renderer) {
            $environment->addRenderer(Embed::class, new EmbedCustomRenderer(
                $renderer
            ), 100);
        }

        $environment->addRenderer(Embed::class, new EmbedFallbackRenderer(), 100);
    }
}
