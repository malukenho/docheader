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
namespace DocHeaderTest\Helper;

use DocHeader\Helper\IOResourcePathResolution;

/**
 * @author  Jefersson Nathan  <malukenho@phpse.net>
 * @license MIT
 */
final class IOResourcePathResolutionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider directories_and_files
     */
    public function it_should_return_a_finder_instance_with_directory_and_files(
        $pathList,
        $fileCount
    ) {
        $resolver = new IOResourcePathResolution($pathList, []);

        $this->assertInstanceOf(IOResourcePathResolution::class, $resolver);

        $result = $resolver->__invoke();

        $this->assertCount($fileCount, $result);
    }

    public function directories_and_files()
    {
        return [
            [
                [__DIR__ . '/../Helper/FileResolveTest.php'],
                1,
            ],
            [
                [
                    __DIR__ . '/../Helper/',
                    __DIR__ . '/../Helper/FileResolveTest.php',
                ],
                2,
            ],
        ];
    }
}
