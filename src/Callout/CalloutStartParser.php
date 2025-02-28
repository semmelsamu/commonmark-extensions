<?php

namespace Semmelsamu\CommonmarkExtensions\Callout;

use League\CommonMark\Parser\Block\BlockStart;
use League\CommonMark\Parser\Block\BlockStartParserInterface;
use League\CommonMark\Parser\Cursor;
use League\CommonMark\Parser\MarkdownParserStateInterface;

class CalloutStartParser implements BlockStartParserInterface
{
    const REGEX_CALLOUT_START = '/\[\!([a-zA-Z]*)\](?:\s+(.*))?$/';

    public function tryStart(Cursor $cursor, MarkdownParserStateInterface $parserState): ?BlockStart
    {
        if ($cursor->isIndented()) {
            return BlockStart::none();
        }

        if ($cursor->getNextNonSpaceCharacter() !== '>') {
            return BlockStart::none();
        }

        $cursor->advanceToNextNonSpaceOrTab();
        $cursor->advanceBy(1);
        $cursor->advanceBySpaceOrTab();

        $calloutStart = $cursor->match(self::REGEX_CALLOUT_START);

        if (is_null($calloutStart)) {
            return BlockStart::none();
        }

        preg_match(self::REGEX_CALLOUT_START, $calloutStart, $matches);

        $cursor->advanceToNextNonSpaceOrTab();

        return BlockStart::of(new CalloutParser(type: $matches[1], title: $matches[2] ?? null))->at($cursor);
    }
}
