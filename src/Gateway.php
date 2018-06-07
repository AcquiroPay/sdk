<?php

declare(strict_types=1);

namespace AcquiroPay;

use AcquiroPay\Gateway\Responses\InitResponse;
use AcquiroPay\Gateway\Responses\PaymentStatusByCfResponse;
use DOMDocument;
use DOMElement;
use GuzzleHttp\Client as Http;
use Illuminate\Support\Collection;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class Gateway
{
    private const LIVE_URL = 'https://gateway.acquiropay.com';
    private const TEST_URL = 'https://gateway.acqp.co';

    protected $http;
    protected $url;

    protected $merchantId;
    protected $secretWord;

    protected $request;

    public function __construct(
        Http $http,
        int $merchantId = null,
        string $secretWord = null,
        bool $live = false
    )
    {
        $this->http = $http;
    }

    public function setUrl(string $url): Gateway
    {
        $this->url = $url;

        return $this;
    }

    public function setMerchantId(int $merchantId): Gateway
    {
        $this->merchantId = $merchantId;

        return $this;
    }

    public function setSecretWord(string $secretWord): Gateway
    {
        $this->secretWord = $secretWord;

        return $this;
    }

    public function setLive(bool $live): Gateway
    {
        $this->url = $live ? self::LIVE_URL : self::TEST_URL;

        return $this;
    }

    /**
     * Init payment.
     *
     * @param int $productId
     * @param string $pan
     * @param string $cardHolder
     * @param int $expiryMonth
     * @param int $expiryYear
     * @param string $cvv
     * @param string $cf
     * @param float|string $amount
     * @param array $parameters
     *
     * @return InitResponse
     */
    public function init(
        int $productId,
        string $pan,
        string $cardHolder,
        int $expiryMonth,
        int $expiryYear,
        string $cvv,
        string $cf,
        float $amount,
        array $parameters = []
    ): InitResponse
    {
        $amount = $this->formatAmount($amount);

        $parameters = array_merge($parameters, [
            'opcode' => 0,
            'product_id' => $productId,
            'amount' => $amount,
            'cf' => $cf,
            'pan' => $pan,
            'cvv' => $cvv,
            'exp_month' => $expiryMonth,
            'exp_year' => $expiryYear,
            'cardholder' => $cardHolder,
            'token' => md5(
                $this->merchantId .
                $productId .
                $amount .
                $cf .
                array_get($parameters, 'cf2') .
                array_get($parameters, 'cf3') .
                $this->secretWord
            ),
        ]);

        $response = $this->send($parameters);

        return $this->deserialize($response, InitResponse::class);
    }

    /**
     * Get payment status using cf.
     *
     * @param int $productId
     * @param string $cf
     *
     * @return Collection|PaymentStatusByCfResponse[]
     */
    public function paymentStatusByCf(int $productId, string $cf)
    {
        $parameters = [
            'opcode' => 2,
            'product_id' => $productId,
            'cf' => $cf,
            'token' => md5($this->merchantId . $productId . $cf . $this->secretWord),
        ];

        $response = $this->send($parameters);

        $xml = new DOMDocument;
        $xml->formatOutput = true;
        $xml->loadXML($response);

        // один платеж
        if ($xml->getElementsByTagName('payments')->length === 0) {
            return collect([$this->deserialize($response, PaymentStatusByCfResponse::class)]);
        }

        $payments = collect();
        $elements = $xml->getElementsByTagName('payments')->item(0)->getElementsByTagName('payment');

        /** @var DOMElement $element */
        foreach ($elements as $element) {
            $payments->push($this->deserialize($xml->saveXML($element), PaymentStatusByCfResponse::class));
        }

        return $payments;
    }

    public function getRequest(): ?array
    {
        return $this->request;
    }

    private function send(array $parameters): string
    {
        $this->request = $parameters;

        $response = $this->http->post($this->url, ['form_params' => $parameters, 'verify' => false]);

        return (string)$response->getBody();
    }

    private function deserialize(string $data, string $class)
    {
        $normalizers = [new ObjectNormalizer(null, new CamelCaseToSnakeCaseNameConverter)];
        $encoders = [new XmlEncoder];

        return (new Serializer($normalizers, $encoders))->deserialize($data, $class, 'xml');
    }

    private function formatAmount(float $amount): string
    {
        return number_format($amount, 2, '.', '');
    }
}