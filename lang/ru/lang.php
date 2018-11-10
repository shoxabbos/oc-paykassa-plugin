<?php return [
    'plugin' => [
        'name' => 'Paykassa',
        'description' => 'Paykassa'
    ],
    'settings' => [
    	'label' => 'Настройки',
        'tab_main' => 'Параметры',
        'tab_code' => 'Бизнес логика',
    	'description' => 'Управление параметрами  Paykassa',
    	'merchant_id' => 'Merchant ID',
    	'merchant_password' => 'Merchant password',
        'code' => 'Events (init.php)',
        'currency' => 'Валюта платежа',
        'webhook' => 'URL обработчика',
        'system' => 'Платежная система',
        'code_desc' => 'Вы можете расширить функционал плагина с помощью событий или настроить под себя.',
    ],
    'transactions' => [
        'title' => 'Транзакции',
        'description' => 'Список транзакций'
    ],
    'payform' => [
        'name' => 'Форма оплаты',
        'description' => 'Создает форму с кнопкой оплатить',
        'amount_param' => 'Параметр суммы',
        'amount_param_desc' => 'Параметр суммы с помощью которого будет передаваться сумма',
        'order_param' => 'Заказ / ID пользователя',
        'order_param_desc' => 'Номер заказа или ID пользователя'
    ],
];