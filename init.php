<?php
use RainLab\User\Models\User as UserModel;
use Shohabbos\Portal\Models\Payment;

Event::listen('shohabbos.paykassa.onSuccess', function ($response) {
    $amount = (float)$response["data"]["amount"];
    $id = $response["data"]["order_id"];
    
    // add balance or check order as paid
	$user = UserModel::find($id);
	$user->balance += $amount;
	$user->save();

	// add to history payments
	$payment = new Payment();
	$payment->user_id = $id;
	$payment->is_buy = true;
	$payment->amount = $amount;
	$payment->payment_system = 'payeer';
	$payment->date = date('Y-m-d H:i:s');
	$payment->save();
});
