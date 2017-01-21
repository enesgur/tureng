<?php

namespace enesgur;


class Tureng implements TurengInterface
{

    const URL = 'http://chrome.tureng.com/search/';

    /**
     * @var array
     */
    protected $word = [];

    /**
     * @param array $word
     * @return $this
     */
    public function word($word = array())
    {
        $word = is_string($word) ? [$word] : $word;
        foreach ($word as $row) {
            $this->word[] = trim($row);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function clear()
    {
        $this->word = [];
        return $this;
    }

    /**
     * @return array
     * @throws TurengExceptionsNullWord
     */
    public function translate()
    {
        if (empty($this->word)) {
            throw new TurengExceptionsNullWord();
        }

        $output = $this->_translate($this->word);
        return $output;
    }

    /**
     * @param array $word
     * @return array
     */
    protected function _translate($word)
    {
        $return = [];
        foreach ($word as $row) {
            $translate = $this->_request($row);
            $return[$row] = $this->_parse($translate);
        }

        return $return;
    }

    /**
     * @param string $word
     * @return string
     * @throws TurengExceptionsCurlError
     */
    protected function _request($word)
    {
        $url = self::URL . urlencode($word);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $return = curl_exec($ch);

        if ($return == false) {
            throw new TurengExceptionsCurlError(curl_error($ch), curl_errno($ch));
        }

        curl_close($ch);
        return $return;
    }

    /**
     * @param $content
     * @return array|bool
     */
    protected function _parse($content)
    {
        if (empty($content)) {
            return false;
        }
        $return = [];
        $html = simplexml_load_string($content);

        if ($html == false) {
            return false;
        }

        $generalUsage = 0;
        $generalLi = 0;
        foreach ($html->body->div->children() as $key => $row) {
            if (isset($row->ul) == false || $generalUsage !== 0) {
                continue;
            }

            $ul = $row->ul->attributes();
            if (isset($ul['data-role'])) {
                $generalUsage++;
            }

            foreach ($row->ul->children() as $childLi) {
                $child_li_attr = $childLi->attributes();
                if (isset($child_li_attr['data-role']) && $generalLi !== 0) {
                    break;
                }

                $generalLi++;
                $str = (string)$childLi->a;
                if (empty(trim($str))) {
                    continue;
                }

                $return[] = trim($str);
            }
        }

        return $return;
    }
}