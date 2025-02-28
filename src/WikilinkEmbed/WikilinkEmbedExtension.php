<?php

declare(strict_types=1);

namespace App\MarkdownExtensions\WikilinkEmbed;

use App\MarkdownExtensions\WikilinkEmbed\Embed\Embed;
use App\MarkdownExtensions\WikilinkEmbed\Embed\EmbedRenderer;
use League\CommonMark\Environment\EnvironmentBuilderInterface;
use League\CommonMark\Extension\ConfigurableExtensionInterface;
use League\Config\ConfigurationBuilderInterface;
use Nette\Schema\Expect;
use App\MarkdownExtensions\WikilinkEmbed\Embed\Image;
use App\MarkdownExtensions\WikilinkEmbed\Embed\ImageRenderer;

final class WikilinkEmbedExtension implements ConfigurableExtensionInterface
{
    public function configureSchema(ConfigurationBuilderInterface $builder): void
    {
        $builder->addSchema('resolve_wikilink', Expect::callable(function (string $wikilink) {
            return $wikilink;
        }));
    }

    public function register(EnvironmentBuilderInterface $environment): void
    {
        $environment->addBlockStartParser(new WikilinkEmbedStartParser(
            $environment->getConfiguration()->get('resolve_wikilink')
        ), 100);

        $environment->addRenderer(Image::class, new ImageRenderer(), 100);
        $environment->addRenderer(Embed::class, new EmbedRenderer(), 100);
    }
}
