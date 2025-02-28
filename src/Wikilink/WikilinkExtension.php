<?php

declare(strict_types=1);

namespace App\MarkdownExtensions\Wikilink;

use League\CommonMark\Environment\EnvironmentBuilderInterface;
use League\CommonMark\Extension\ConfigurableExtensionInterface;
use League\Config\ConfigurationBuilderInterface;
use Nette\Schema\Expect;

class WikilinkExtension implements ConfigurableExtensionInterface
{
    public function configureSchema(ConfigurationBuilderInterface $builder): void
    {
        $builder->addSchema('resolve_wikilink', Expect::callable(function (string $wikilink) {
            return $wikilink;
        }));
    }

    public function register(EnvironmentBuilderInterface $environment): void
    {
        $environment->addInlineParser(new WikilinkParser(
            $environment->getConfiguration()->get('resolve_wikilink')
        ), 50);
    }
}
