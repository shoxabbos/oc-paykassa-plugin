<?php namespace Shohabbos\Paykassa;

use Backend;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
        return [
            \Shohabbos\Paykassa\Components\PayForm::class => 'payFormComponent',
        ];
    }

    public function registerSettings()
    {
	    return [
	    	'transactions' => [
                'label'       => 'shohabbos.paykassa::lang.transactions.title',
                'description' => 'shohabbos.paykassa::lang.transactions.description',
                'icon'        => 'icon-list-alt',
                'url'         => Backend::url('shohabbos/paykassa/transactions'),
                'order'       => 500,
                'category'    => 'shohabbos.paykassa::lang.plugin.name',
            ],
	        'settings' => [
	        	'category'    => 'shohabbos.paykassa::lang.plugin.name',
	            'label'       => 'shohabbos.paykassa::lang.settings.label',
	            'description' => 'shohabbos.paykassa::lang.settings.description',
	            'icon'        => 'icon-cog',
	            'class'       => 'Shohabbos\Paykassa\Models\Settings',
	            'order'       => 501,
	            'keywords'    => 'Paykassa paymets',
	        ]
	    ];
    }
}
