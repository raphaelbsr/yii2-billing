<?php

namespace raphaelbsr\billing;

use raphaelbsr\billing\exceptions\OrderRequestException;
use raphaelbsr\billing\models\CardBin;
use raphaelbsr\billing\models\CieloError;
use raphaelbsr\billing\models\CreditCard;
use raphaelbsr\billing\models\OrderRequest;
use raphaelbsr\billing\models\OrderResponse;
use RuntimeException;
use yii\httpclient\Client;
use yii\httpclient\Response;

/**
 * Description of Cielo
 *
 * @author rapha
 */
class Cielo extends Billing {

    public static $API_URL_KEY = 0;
    public static $API_QUERY_URL_KEY = 1;
    private static $API_VERSION = 1;

    const ENV_SANDBOX = [
        0 => 'https://apisandbox.cieloecommerce.cielo.com.br',
        1 => 'https://apiquerysandbox.cieloecommerce.cielo.com.br'
    ];
    const ENV_PROD = [
        0 => 'https://api.cieloecommerce.cielo.com.br',
        1 => 'https://apiquery.cieloecommerce.cielo.com.br'
    ];

    public $merchantId;
    public $merchantKey;

    private function getApiUrl() {
        switch ($this->enviroment) {
            case Billing::ENV_PROD:
                return self::ENV_PROD[self::$API_URL_KEY];
            case Billing::ENV_SANDBOX:
                return self::ENV_SANDBOX[self::$API_URL_KEY];
                return;
        }
    }

    private function getApiQueryUrl() {
        switch ($this->enviroment) {
            case Billing::ENV_PROD:
                return self::ENV_PROD[self::$API_QUERY_URL_KEY];
            case Billing::ENV_SANDBOX:
                return self::ENV_SANDBOX[self::$API_QUERY_URL_KEY];
                return;
        }
    }

    /**
     * @link https://developercielo.github.io/manual/cielo-ecommerce#transa%C3%A7%C3%A3o-simples
     * @param OrderRequest $orderRequest
     * @return string|OrderResponse
     * @throws RuntimeException
     * @throws OrderRequestException
     */
    public function postOrderRequest(OrderRequest $orderRequest) {

        $url = $this->getApiUrl() . '/' . self::$API_VERSION . '/sales';
        $client = new Client();
        $response = $client->createRequest()
                ->setMethod('POST')
                ->addHeaders(['MerchantId' => $this->merchantId])
                ->addHeaders(['MerchantKey' => $this->merchantKey])
                ->addHeaders(['content-type' => 'application/json'])
                ->setUrl($url)
                ->setContent(json_encode($orderRequest->getAttributes()))
                ->setFormat(Client::FORMAT_JSON)
                ->send();

        return new OrderResponse(json_decode($this->readResponse($response), true));
    }

    /**
     * @link https://developercielo.github.io/manual/cielo-ecommerce#consulta-paymentid
     * @param string $paymentId
     * @return string|OrderResponse
     * @throws RuntimeException
     * @throws OrderRequestException
     */
    public function queryOrderRequest($paymentId) {

        $url = $this->getApiQueryUrl() . '/' . self::$API_VERSION . '/sales/' . $paymentId;

        $client = new Client();
        $response = $client->createRequest()
                ->setMethod('GET')
                ->addHeaders(['MerchantId' => $this->merchantId])
                ->addHeaders(['MerchantKey' => $this->merchantKey])
                ->addHeaders(['content-type' => 'application/json'])
                ->setUrl($url)
                ->setFormat(Client::FORMAT_JSON)
                ->send();

        return new OrderResponse($this->readResponse($response));
    }

    /**
     * @link https://developercielo.github.io/manual/cielo-ecommerce#consulta-merchandorderid
     * @param string $merchandOrderId
     * @return mixed
     * @throws RuntimeException
     * @throws OrderRequestException
     */
    public function queryORByMerchantOrderId($merchandOrderId) {

        $url = $this->getApiQueryUrl() . '/' . self::$API_VERSION . '/sales?merchantOrderId=' . $merchandOrderId;
        $client = new Client();
        $response = $client->createRequest()
                ->setMethod('GET')
                ->addHeaders(['MerchantId' => $this->merchantId])
                ->addHeaders(['MerchantKey' => $this->merchantKey])
                ->addHeaders(['content-type' => 'application/json'])
                ->setUrl($url)
                ->setFormat(Client::FORMAT_JSON)
                ->send();

        return $this->readResponse($response);
    }

    /**
     * @link https://developercielo.github.io/manual/cielo-ecommerce#cancelamento-total
     * @param type $paymentId
     * @return string
     * @throws RuntimeException
     * @throws OrderRequestException
     */
    public function cancelOrderByPaymentId($paymentId) {
        $url = $this->getApiUrl() . '/' . self::$API_VERSION . '/sales/' . $paymentId . '/void';
        $client = new Client();
        $response = $client->createRequest()
                ->setMethod('PUT')
                ->addHeaders(['MerchantId' => $this->merchantId])
                ->addHeaders(['MerchantKey' => $this->merchantKey])
                ->addHeaders(['content-type' => 'application/json'])
                ->addHeaders(['Content-Length' => 0])
                ->setUrl($url)
                ->setFormat(Client::FORMAT_JSON)
                ->send();

        return $this->readResponse($response);
    }

    /**
     * @link https://developercielo.github.io/manual/cielo-ecommerce#cancelamento-total
     * @param type $merchantOrderId
     * @return string
     * @throws RuntimeException
     * @throws OrderRequestException
     */
    public function cancelOrderByMerchantOrderId($merchantOrderId) {
        $url = $this->getApiUrl() . '/' . self::$API_VERSION . '/sales/OrderId/' . $merchantOrderId . '/void';
        $client = new Client();
        $response = $client->createRequest()
                ->setMethod('PUT')
                ->addHeaders(['MerchantId' => $this->merchantId])
                ->addHeaders(['MerchantKey' => $this->merchantKey])
                ->addHeaders(['content-type' => 'application/json'])
                ->addHeaders(['Content-Length' => 0])
                ->setUrl($url)
                ->setFormat(Client::FORMAT_JSON)
                ->send();

        return $this->readResponse($response);
    }

    /**
     * @link https://developercielo.github.io/manual/cielo-ecommerce#criando-um-cart%C3%A3o-tokenizado
     * @param CreditCard $creditCard
     * @return string
     * @throws RuntimeException
     * @throws OrderRequestException
     */
    public function tokenizeCreditCard(CreditCard $creditCard) {

        $url = $this->getApiUrl() . '/' . self::$API_VERSION . '/card';
        $client = new Client();
        $response = $client->createRequest()
                ->setMethod('POST')
                ->addHeaders(['MerchantId' => $this->merchantId])
                ->addHeaders(['MerchantKey' => $this->merchantKey])
                ->addHeaders(['content-type' => 'application/json'])
                ->setContent(json_encode($creditCard->getAttributes()))
                ->setUrl($url)
                ->setFormat(Client::FORMAT_JSON)
                ->send();
        return $this->readResponse($response);
    }

    /**
     * @link https://developercielo.github.io/manual/cielo-ecommerce#consulta-bin
     * @param string bin
     * @return mixed
     * @throws RuntimeException
     * @throws OrderRequestException
     */
    public function cardBin($bin) {

        $url = $this->getApiQueryUrl() . '/' . self::$API_VERSION . '/cardBin/' . $bin;
        $client = new Client();
        $response = $client->createRequest()
                ->setMethod('GET')
                ->addHeaders(['MerchantId' => $this->merchantId])
                ->addHeaders(['MerchantKey' => $this->merchantKey])
                ->addHeaders(['content-type' => 'application/json'])
                ->setUrl($url)
                ->setFormat(Client::FORMAT_JSON)
                ->send();
        return new CardBin(json_decode($this->readResponse($response), true));
    }

    protected function readResponse(Response $response) {

        $statusCode = $response->getStatusCode();
        switch ($statusCode) {
            case 200:
            case 201:
                return $response->getContent();
            case 400:
                $exception = null;
                $responses = json_decode($response->getContent());
                foreach ($responses as $error) {
                    $cieloError = new CieloError($error->Message, $error->Code);
                    $exception = new OrderRequestException('Request Error ' . $response->getContent(), $statusCode, $exception);
                    $exception->setCieloError($cieloError);
                }
                throw $exception;
            case 404:
                throw new RuntimeException('Resource not found', 404, null);
            default:
                throw new RuntimeException('Unknown status ' . $response->getContent(), $statusCode);
        }
    }

}
