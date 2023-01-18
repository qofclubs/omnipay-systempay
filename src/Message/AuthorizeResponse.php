<?php

namespace Omnipay\SystemPay\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

/**
 * SystemPay Authorize Response
 */
class AuthorizeResponse extends AbstractResponse implements RedirectResponseInterface
{
    public $liveEndpoint = 'https://paiement.systempay.fr/vads-payment/';

    public function getEndpoint()
    {
        return $this->liveEndpoint;
    }

    public function isSuccessful()
    {
        return false;
    }

    public function isRedirect()
    {
        return true;
    }

    public function getRedirectUrl()
    {
        return $this->getEndpoint();
    }

    public function getRedirectMethod()
    {
        return 'POST';
    }

    public function getRedirectData()
    {
        return $this->data;
    }
}
