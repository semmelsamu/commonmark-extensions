<?php

declare(strict_types=1);

namespace Semmelsamu\CommonmarkExtensions\Wikilink;

use League\CommonMark\Extension\CommonMark\Node\Inline\Link;
use League\CommonMark\Parser\Inline\InlineParserInterface;
use League\CommonMark\Parser\Inline\InlineParserMatch;
use League\CommonMark\Parser\InlineParserContext;

class WikilinkParser implements InlineParserInterface
{
    private $resolveWikilink;

    public function __construct(callable $resolveWikilink)
    {
        $this->resolveWikilink = $resolveWikilink;
    }

    public function getMatchDefinition(): InlineParserMatch
    {
        return InlineParserMatch::regex('\[\[([^\]\|]+)(?:\|([^\]]+))?\]\]');
    }

    public function parse(InlineParserContext $inlineContext): bool
    {
        $filename = $inlineContext->getSubMatches()[0];
        $caption = $inlineContext->getSubMatches()[1] ?? null;

        $source = ($this->resolveWikilink)($filename);

        $inlineContext->getContainer()->appendChild(new Link($source, $caption ?? $filename));

        $inlineContext->getCursor()->advanceBy(strlen($inlineContext->getMatches()[0]));

        return true;
    }
}
