<?php

namespace Omnipay\SystemPay\Message;

use Omnipay\Common\Message\AbstractRequest as OmnipayAbstractRequest;
use Omnipay\Common\Message\ResponseInterface;

/**
 * SystemPay Abstract Request
 */
abstract class AbstractRequest extends OmnipayAbstractRequest
{

    public function sendData($data)
    {
        $response = $this->httpClient->request('POST', $this->getEndPoint(), [], http_build_query($data));
        $responseData = simplexml_load_string($response->getBody()->getContents());

        return $this->createResponse($responseData);
    }

    abstract public function getEndpoint();

    /**
     * @return mixed
     */
    public function getMerchantId()
    {
        return $this->getParameter('merchantId');
    }

    /**
     * @param $value
     * @return AbstractRequest
     */
    public function setMerchantId($value)
    {
        return $this->setParameter('merchantId', $value);
    }


    /**
     * @return mixed
     */
    public function getTransactionDate()
    {
        return $this->getParameter('transactionDate');
    }

    /**
     * @param $value
     * @return AbstractRequest
     */
    public function setTransactionDate($value)
    {
        return $this->setParameter('transactionDate', $value);
    }

    /**
     * @return mixed
     */
    public function getCertificate()
    {
        return $this->getParameter('certificate');
    }

    /**
     * @param $value
     * @return AbstractRequest
     */
    public function setCertificate($value)
    {
        return $this->setParameter('certificate', $value);
    }

    /**
     * @param $value
     * @return AbstractRequest
     */
    public function setSuccessUrl($value)
    {
        return $this->setParameter('successUrl', $value);
    }

    /**
     * @return mixed
     */
    public function getSuccessUrl()
    {
        return $this->getParameter('successUrl');
    }

    /**
     * @param string $value
     * @return AbstractRequest
     */
    public function setCancelUrl($value)
    {
        return $this->setParameter('cancelUrl', $value);
    }

    /**
     * @return mixed|string
     */
    public function getCancelUrl()
    {
        return $this->getParameter('cancelUrl');
    }

    /**
     * @param $value
     * @return AbstractRequest
     */
    public function setErrorUrl($value)
    {
        return $this->setParameter('errorUrl', $value);
    }

    /**
     * @return mixed
     */
    public function getErrorUrl()
    {
        return $this->getParameter('errorUrl');
    }

    /**
     * @param $value
     * @return AbstractRequest
     */
    public function setRefusedUrl($value)
    {
        return $this->setParameter('refusedUrl', $value);
    }

    /**
     * @return mixed
     */
    public function getRefusedUrl()
    {
        return $this->getParameter('refusedUrl');
    }

    /**
     * @param $value
     */
    public function setPaymentCards($value)
    {
        $this->setParameter('paymentCards', $value);
    }

    /**
     * @return mixed
     */
    public function getPaymentCards()
    {
        return $this->getParameter('paymentCards');
    }

    /**
     * @param $value
     * @return AbstractRequest
     */
    public function setOrderId($value)
    {
        return $this->setParameter('orderId', $value);
    }

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->getParameter('orderId');
    }

    /**
     * @param $value
     * @return AbstractRequest
     */
    public function setUuid($value)
    {
        return $this->setParameter('vads_trans_uuid', $value);
    }

    /**
     * @return AbstractRequest
     */
    public function getUuid()
    {
        return $this->setParameter('vads_trans_uuid');
    }

    /**
     * @param string $amount
     * @return string
     */
    public function formatCurrency($amount)
    {
        return (string)intval(strval($amount * 100));
    }

    /**
     * @param $key
     * @param $value
     */
    public function addParameter($key, $value)
    {
        return $this->parameters->set($key, $value);
    }


    public function getAmount()
    {
        return $this->getAmountInteger()."";
    }


    /**
     * @see https://payzen.eu/wp-content/uploads/2013/04/Guide_d_implementation_formulaire_paiement_PayZen_v3.4.pdf
     */
    protected function generateSignature($data)
    {
        // Sort the data
        ksort($data);

        // Filter only the vads_* fields
        $matchedKeys = array_filter(array_keys($data), function ($v) {
            return strpos($v, 'vads_') === 0;
        });
        $data = array_intersect_key($data, array_flip($matchedKeys));

        // Add the certificate
        $data[] = $this->getCertificate();

        return sha1(implode('+', $data));
    }
}
