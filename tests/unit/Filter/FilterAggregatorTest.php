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
namespace DocHeaderTest\Filter;

use DocHeader\Filter\FilterAggregator;
use PHPUnit\Framework\TestCase;
use function date;

/**
 * Tests for {@see \DocHeader\Filter\FilterAggregator}.
 *
 * @group   Unitary
 * @covers  \DocHeader\Filter\FilterAggregator
 */
final class FilterAggregatorTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_have_replace_current_year_placeholder_as_default_filter() : void
    {
        $this->assertClassHasAttribute('dockBlockDefaultFilters', FilterAggregator::class);
    }

    /**
     * @test
     */
    public function it_should_apply_default_filters_to_given_docheader() : void
    {
        $docBlock = 'Year %year%';
        $filter   = new FilterAggregator($docBlock);

        $this->assertSame('Year ' . date('Y'), $filter->apply());
    }
}
