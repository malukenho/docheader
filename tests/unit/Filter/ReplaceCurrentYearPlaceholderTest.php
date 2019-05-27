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
namespace DocHeaderTest\Filter;

use DocHeader\Filter\ReplaceCurrentYearPlaceholder;
use DocHeader\Filter\FilterInterface;
use PHPUnit_Framework_TestCase;

/**
 * Tests for {@see \DocHeader\Filter\CurrentYear}.
 *
 * @group   Unitary
 * @author  Jefersson Nathan <malukenho.dev@gmail.com>
 * @license MIT
 *
 * @covers  \DocHeader\Filter\ReplaceCurrentYearPlaceholder
 */
final class ReplaceCurrentYearPlaceholderTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_should_replace_the_year_tag_by_current_year()
    {
        $filter = new ReplaceCurrentYearPlaceholder();
        $docheader = 'Current Year -> %year%';

        $this->assertInstanceOf(FilterInterface::class, $filter);

        $this->assertSame('Current Year -> ' . date('Y'), $filter->__invoke($docheader));
        $this->assertSame(date('Y'), $filter->__invoke('%year%'));
    }
}
