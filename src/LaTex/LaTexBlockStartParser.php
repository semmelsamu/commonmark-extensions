<?php

namespace Semmelsamu\CommonmarkExtensions\LaTex;

use League\CommonMark\Parser\Block\BlockStart;
use League\CommonMark\Parser\Block\BlockStartParserInterface;
use League\CommonMark\Parser\Cursor;
use League\CommonMark\Parser\MarkdownParserStateInterface;

class LaTexBlockStartParser implements BlockStartParserInterface
{
    const REGEX_LATEX_START = '/\$\$/';
    const REGEX_LATEX_END = '/\$\$/';
    /**
     * Check whether we should handle the block at the current position
     *
     * @param Cursor                       $cursor
     * @param MarkdownParserStateInterface $parserState
     *
     * @return BlockStart|null
     */
    public function tryStart(Cursor $cursor, MarkdownParserStateInterface $parserState): ?BlockStart
    {
        if ($cursor->getNextNonSpaceCharacter() != "$") {
            return BlockStart::none();
        }

        $cursor->advanceToNextNonSpaceOrTab();

        if (! $cursor->match(self::REGEX_LATEX_START))
            return BlockStart::none();

        // This parser does not handle one line latex blocks
        if ($cursor->match(self::REGEX_LATEX_END)) {
            return BlockStart::none();
        }

        return BlockStart::of(new LaTexBlockParser())->at($cursor);
    }
}
