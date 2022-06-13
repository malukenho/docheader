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

namespace DocHeaderTest\Command;

use DocHeader\Command\Checker;
use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\StreamOutput;

use function tmpfile;

/**
 * Tests for {@see \DocHeader\Command\Checker}.
 *
 * @group   Unitary
 * @covers  \DocHeader\Command\Checker
 */
final class CheckerTest extends TestCase
{
    private string $expectedDocHeader = <<<'DOCHEADER'
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
DOCHEADER;

    private Checker $checker;

    protected function setUp(): void
    {
        $this->checker = new Checker('test');
    }

    /**
     * @test
     */
    public function it_should_not_fail_when_cant_find_files_to_validate(): void
    {
        $fileSystem = vfsStream::setup();

        $outputResource = tmpfile();
        $directory      = $fileSystem->path();

        $input  = new StringInput($directory);
        $output = new StreamOutput($outputResource);

        $this->assertSame(0, $this->checker->run($input, $output));
    }

    /**
     * @test
     */
    public function it_should_validate_file(): void
    {
        $directory      = __DIR__ . '/../../assets/CorrectHeader.php';
        $outputResource = tmpfile();

        $input  = new StringInput($directory);
        $output = new StreamOutput($outputResource);

        $this->assertSame(0, $this->checker->run($input, $output));
    }

    public function testItShouldFailToValidateMissingHeaderOnFiles(): void
    {
        $directory      = __DIR__ . '/../../assets/MissingHeader.php';
        $outputResource = tmpfile();

        $input  = new StringInput($directory);
        $output = new StreamOutput($outputResource);

        $this->assertSame(1, $this->checker->run($input, $output));
    }
}
