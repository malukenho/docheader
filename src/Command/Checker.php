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

use DocHeader\Filter\Filter;
use DocHeader\Helper\DocheaderFileResolution;
use DocHeader\Helper\IOResourcePathResolution;
use DocHeader\Validator\RegExp;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Jefersson Nathan <malukenho@phpse.net>
 */
final class Checker extends Command
{
    protected function configure()
    {
        $this
            ->setName('check')
            ->setDescription('Check for docComment')
            ->addArgument(
                'directory',
                InputArgument::IS_ARRAY | InputArgument::REQUIRED,
                'Directory to scan *.php files'
            )
            ->addOption(
                'exclude-dir',
                null,
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                'Exclude the specified directory from being scanned; declare multiple directories '
                . 'with multiple invocations of this option.'
            )
            ->addOption(
                'exclude',
                null,
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                'Exclude the specified file from being scanned; declare multiple files with multiple '
                . 'invocations of this option.'
            )
            ->addOption(
                'docheader',
                null,
                InputOption::VALUE_REQUIRED,
                'Specify a docheader template file',
                '.docheader'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $docheaderFile       = $this->getDocheaderFileContent($input);
        $directory           = $input->getArgument('directory');
        $excludedDirectories = $input->getOption('exclude-dir') ?: [];
        $excludedFiles       = $input->getOption('exclude') ?: [];
        $finder              = (new IOResourcePathResolution($directory, $excludedDirectories, $excludedFiles))->__invoke();
        $validator           = new RegExp($docheaderFile);

        $success = true;
        /* @var $file \Symfony\Component\Finder\SplFileInfo */
        foreach ($finder as $dir) {
            foreach ($dir as $file) {
                if (! $this->docIsCompatible($validator, $file->getContents(), $docheaderFile)) {
                    $success = false;
                    $output->writeln('-> ' . $file->getRelativePathname());
                }
            }
        }

        if (! $success) {
            $output->writeln('');
            $output->writeln('<bg=red;fg=white>    Something goes wrong!     </>');

            return 1;
        }

        $output->writeln('<bg=green;fg=white>    Everything is OK!     </>');
    }

    private function docIsCompatible($headerValidator, $fileContent, $docheaderFile)
    {
        return $headerValidator->__invoke($fileContent) || false !== strpos($fileContent, $docheaderFile);
    }

    private function getDocheaderFileContent(InputInterface $input)
    {
        $docheaderFile = $input->getOption('docheader');
        $docheader = (new DocheaderFileResolution())->resolve($docheaderFile);
        $filter = new Filter(file_get_contents($docheader));

        return $filter->apply();
    }
}
