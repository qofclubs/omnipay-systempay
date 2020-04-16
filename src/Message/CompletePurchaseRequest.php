<?php

namespace Omnipay\SystemPay\Message;

use Omnipay\Common\Exception\InvalidResponseException;

/**
 * SystemPay Complete Purchase Request
 */
class CompletePurchaseRequest extends AbstractRequest
{

    public $liveEndpoint = 'https://paiement.systempay.fr/vads-payment/';


    public function getData()
    {
        $signature = $this->generateSignature($this->httpRequest->request->all());
        if (strtolower($this->httpRequest->request->get('signature')) !== $signature) {
            throw new InvalidResponseException('Invalid signature');
        }

        return $this->httpRequest->request->all();
    }

    public function sendData($data)
    {
        return $this->response = new CompletePurchaseResponse($this, $data);
    }

    public function getEndpoint()
    {
        $this->liveEndpoint;
    }
}
