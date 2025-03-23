<?php

namespace Semmelsamu\CommonmarkExtensions\Callout;

use League\CommonMark\Extension\ConfigurableExtensionInterface;
use League\CommonMark\Environment\EnvironmentBuilderInterface;
use League\Config\ConfigurationBuilderInterface;
use Nette\Schema\Expect;

final class CalloutExtension implements ConfigurableExtensionInterface
{
    public function configureSchema(ConfigurationBuilderInterface $builder): void
    {
        $builder->addSchema('callout', Expect::structure([
            'render_icon' => Expect::callable()->default(function (string $callout_type) {
                return $callout_type;
            })
        ]));
    }

    public function register(EnvironmentBuilderInterface $environment): void
    {
        $environment
            ->addBlockStartParser(new CalloutStartParser(), 80)
            ->addRenderer(Callout::class, new CalloutRenderer(
                $environment->getConfiguration()->get('callout.render_icon')
            ));
    }
}
