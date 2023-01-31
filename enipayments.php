<?php

declare(strict_types=1);

if (!defined('_PS_VERSION_')) {
    exit;
}
class EniPayments extends PaymentModule
{
    public $currencies_mode = 'checkbox';
    public function __construct()
    {
        $this->name = 'enipayments';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Jonathan Danse';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = [
            'min' => '8.0.0',
            'max' => '8.99.99',
        ];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('EniPayments');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
    }

    public function install()
    {
        $hooks = [
            'paymentOptions',
            'displayPaymentReturn',
        ];

        return
            parent::install()
            && $this->registerHook($hooks);
    }

    public function hookPaymentOptions($params)
    {
        $paymentOptions = [];

        $option = new \PrestaShop\PrestaShop\Core\Payment\PaymentOption();
        $option->setCallToActionText($this->l('Eni Payments'))
                ->setAction($this->context->link->getModuleLink($this->name, 'validation', [], true))
                ->setAdditionalInformation($this->displayWarning('Information additionelle'))
                ->setInputs([
                    'card_number' => [
                        'name' =>'card_number',
                        'type' =>'text',
                        'value' => '',
                    ],
                ]);

        $paymentOptions[] = $option;

        $option = new \PrestaShop\PrestaShop\Core\Payment\PaymentOption();
        $option->setCallToActionText($this->l('Eni Payments - Seconde méthode'))
                ->setAction($this->context->link->getModuleLink($this->name, 'validation', [], true));

        $paymentOptions[] = $option;

        return $paymentOptions;
    }

    public function hookDisplayPaymentReturn($params)
    {

    }
}
