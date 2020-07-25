<?php

namespace App\libs;

use Stichoza\GoogleTranslate\GoogleTranslate;

/**
 * Class for translate text
 *
 * @author Jose Maria Toribio
 */
class Translate
{
    private $trs;
    private $lang;

    /**
     * Translate constructor
     *
     * @param string $lang (englis by default)
     */
    public function __construct(string $lang = 'en')
    {
        $this->lang = $lang;
        $this->trs = new GoogleTranslate($this->lang);
    }

    /**
     * Translates all the values associated with "text" key
     *
     * @param array $arrayToTranslate
     * @return array
     */
    public function translateArray(array $arrayToTranslate): array
    {
        if (empty($arrayToTranslate)) {
            return [];
        }

        array_walk_recursive($arrayToTranslate, function (&$item, $key) {
            if ($key === 'text') {
                $item = $this->trs->translate($item);
            }
        });

        return $arrayToTranslate;
    }

    public function getTranslate()
    {
        return $this->trs;
    }

    public function getLang()
    {
        return $this->lang;
    }

    public function setLang($lang): void
    {
        $this->lang = $lang;
        $this->trs->setTarget($this->lang);
    }
}
