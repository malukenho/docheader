<?php
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

use DocHeader\Validator\Regex;

/**
 * Tests for {@see \DocHeader\Validator\Regex}.
 *
 * @group   Unitary
 * @author  Jefersson Nathan <malukenho@phpse.net>
 * @license MIT
 *
 * @covers  \DocHeader\Validator\Regex
 */
final class RegexTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider valid_regex_and_content
     */
    public function it_should_assert_given_regex_on_content($regex, $content)
    {
        $filter = new Regex($regex);

        $this->assertTrue(
            $filter->__invoke($content),
            sprintf('"%s" does NOT match on content "%s"', $regex, $content)
        );
    }

    /**
     * @test
     * @dataProvider invalid_regex_and_content
     */
    public function it_should_not_assert_given_regex_on_content($regex, $content)
    {
        $filter = new Regex($regex);

        $this->assertFalse($filter->__invoke($content));
    }

    public function valid_regex_and_content()
    {
        return [
            'Space around content' => ['Heya %re:\d{2}%', '             Heya 12            '],
            'Content' => ['Heya %re:\d{2}+%', 'If you are reading it? Heya 12, you should buy me sushi.'],
            'Number' => ['Heya %re:\d{2}%', 'Heya 12'],
            'Mixed chars' => ['Heya %re:\d{2}-\d{1}\w\s+%', 'Heya 12-1a '],
            'Year format' => ['Heya %re:20\d{2}%', 'Heya 2020'],
            'Year format 2' => ['Heya 20%re:\d{2}%', 'Heya 2020'],
            'Year format 3' => ['Heya %re:20\d{2}%-%year%', 'Heya 2020-%year%'],
            'Multiple regex' => ['Heya %re:20\d{2}%-%year% %re:19-\d{1}%', 'Heya 2099-%year% 19-1'],
            'Max Number chars 1' => ['Heya %re:\d{1,2}%', 'Heya 2'],
            'Max Number chars 2' => ['Heya %re:\d{1,2}%', 'Heya 12'],
        ];
    }

    public function invalid_regex_and_content()
    {
        return [
            'Space around content' => ['Heya %re:\d{2}+%', '             Heya 1 23            '],
            'Content' => ['Heya %re:\d{2}+%', 'If you are reading it? Heya 1a2, you should buy me sushi.'],
            'No Content' => ['%re:\d{2}+%', ''],
        ];
    }
}
