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

namespace DocHeader\Validator;

/**
 * @author  Jefersson Nathan <malukenho@phpse.net>
 * @license MIT
 */
final class RegExp
{
    const TAG_BEGIN = '%regexp:';
    const TAG_END   = '%';

    /**
     * @var string
     */
    private $pattern;

    /**
     * @param string $pattern
     */
    public function __construct($pattern)
    {
        $this->pattern = $pattern;
    }

    /**
     * {@inheritDoc}
     */
    public function __invoke($docheader)
    {
        $didMatch = preg_match_all(
            '{' . preg_quote(self::TAG_BEGIN) . '(.+?)' . preg_quote(self::TAG_END) . '}',
            $this->pattern,
            $matches
        );

        if (! $didMatch) {
            // In case of not have any regexp to match
            // just return true
            return true;
        }

        $matchable = $this->pattern;

        /* @var $matches array[] */
        foreach ($matches[0] as $k => $match) {
            $matchable = str_replace($match, sha1($match . $k), $matchable);
        }

        $protected = preg_quote($matchable);

        /* @var $matches array[] */
        foreach ($matches[1] as $k => $match) {
            $protected = str_replace(preg_quote(sha1($matches[0][$k] . $k)), $match, $protected);
        }

        return (bool) preg_match('#' . $protected . '#', $docheader);
    }
}
