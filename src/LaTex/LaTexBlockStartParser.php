<?php

namespace Semmelsamu\CommonmarkExtensions\LaTex;

use League\CommonMark\Parser\Block\BlockStart;
use League\CommonMark\Parser\Block\BlockStartParserInterface;
use League\CommonMark\Parser\Cursor;
use League\CommonMark\Parser\MarkdownParserStateInterface;

class LaTexBlockStartParser implements BlockStartParserInterface
{
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
        if ($cursor->isIndented()) {
            return BlockStart::none();
        }

        $cursor->advanceToNextNonSpaceOrTab();

        if ($cursor->getCharacter(0) !== '$' || $cursor->getCharacter(1) !== '$') {
            return BlockStart::none();
        }

        $cursor->advanceBy(2);

        $state = $cursor->saveState();
        $isOneLine = $cursor->match('/\$\$$/') != null;
        $cursor->restoreState($state);

        return BlockStart::of(new LaTexBlockParser($isOneLine))->at($cursor);
    }
}
