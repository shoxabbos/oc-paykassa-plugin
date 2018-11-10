<?php namespace Shohabbos\Paykassa\Controllers;

use Event;
use Illuminate\Routing\Controller;
use Shohabbos\Paykassa\Models\Settings;
use Shohabbos\Paykassa\Classes\PayKassaSCI;

class Paykassa extends Controller
{

    public function index(\Illuminate\Http\Request $mainRequest) {
        if (!in_array($_SERVER['REMOTE_ADDR'], ['79.137.67.141', '54.37.60.196'])) {
	        return;
	    }

	    $paykassa_merchant_id = Settings::get("merchant_id");
	    $paykassa_merchant_password = Settings::get("merchant_password");

	    $paykassa = new PayKassaSCI(
	        $paykassa_merchant_id,      // идентификатор магазина
	        $paykassa_merchant_password // пароль магазина
	    );

	    $res = $paykassa->sci_confirm_order();

	    if ($res['error']) {
	        Event::fire('shohabbos.paykassa.onError', [$res]);
			print_r($res);
	        exit;
	    } else {
	    	Event::fire('shohabbos.paykassa.onSuccess', [$res]);

	        // действия в случае успеха
	        $id = $res["data"]["order_id"];        // уникальный числовой идентификатор платежа в вашем системе, пример: 150800
	        $transaction = $res["data"]["transaction"]; // номер транзакции в системе paykassa: 96401
	        $hash = $res["data"]["hash"];               // hash, пример: bde834a2f48143f733fcc9684e4ae0212b370d015cf6d3f769c9bc695ab078d1
	        $currency = $res["data"]["currency"];       // валюта платежа, пример: DASH
	        $system = $res["data"]["system"];           // система, пример: Dash
	        $address = $res["data"]["address"];         // адрес криптовалютного кошелька, пример: Xybb9RNvdMx8vq7z24srfr1FQCAFbFGWLg

	        $partial = $res["data"]["partial"];         // настройка приема недоплаты или переплаты, 'yes' - принимать, 'no' - не принимать
	        $amount = (float)$res["data"]["amount"];    // сумма счета, пример: 1.0000000

	        if ($partial === 'yes') {
	            // сумма заявки может не совпадать с полученной суммой, если включен режим частичной оплаты
	            // актально только для криптовалют, поумолчанию 'no'
	        }

	        // ваш код...

	        echo $id.'|success'; // обязательно, для подтверждения зачисления платежа
	    }
    }

}
