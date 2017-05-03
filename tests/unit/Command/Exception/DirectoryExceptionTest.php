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
namespace DocHeaderTest\Command\Exception;

use DocHeader\Command\Exception\DirectoryException;
use PHPUnit_Framework_TestCase;

/**
 * Tests for {@see \DocHeader\Command\Exception\DirectoryException}.
 *
 * @group   Unitary
 * @author  Jefersson Nathan <malukenho@phpse.net>
 * @license MIT
 *
 * @covers  \DocHeader\Command\Exception\DirectoryException
 */
final class DirectoryExceptionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_should_throw_exception_for_directory_not_found()
    {
        $sut = DirectoryException::notFound('foo');

        $this->assertInstanceOf(DirectoryException::class, $sut);
        $this->assertSame(
            'Directory "foo" could not be found.',
            $sut->getMessage()
        );

        $this->setExpectedException(DirectoryException::class);

        throw $sut;
    }
}
