<?php

namespace Tests\Highlight\Patterns\Html;

use App\Highlight\Patterns\Html\OpenTagPattern;
use App\Highlight\Patterns\Php\AttributeTypePattern;
use PHPUnit\Framework\TestCase;
use Tests\Highlight\Patterns\TestsTokenPatterns;

class OpenTagPatternTest extends TestCase
{
    use TestsTokenPatterns;

    public function test_pattern()
    {
        $this->assertMatches(
            pattern: new OpenTagPattern(),
            content: htmlentities('<x-hello attr="">'),
            expected: 'x-hello',
        );

        $this->assertMatches(
            pattern: new OpenTagPattern(),
            content: htmlentities('<a href="">'),
            expected: 'a',
        );

        $this->assertMatches(
            pattern: new OpenTagPattern(),
            content: htmlentities('<br/>'),
            expected: 'br',
        );
    }
}
