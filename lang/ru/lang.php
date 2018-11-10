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
];