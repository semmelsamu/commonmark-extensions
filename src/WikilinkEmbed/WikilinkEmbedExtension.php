<?php

declare(strict_types=1);

namespace Semmelsamu\CommonmarkExtensions\WikilinkEmbed;

use League\CommonMark\Environment\EnvironmentBuilderInterface;
use League\CommonMark\Extension\ConfigurableExtensionInterface;
use League\Config\ConfigurationBuilderInterface;
use Nette\Schema\Expect;
use Semmelsamu\CommonmarkExtensions\WikilinkEmbed\Embed\Embed;
use Semmelsamu\CommonmarkExtensions\WikilinkEmbed\Embed\EmbedRenderer;
use Semmelsamu\CommonmarkExtensions\WikilinkEmbed\Embed\Image;
use Semmelsamu\CommonmarkExtensions\WikilinkEmbed\Embed\ImageRenderer;

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
        $environment->addBlockStartParser(new WikilinkEmbedStartParser(
            $environment->getConfiguration()->get('wikilink_embed.resolve')
        ), 100);

        $environment->addRenderer(Image::class, new ImageRenderer(), 100);
        $environment->addRenderer(Embed::class, new EmbedRenderer(), 100);
    }
}
