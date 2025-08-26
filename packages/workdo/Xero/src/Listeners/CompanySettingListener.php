<?php

namespace Workdo\Xero\Listeners;
use App\Events\CompanySettingEvent;

class CompanySettingListener
{
    /**
     * Handle the event.
     */
    public function handle(CompanySettingEvent $event): void
    {
        $module = 'Xero';
        $methodName = 'index';
        $controllerClass = "Workdo\\Xero\\Http\\Controllers\\Company\\SettingsController";
        if (class_exists($controllerClass)) {
            $controller = \App::make($controllerClass);
            if (method_exists($controller, $methodName)) {
                $html = $event->html;
                $settings = $html->getSettings();
                $output =  $controller->{$methodName}($settings);
                $html->add([
                    'html' => $output->toHtml(),
                    'order' => 637,
                    'module' => $module,
                    'permission' => 'xero manage'
                ]);
            }
        }
    }


}
