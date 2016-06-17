<?php

namespace PostcodeParser;

interface ResultInterface
{
    /**
     * Returns match pattern.
     *
     * @return string
     */
    public function getPattern();

    /**
     * Returns parser source.
     *
     * @return string
     */
    public function getSource();

    /**
     * Returns result.
     *
     * @param bool|int $partial
     * @return array
     */
    public function getResult($partial = false);

    /**
     * @return bool
     */
    public function isMatch();
}
