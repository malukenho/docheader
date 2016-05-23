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
namespace DocHeader\Helper;

use Symfony\Component\Finder\Finder;

/**
 * @author Jefersson Nathan  <malukenho@phpse.net>
 * @license MIT
 */
final class FileResolve
{
    /**
     * @var string
     */
    private $directoryOrFile;

    /**
     * @param string $directoryOrFile
     */
    public function __construct($directoryOrFile)
    {
        $this->directoryOrFile = $directoryOrFile;
    }

    private function getDirectory()
    {
        return is_dir($this->directoryOrFile) ? $this->directoryOrFile : dirname($this->directoryOrFile);
    }

    private function getFeatureMatch()
    {
        return is_dir($this->directoryOrFile) ? '*.php' : basename($this->directoryOrFile);
    }

    public function __invoke()
    {
        return Finder::create()
            ->files()
            ->in($this->getDirectory())
            ->name($this->getFeatureMatch());
    }
}
