<?php

declare(strict_types=1);

namespace App\MarkdownExtensions\WikilinkEmbed;

use League\CommonMark\Parser\Block\BlockStart;
use League\CommonMark\Parser\Block\BlockStartParserInterface;
use League\CommonMark\Parser\Cursor;
use League\CommonMark\Parser\MarkdownParserStateInterface;

class WikilinkEmbedStartParser implements BlockStartParserInterface
{
    private $resolveWikilink;

    public function __construct(callable $resolveWikilink)
    {
        $this->resolveWikilink = $resolveWikilink;
    }

    public function tryStart(Cursor $cursor, MarkdownParserStateInterface $parserState): ?BlockStart
    {
        if ($cursor->isIndented() || $cursor->getNextNonSpaceCharacter() != '!')
            return null;

        $regex = '/!\[\[([^\]\|]+)(?:\|([^\]]+))?\]\]/';

        if (!preg_match($regex, $cursor->getLine(), $matches))
            return null;

        $filename = ($this->resolveWikilink)($matches[1]);
        $caption = $matches[2] ?? null;

        $cursor->advanceBy(strlen($matches[0]));

        return BlockStart::of(new WikilinkEmbedParser($filename, $caption))
            ->at($cursor);
    }
}
