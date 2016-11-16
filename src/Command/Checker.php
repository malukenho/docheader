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
namespace DocHeader\Command;

use DocHeader\Helper\IOResourcePathResolution;
use DocHeader\Validator\RegExp;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class Checker extends Command
{
    /**
     * @var string
     */
    private $header;

    public function __construct($name, $header)
    {
        parent::__construct(null);

        $this->header = $header;
    }

    protected function configure()
    {
        $this
            ->setName('check')
            ->setDescription('Check for docComment')
            ->addArgument(
                'directory',
                InputArgument::IS_ARRAY | InputArgument::REQUIRED,
                'Directory to scan *.php files'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $directory = $input->getArgument('directory');
        $finder    = (new IOResourcePathResolution($directory))->__invoke();
        $validator = new RegExp($this->header);

        /* @var $file \Symfony\Component\Finder\SplFileInfo */
        foreach ($finder as $directory) {
            foreach ($directory as $file) {
                if ($this->docIsNotCompatible($validator, $file->getContents())) {
                    defined('FAILED') ?: define('FAILED', 1);
                    $output->writeln('-> ' . $file->getRelativePathname());
                }
            }
        }

        if (defined('FAILED')) {
            $output->writeln('');
            $output->writeln('<bg=red;fg=white>    Something goes wrong!     </>');

            return 1;
        }

        $output->writeln('<bg=green;fg=white>    Everything is OK!     </>');
    }

    private function docIsNotCompatible($headerValidator, $fileContent)
    {
        return (! $headerValidator->__invoke($fileContent)
                && false === strpos($fileContent, $this->header)
            ) || false === strpos($fileContent, $this->header);
    }
}
