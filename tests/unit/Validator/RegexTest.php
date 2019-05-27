<?php

declare(strict_types=1);

/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */
namespace DocHeaderTest\Validator;

use DocHeader\Validator\RegExp;
use PHPUnit\Framework\TestCase;
use function sprintf;

/**
 * Tests for {@see \DocHeader\Validator\Regex}.
 *
 * @group   Unitary
 * @covers  \DocHeader\Validator\RegExp
 */
final class RegexTest extends TestCase
{
    /**
     * @test
     * @dataProvider valid_regex_and_content
     */
    public function it_should_assert_given_regex_on_content($regex, $content) : void
    {
        $filter = new RegExp($regex);

        $this->assertTrue(
            $filter->__invoke($content),
            sprintf('"%s" does NOT match on content "%s"', $regex, $content)
        );
    }

    /**
     * @test
     * @dataProvider invalid_regex_and_content
     */
    public function it_should_not_assert_given_regex_on_content($regex, $content) : void
    {
        $filter = new RegExp($regex);

        $this->assertFalse($filter->__invoke($content));
    }

    /**
     * @test
     */
    public function it_should_return_false_if_header_does_not_have_regex_placeholder() : void
    {
        $filter = new RegExp('No regex');

        $this->assertFalse($filter->__invoke('No regex'));
    }

    public function valid_regex_and_content()
    {
        return [
            'Space around content' => ['Heya %regexp:\d{2}%', '             Heya 12            '],
            'Content' => ['Heya %regexp:\d{2}+%', 'If you are reading it? Heya 12, you should buy me sushi.'],
            'Number' => ['Heya %regexp:\d{2}%', 'Heya 12'],
            'Mixed chars' => ['Heya %regexp:\d{2}-\d{1}\w\s+%', 'Heya 12-1a '],
            'Year format' => ['Heya %regexp:20\d{2}%', 'Heya 2020'],
            'Year format 2' => ['Heya 20%regexp:\d{2}%', 'Heya 2020'],
            'Year format 3' => ['Heya %regexp:20\d{2}%-%year%', 'Heya 2020-%year%'],
            'Year format 4' => ['Heya 20%regexp:\d{2}%-%year%', 'Heya 2020-%year%'],
            'Year format 5' => ['Heya 20%regexp:\d\d%-%year%', 'Heya 2020-%year%'],
            'Year format 6' => ['Heya 20%regexp:\\d\\d%-%year%', 'Heya 2020-%year%'],
            'Year format 7' => ['Heya 20%regexp:[0-9][0-9]%-%year%', 'Heya 2020-%year%'],
            'Year format 8' => ['Heya 20%regexp:(\d{2}?)%-%year%', 'Heya 2020-%year%'],
            'Year format 9' => ['Heya 20%regexp:(\d{2})?%-%year%', 'Heya 20-%year%'],
            'Multiple regex' => ['Heya %regexp:20\d{2}%-%year% %regexp:19-\d{1}%', 'Heya 2099-%year% 19-1'],
            'Max Number chars 1' => ['Heya %regexp:\d{1,2}%', 'Heya 2'],
            'Max Number chars 2' => ['Heya %regexp:\d{1,2}%', 'Heya 12'],
        ];
    }

    public function invalid_regex_and_content()
    {
        return [
            'Space around content' => ['Heya %regexp:\d{2}+%', '             Heya 1 23            '],
            'Content' => ['Heya %regexp:\d{2}+%', 'If you are reading it? Heya 1a2, you should buy me sushi.'],
            'No Content' => ['%regexp:\d{2}+%', ''],
        ];
    }
}
