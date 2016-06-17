<?php

namespace PostcodeParser;

/**
 * Postcode Parser.
 * CAUTION! May be slow. :)
 *
 * @package app\components
 */
class Parser
{
    /** @var array Postcode patterns */
    public static $patterns = [
        // Great Britain Postcodes
        'AA9A 9AA', 'A9A 9AA', 'A9 9AA',
        'A99 9AA', 'AA9 9AA', 'AA99 9AA',
    ];

    protected $strict = false;
    protected $source;

    /**
     * Strict mode setter.
     *
     * @param boolean $strict
     * @return $this
     */
    public function setStrict($strict)
    {
        $this->strict = $strict;
        return $this;
    }

    /**
     * Source setter.
     *
     * @param string $source
     * @return $this
     */
    public function setSource($source)
    {
        $this->source = $source;
        return $this;
    }

    /**
     * Source getter.
     *
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Creates Regex pattern from simple pattern.
     *
     * @param $pattern
     * @return string
     */
    protected function createPattern($pattern)
    {
        $pattern = preg_replace('/A/', '[A-Z]', $pattern);
        $pattern = preg_replace('/9/', '[0-9]', $pattern);
        $pattern = explode(' ', $pattern);
        $pattern = '(' . $pattern[0] . ') (' . $pattern[1] . '){0,1}';

        $prefix = null;
        $postfix = null;

        if ($this->strict) {
            $prefix = '^';
            $postfix = '$';
        }

        $pattern = '/' . $prefix . $pattern . $postfix . '/';
        return $pattern;
    }

    /**
     * Matches $postcode with $pattern.
     *
     * @param string $postcode
     * @param string $pattern
     * @return ResultInterface
     */
    public function process($postcode, $pattern)
    {
        $result = new Result();
        $result->setSource($postcode);

        $pattern = $this->createPattern($pattern);
        if (preg_match($pattern, $postcode, $matches)) {
            $result->setPattern($pattern)
                ->setResult($matches)
                ->setIsMatch(true);
        }

        return $result;
    }

    /**
     * Method tries to parse postcode with defined parsers.
     *
     * @param string $postcode
     * @param boolean $strict Strict mode
     * @return ResultInterface|false
     */
    public static function parse($postcode, $strict = false)
    {
        $parser = new self;
        $parser->setSource($postcode)
            ->setStrict($strict);

        foreach (self::$patterns as $key => $pattern) {
            $result = $parser->process($postcode, $pattern);

            if ($result->isMatch()) {
                return $result;
            }
        }

        return false;
    }
}
