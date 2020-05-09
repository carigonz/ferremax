<?php
namespace App\Http\Controllers\ViewComposers\Alerts;

use Session;

class AlertComposer 
{
    /** @var View $view */
    public function compose($view)
    {
        $alerts = [];
        if ($view->errors && $view->errors->any()){
            if ($view->errors->count() === 1){
                $alerts['danger'] = $view->errors->first();
            } else {
                $alerts['danger'] = $view->errors->all();
            }
        }

        if (Session::get('alert_warning')){
            $alerts['warning'] = Session::get('alert_warning');
        }

        if (Session::get('alert_danger')){
            $alerts['danger'] = Session::get('alert_danger');
        }

        if (Session::get('alert_success')){
            $alerts['success'] = Session::get('alert_success');
        }

        $view->with('alerts', $alerts);
    }

}