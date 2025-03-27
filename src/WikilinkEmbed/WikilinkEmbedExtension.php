<?php

declare(strict_types=1);

namespace Semmelsamu\CommonmarkExtensions\WikilinkEmbed;

use League\CommonMark\Environment\EnvironmentBuilderInterface;
use League\CommonMark\Extension\ConfigurableExtensionInterface;
use League\Config\ConfigurationBuilderInterface;
use Nette\Schema\Expect;
use Semmelsamu\CommonmarkExtensions\WikilinkEmbed\Embed;
use Semmelsamu\CommonmarkExtensions\WikilinkEmbed\EmbedIframeRenderer;

final class WikilinkEmbedExtension implements ConfigurableExtensionInterface
{
    public function configureSchema(ConfigurationBuilderInterface $builder): void
    {
        $builder->addSchema('wikilink_embed', Expect::structure([
            'resolve' => Expect::callable()->default(function (string $wikilink) {
                return $wikilink;
            })
        ]));
    }

    public function register(EnvironmentBuilderInterface $environment): void
    {
        $config = $environment->getConfiguration()->get('wikilink_embed');

        $environment->addBlockStartParser(new WikilinkEmbedStartParser(
            $config['resolve']
        ), 100);

        $environment->addRenderer(Embed::class, new EmbedIframeRenderer(), -100);
    }
}
