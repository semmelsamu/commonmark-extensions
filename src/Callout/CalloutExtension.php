<?php

namespace Semmelsamu\CommonmarkExtensions\Callout;

use League\CommonMark\Extension\ExtensionInterface;
use League\CommonMark\Environment\EnvironmentBuilderInterface;
use League\Config\ConfigurationBuilderInterface;
use Nette\Schema\Expect;

final class CalloutExtension implements ExtensionInterface
{
    public function configureSchema(ConfigurationBuilderInterface $builder): void
    {
        $builder->addSchema('render_icon', Expect::callable(function (string $callout_type) {
            return $callout_type;
        }));
    }

    public function register(EnvironmentBuilderInterface $environment): void
    {
        $environment
            ->addBlockStartParser(new CalloutStartParser(), 80)
            ->addRenderer(Callout::class, new CalloutRenderer(
                $environment->getConfiguration()->get('render_icon')
            ));
    }
}
