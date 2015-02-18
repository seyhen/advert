<?php
/**
 * Created by PhpStorm.
 * User: alexandre.an
 * Date: 30/09/2014
 * Time: 14:23
 */

namespace SB\PlatformBundle\Antispam;


class SBAntispam {

    /*
     * Check if a text is spam
     *
     * @param string $text
     * @return bool
     */
    public function isSpam($text)
    {
        return strlen($text) < 50;
    }
} 