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
namespace DocHeaderTest\Command;

use DocHeader\Command\Checker;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\StreamOutput;

/**
 * Tests for {@see \DocHeader\Command\Checker}.
 *
 * @group   Unitary
 * @author  Jefersson Nathan <malukenho@phpse.net>
 * @license MIT
 *
 * @covers  \DocHeader\Command\Checker
 */
final class CheckerTest extends \PHPUnit_Framework_TestCase
{
    private $expectedDocHeader = <<<'DOCHEADER'
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

    /**
     * @var Checker
     */
    private $checker;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->checker = new Checker('test', $this->expectedDocHeader);
    }


    public function testItShouldNotFailWhenCantFindFilesToValidate()
    {
        $directory      = sys_get_temp_dir() . '/' . microtime(true);
        $outputResource = tmpfile();

        $input  = new StringInput($directory);
        $output = new StreamOutput($outputResource);

        $this->checker->run($input, $output);

        $this->assertFalse(defined('FAILED'));
    }

    public function testItShouldValidateFile()
    {
        $directory      = __DIR__ . '/../../assets/CorrectHeader.php';
        $outputResource = tmpfile();

        $input  = new StringInput($directory);
        $output = new StreamOutput($outputResource);

        $this->checker->run($input, $output);

        $this->assertFalse(defined('FAILED'));
    }

    public function testItShouldFailToValidateMissingHeaderOnFiles()
    {
        $directory      = __DIR__ . '/../../assets/MissingHeader.php';
        $outputResource = tmpfile();

        $input  = new StringInput($directory);
        $output = new StreamOutput($outputResource);

        $this->assertSame(1, $this->checker->run($input, $output));
        $this->assertTrue(defined('FAILED'));
    }
}
