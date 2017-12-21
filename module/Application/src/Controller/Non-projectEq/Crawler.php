<?php

namespace Application\Service;

use Application\Service\Exception\CrawlerException;
use Zend\Http\Client;
use Zend\Http\Header\Cookie;
use Zend\Http\Request;
use Zend\Uri\UriFactory;
use Zend\Stdlib\Parameters;
use Zend\Dom\Query;

class SiteCrawler
{
    const OK = 200;
    const MOVED_PERMANENTLY = 301;
    const FOUND = 302;
    const NOT_FOUND = 404;
    const UNAUTHORIZED = 401;
    const INTERNAL_SERVER_ERROR = 500;

    const STEP = 100;

    /**
     * @var Parameters
     */
    protected $parameters;

    public function __construct(array $configuration)
    {
        // parametry logowania do panelu domena.pl
        $parameters = new Parameters();
        $parameters->set('login', $configuration['login'])
            ->set('password', $configuration['password']);

        $this->parameters = $parameters;
    }

    public function checkStatus(string $url, array $status):bool
    {
        $uri = UriFactory::factory('http://' . $url . '/');

        try {
            $request = new Request();
            $request->setUri($uri);

            $client = new Client();
            $response = $client->send($request);

            if (in_array($response->getStatusCode(), $status)) {
                return true;
            }
        } catch(\RuntimeException $e) {
            return false;
        }

        return false;
    }

    public function fetchDomains():array
    {
        $authCookie = $this->authorization();

        $domainsUrl = 'https://domeny.domena.pl?action=customer&subaction=ccustomerdata&show=domains&limit_nr=' . self::STEP . '&limit_from=<page>';
        $domains = [];
        $offset = 0;
        $flag = true;

        while ($flag) {
            $uri = UriFactory::factory(str_replace('<page>', $offset, $domainsUrl));

            $request = new Request();
            $request->setUri($uri->toString())
                ->setMethod('GET');

            $request->getHeaders()->addHeader($authCookie);

            try {
                $client = new Client();
                $response = $client->send($request);
            } catch (\RuntimeException $e) {
                throw CrawlerException::forConnectionFails();
            }

            $dom = new Query($response->getBody());
            $results = $dom->execute('tr[onmouseover*="addClassName"] > td');

            if (!$results->count()) {
                throw CrawlerException::forImportFails();
            }

            for ($i = 0; $i < count($results); $i += 7) {
                if ((int)$results[$i]->textContent < $offset) {
                    $flag = false;
                } else {
                    $dateFrom = \DateTime::createFromFormat("Y-m-d H:i:s", trim($results[$i + 3]->textContent));
                    $dateTo = \DateTime::createFromFormat("Y-m-d H:i:s", trim($results[$i + 4]->textContent));

                    if (!($dateFrom && $dateTo)) {
                        throw CrawlerException::forIncorrectData();    // pobrane daty nie zgadzają się z przyjętym formatem
                    }

                    $url = trim($results[$i + 2]->textContent);

                    if(preg_match('/^[\w\.-]+$/', $url)) {
                        $domains[] = [
                            'domain_url' => $url,
                            'period_date_from' => $dateFrom,
                            'period_date_to' => $dateTo
                        ];
                    }
                }
            }

            $offset += self::STEP;
        }

        return $domains;
    }

    private function authorization():Cookie {
        $requestAuth = new Request();
        $requestAuth->setUri('https://domeny.domena.pl/?action=nologged&subaction=nclogincustomer&follow=ccustomerdata')
            ->setMethod('POST')
            ->setPost($this->parameters);

        try {
            $client = new Client();
            $responseAuth = $client->send($requestAuth);
        } catch (\RuntimeException $e) {
            throw CrawlerException::forConnectionFails();
        }

        if(isset($responseAuth->getCookie()[1])) {
            return new Cookie([
                $responseAuth->getCookie()[1]->getName() => $responseAuth->getCookie()[1]->getValue(),
            ]);
        } else {
            throw CrawlerException::forAuthInvalid();
        }
    }
}