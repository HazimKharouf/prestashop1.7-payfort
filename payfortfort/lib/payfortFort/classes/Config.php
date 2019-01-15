<?php

define('PAYFORT_FORT_INTEGRATION_TYPE_REDIRECTION', 'redirection');
define('PAYFORT_FORT_INTEGRATION_TYPE_MERCAHNT_PAGE', 'merchantPage');
define('PAYFORT_FORT_INTEGRATION_TYPE_MERCAHNT_PAGE2', 'merchantPage2');
define('PAYFORT_FORT_PAYMENT_METHOD_CC', 'Payfort Credit Card');
define('PAYFORT_FORT_PAYMENT_METHOD_NAPS', 'Payfort Qpay');
define('PAYFORT_FORT_PAYMENT_METHOD_SADAD', 'Payfort Sadad');
define('PAYFORT_FORT_PAYMENT_METHOD_INSTALLMENTS', 'Payfort Installments');
define('PAYFORT_FORT_FLASH_MSG_ERROR', 'error');
define('PAYFORT_FORT_FLASH_MSG_SUCCESS', 'success');
define('PAYFORT_FORT_FLASH_MSG_INFO', 'info');
define('PAYFORT_FORT_FLASH_MSG_WARNING', 'warning');

class Payfort_Fort_Config extends Payfort_Fort_Super
{

    private static $instance;
    private $language;
    private $merchantIdentifier;
    private $accessCode;
    private $command;
    private $hashAlgorithm;
    private $requestShaPhrase;
    private $responseShaPhrase;
    private $sandboxMode;
    private $gatewayCurrency;
    private $debugMode;
    private $hostUrl;
    private $successOrderStatusId;
    private $orderPlacement;
    private $ccStatus;
    private $ccIntegrationType;
    private $sadadStatus;
    private $napsStatus;
    private $gatewayProdHost;
    private $gatewaySandboxHost;
    private $logFileDir;
    private $installmentsStatus;
    private $installmentsIntegrationType;

    public function __construct()
    {
        parent::__construct();
        $this->gatewayProdHost                       = 'https://checkout.payfort.com/';
        $this->gatewaySandboxHost                    = 'https://sbcheckout.payfort.com/';
        $this->logFileDir                            = _PS_ROOT_DIR_ . '/var/logs/payfort_fort.log';

        $this->language                              = $this->_getShoppingCartConfig('language');
        $this->merchantIdentifier                    = $this->_getShoppingCartConfig('merchant_identifier');
        $this->accessCode                            = $this->_getShoppingCartConfig('access_code');
        $this->command                               = $this->_getShoppingCartConfig('command');
        $this->hashAlgorithm                         = $this->_getShoppingCartConfig('sha_algorithm');
        $this->requestShaPhrase                      = $this->_getShoppingCartConfig('request_sha_phrase');
        $this->responseShaPhrase                     = $this->_getShoppingCartConfig('response_sha_phrase');
        $this->sandboxMode                           = $this->_getShoppingCartConfig('sandbox_mode');
        $this->gatewayCurrency                       = $this->_getShoppingCartConfig('gateway_currency');
        $this->debugMode                             = $this->_getShoppingCartConfig('debug_mode');
        $this->successOrderStatusId                  = $this->_getShoppingCartConfig('hold_review_os');
        $this->orderPlacement                        = 'all';
        $this->ccStatus                              = $this->_getShoppingCartConfig('credit_card');
        $this->ccIntegrationType                     = $this->_getShoppingCartConfig('integration_type');
        $this->sadadStatus                           = $this->_getShoppingCartConfig('sadad');
        $this->napsStatus                            = $this->_getShoppingCartConfig('naps');
        $this->installmentsStatus                    = $this->_getShoppingCartConfig('installments');
        $this->installmentsIntegrationType           = $this->_getShoppingCartConfig('integration_type_installments');
    }

    /**
     * @return Payfort_Fort_Config
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Payfort_Fort_Config();
        }
        return self::$instance;
    }

    private function _getShoppingCartConfig($key)
    {
        $key = strtoupper($key);
        return Configuration::get('PAYFORT_FORT_' . $key);
    }

    public function getLanguage()
    {
        $langCode = $this->language;
        if ($this->language == 'store') {
            $langCode = Payfort_Fort_Language::getCurrentLanguageCode();
        }
        if ($langCode != 'ar') {
            $langCode = 'en';
        }
        return $langCode;
    }

    public function getMerchantIdentifier()
    {
        return $this->merchantIdentifier;
    }

    public function getAccessCode()
    {
        return $this->accessCode;
    }

    public function getCommand()
    {
        return $this->command;
    }

    public function getHashAlgorithm()
    {
        return $this->hashAlgorithm;
    }

    public function getRequestShaPhrase()
    {
        return $this->requestShaPhrase;
    }

    public function getResponseShaPhrase()
    {
        return $this->responseShaPhrase;
    }

    public function getSandboxMode()
    {
        return $this->sandboxMode;
    }

    public function isSandboxMode()
    {
        if ($this->sandboxMode) {
            return true;
        }
        return false;
    }

    public function getGatewayCurrency()
    {
        return $this->gatewayCurrency;
    }

    public function getDebugMode()
    {
        return $this->debugMode;
    }

    public function isDebugMode()
    {
        if ($this->debugMode) {
            return true;
        }
        return false;
    }

    public function getHostUrl()
    {
        return $this->hostUrl;
    }

    public function getSuccessOrderStatusId()
    {
        return $this->successOrderStatusId;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function isActive()
    {
        if ($this->active) {
            return true;
        }
        return false;
    }

    public function getOrderPlacement()
    {
        return $this->orderPlacement;
    }

    public function orderPlacementIsAll()
    {
        if (empty($this->orderPlacement) || $this->orderPlacement == 'all') {
            return true;
        }
        return false;
    }

    public function orderPlacementIsOnSuccess()
    {
        if ($this->orderPlacement == 'success') {
            return true;
        }
        return false;
    }

    public function getCcStatus()
    {
        return $this->ccStatus;
    }

    public function isCcActive()
    {
        if ($this->ccStatus) {
            return true;
        }
        return false;
    }

    public function getCcIntegrationType()
    {
        return $this->ccIntegrationType;
    }

    public function isCcMerchantPage()
    {
        if ($this->ccIntegrationType == PAYFORT_FORT_INTEGRATION_TYPE_MERCAHNT_PAGE) {
            return true;
        }
        return false;
    }

    public function isCcMerchantPage2()
    {
        if ($this->ccIntegrationType == PAYFORT_FORT_INTEGRATION_TYPE_MERCAHNT_PAGE2) {
            return true;
        }
        return false;
    }

    public function getSadadStatus()
    {
        return $this->sadadStatus;
    }

    public function isSadadActive()
    {
        if ($this->sadadStatus) {
            return true;
        }
        return false;
    }

    public function getNapsStatus()
    {
        return $this->napsStatus;
    }

    public function isNapsActive()
    {
        if ($this->napsStatus) {
            return true;
        }
        return false;
    }

    public function getGatewayProdHost()
    {
        return $this->gatewayProdHost;
    }

    public function getGatewaySandboxHost()
    {
        return $this->gatewaySandboxHost;
    }

    public function getLogFileDir()
    {
        return $this->logFileDir;
    }

    public function getInstallmentsIntegrationType()
    {
        return $this->installmentsIntegrationType;
    }

    public function getInstallmentsStatus()
    {
        return $this->installmentsStatus;
    }

}

?>