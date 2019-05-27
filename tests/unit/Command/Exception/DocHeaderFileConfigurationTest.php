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
namespace DocHeaderTest\Command\Exception;

use DocHeader\Command\Exception\DocHeaderFileConfiguration;
use PHPUnit\Framework\TestCase;

/**
 * Tests for {@see \DocHeader\Command\Exception\DirectoryException}.
 *
 * @group   Unitary
 * @covers  \DocHeader\Command\Exception\DocHeaderFileConfiguration
 */
final class DocHeaderFileConfigurationTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_throw_exception_for_directory_not_found() : void
    {
        $sut = DocHeaderFileConfiguration::notFound('/tmp');

        $this->assertInstanceOf(DocHeaderFileConfiguration::class, $sut);
        $this->assertSame(
            'Configuration file ".docheader" could not be found on /tmp.',
            $sut->getMessage()
        );

        $this->expectException(DocHeaderFileConfiguration::class);

        throw $sut;
    }
}
