<?php namespace Shohabbos\Paykassa\Components;

use Input;
use Validator;
use ValidationException;
use Cms\Classes\ComponentBase;
use Shohabbos\Payeer\Models\Settings;
use Shohabbos\Paykassa\Classes\PayKassaSCI;

/**
 * User session
 *
 * This will inject the user object to every page and provide the ability for
 * the user to sign out. This can also be used to restrict access to pages.
 */
class PayForm extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'shohabbos.paykassa::lang.payform.name',
            'description' => 'shohabbos.paykassa::lang.payform.description'
        ];
    }

    public function defineProperties()
    {
        return [
            'paramAmount' => [
                'title'       => 'shohabbos.paykassa::lang.payform.amount_param',
                'description' => 'shohabbos.paykassa::lang.payform.amount_param_desc',
                'type'        => 'string',
                'default'     => 'amount'
            ],
            'paramOrder' => [
                'title'       => 'shohabbos.paykassa::lang.payform.order_param',
                'description' => 'shohabbos.paykassa::lang.payform.order_param_desc',
                'type'        => 'string',
                'default'     => 'order_id'
            ],
        ];
    }

    public function onPayForm()
    {
        $paramAmount = $this->property('paramAmount');
        $paramOrder = $this->property('paramOrder');

        $paykassa_merchant_id = Settings::get("merchant_id");
        $paykassa_merchant_password = Settings::get("merchant_password");
        $paykassa_currency = Settings::get("currency");

        $amount = $paramAmount;
        $system = 'bitcoin';
        $currency = $paykassa_currency;
        $order_id = $paramOrder;
        $comment = 'comment';

        $paykassa = new PayKassaSCI( 
            $paykassa_merchant_id,       // идентификатор магазина
            $paykassa_merchant_password  // пароль магазина
        );

        $system_id = [
            "payeer"            => 1,  // поддерживаемая валюта RUB USD
            "perfectmoney"      => 2,  // поддерживаемая валюта USD
            "advcash"           => 4,  // поддерживаемая валюта RUB USD
            "berty"             => 7,  // поддерживаемая валюта RUB USD
            "bitcoin"           => 11, // поддерживаемая валюта BTC
            "ethereum"          => 12, // поддерживаемая валюта ETH
            "litecoin"          => 14, // поддерживаемая валюта LTC
            "dogecoin"          => 15, // поддерживаемая валюта DOGE
            "dash"              => 16, // поддерживаемая валюта DASH
            "bitcoincash"       => 18, // поддерживаемая валюта BCH
            "zcash"             => 19, // поддерживаемая валюта ZEC
            "monero"            => 20, // поддерживаемая валюта XMR
            "ethereumclassic"   => 21, // поддерживаемая валюта ETC
            "ripple"            => 22, // поддерживаемая валюта XRP
            "neo"               => 23, // поддерживаемая валюта NEO
            "gas"               => 24, // поддерживаемая валюта GAS
        ];

        $res = $paykassa->sci_create_order(
            $amount,    // обязательный параметр, сумма платежа, пример: 1.0433
            $currency,  // обязательный параметр, валюта, пример: BTC
            $order_id,  // обязательный параметр, уникальный числовой идентификатор платежа в вашей системе, пример: 150800
            $comment,   // обязательный параметр, текстовый комментарй платежа, пример: Заказ услуги #150800
            $system_id[$system] // обязательный параметр, указав его Вас минуя мерчант переадресует на платежную систему, пример: 12 - Ethereum
        );

        if ($res['error']) {        // $res['error'] - true если ошибка
            echo $res['message'];   // $res['message'] - текст сообщения об ошибке
            //действия в случае ошибки
        } else {
        }

    }


    
}
