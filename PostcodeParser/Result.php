<?php

namespace PostcodeParser;

class Result implements ResultInterface
{
    protected $pattern;
    protected $source;
    protected $result;
    protected $isMatch = false;

    /**
     * IsMatch setter.
     *
     * @param boolean $isMatch
     * @return Result
     */
    public function setIsMatch($isMatch)
    {
        $this->isMatch = $isMatch;
        return $this;
    }

    /**
     * Pattern setter.
     *
     * @param string $pattern
     * @return Result
     */
    public function setPattern($pattern)
    {
        $this->pattern = $pattern;
        return $this;
    }

    /**
     * Source setter.
     *
     * @param string $source
     * @return Result
     */
    public function setSource($source)
    {
        $this->source = $source;
        return $this;
    }

    /**
     * Result setter.
     *
     * @param array $matches
     * @return Result
     */
    public function setResult(array $matches)
    {
        $this->result = $matches;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getPattern()
    {
        return $this->pattern;
    }

    /**
     * @inheritdoc
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @inheritdoc
     */
    public function getResult($partial = false)
    {
        if (!$partial) {
            return $this->result;
        }

        if (array_key_exists($partial, $this->result)) {
            return $this->result[$partial];
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function isMatch()
    {
        return $this->isMatch;
    }
}
