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
namespace DocHeader\Helper;

use InvalidArgumentException;
use Symfony\Component\Finder\Finder;
use function array_map;
use function basename;
use function dirname;
use function is_dir;
use function rtrim;

final class IOResourcePathResolution
{
    /** @var string[] */
    private $directoryOrFile;

    /** @var string[] */
    private $excludedDirectory;

    /** @var string[] */
    private $excludedFiles;

    /**
     * @param string[] $directoryOrFile
     * @param string[] $excludedDirectory
     * @param string[] $excludedFiles
     */
    public function __construct(array $directoryOrFile, array $excludedDirectory, array $excludedFiles)
    {
        $this->directoryOrFile   = $directoryOrFile;
        $this->excludedDirectory = $excludedDirectory;
        $this->excludedFiles     = $excludedFiles;
    }

    private function getDirectory(string $directoryOrFile) : string
    {
        return is_dir($directoryOrFile) ? $directoryOrFile : dirname($directoryOrFile);
    }

    private function getFeatureMatch(string $directoryOrFile) : string
    {
        return is_dir($directoryOrFile) ? '*.php' : basename($directoryOrFile);
    }

    /**
     * @return Finder[]
     *
     * @throws InvalidArgumentException
     */
    public function __invoke() : array
    {
        return array_map(
            /**
             * @param string $directoryOrFile
             *
             * @return Finder
             */
            function ($directoryOrFile) {
                $finder = Finder::create()
                    ->files()
                    ->ignoreDotFiles(true)
                    ->in(rtrim($this->getDirectory($directoryOrFile), '/'))
                    ->name($this->getFeatureMatch($directoryOrFile))
                    ->exclude($this->excludedDirectory)
                    ->sortByName();

                foreach ($this->excludedFiles as $pattern) {
                    $finder->notPath($pattern);
                }

                return $finder;
            },
            $this->directoryOrFile
        );
    }
}
