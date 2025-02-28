<?php

namespace Semmelsamu\CommonmarkExtensions\Callout;

use League\CommonMark\Node\Block\AbstractBlock;

class Callout extends AbstractBlock
{
    public function __construct(public readonly string $type, public readonly ?string $title = null) {}

    public function getIcon(): string
    {
        return match (strtolower($this->type)) {
            'note' => 'lucide-pencil',
            'definition' => 'lucide-book-open',
            'tip' => 'lucide-lightbulb',
            'important' => 'lucide-message-square-warning',
            'warning' => 'lucide-triangle-alert',
            'example' => 'lucide-list',
            default => 'lucide-info',
        };
    }
}
