<?php

/**
 * This service change a number to base 64 with radom char
 *
 * @author Gérald Chablowski
 */

namespace UrlShortenerBundle\Services;

class Base62Service {

    private $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHUJKLMNOPQRSTUVWXYZ';

    /**
     * Change a number in base64 with a radom chars
     *
     * @param int $n
     * @return string
     */
    public function num_to_base62($n) {
        if ($n > 62) {
            return $this->num_to_base62(floor($n / 62)) . $this->chars[$n % 62];
        } else {
            return $short = $this->chars[$n];
        }
    }

}
