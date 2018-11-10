<?php namespace Shohabbos\Paykassa\Components;

use Input;
use Validator;
use ValidationException;
use Cms\Classes\ComponentBase;
use Shohabbos\Paykassa\Models\Settings;
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

        $data = Input::only([$paramAmount, $paramOrder]);

        $validator = Validator::make($data, [
            $paramOrder => 'required',
            $paramAmount => 'required',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $paykassa_merchant_id = Settings::get("merchant_id");
        $paykassa_merchant_password = Settings::get("merchant_password");

        $paykassa = new PayKassaSCI( 
            $paykassa_merchant_id,       // идентификатор магазина
            $paykassa_merchant_password  // пароль магазина
        );

        $currency = Settings::get("currency");
        $system_id = Settings::get("system");
        $amount = $data[$paramAmount];
        $order_id = $data[$paramOrder];


        $res = $paykassa->sci_create_order($amount, $currency, $order_id, 'Comment', $system_id);


        if ($res['error']) {
            throw new ValidationException(['error' => $res['message']]);
        } else {
            $this->page['amount'] = $amount;
            $this->page['data'] = $res['data'];
        }
    }


    
}
