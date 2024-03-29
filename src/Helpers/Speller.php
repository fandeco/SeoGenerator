<?php
declare(strict_types=1);

namespace SeoGenerator\Helpers;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

/**
 * Yandex speller api wrapper http://api.yandex.ru/speller/doc/dg/concepts/api-overview.xml
 * @class
 */
class Speller
{
    const API_ENDPOINT = 'http://speller.yandex.net/services/spellservice.json/';

    /**
     * Available API methods
     */
    const METHOD_CHECK_TEXT = 'checkText';
    const METHOD_CHECK_TEXTS = 'checkTexts';

    /**
     * @var Client
     */
    protected $adapter;

    public function __construct()
    {
        $this->setDefaultAdapter();
    }

    /**
     * Check text
     *
     * @param mixed $texts
     * @param array $options
     * @return array
     */
    public function check($texts, $options = array())
    {
        if (is_array($texts)) {
            return $this->checkTexts($texts);
        }

        return $this->checkText($texts, $options);
    }

    /**
     * Check single text
     *
     * @param string $text
     * @param array $options
     * @return array
     */
    public function checkText($text, array $options = array())
    {
        $url = static::API_ENDPOINT . static::METHOD_CHECK_TEXT . '?text=' . $text;
        return $this->getJSON($url);
    }

    /**
     * Check given list of texts
     * @param array $texts
     * @param array $options
     * @return array
     */
    public function checkTexts(array $texts, array $options = array())
    {
        $texts = implode('&text=', $texts);
        $url = static::API_ENDPOINT . static::METHOD_CHECK_TEXTS . '?text=' . $texts;
        return $this->getJSON($url);
    }

    /**
     * @param $url
     * @return string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function getJSON($url)
    {
        $request = $this->adapter->get($url);
        return $request->getBody()->getContents();
    }

    /**
     * Set HTTP adapter
     * @param ClientInterface $adapter instance of http client
     */
    public function setAdapter(ClientInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Set default http adapter Guzzle\Http\Client
     */
    public function setDefaultAdapter()
    {
        $this->setAdapter(new Client());
    }
}
