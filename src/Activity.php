<?php
namespace hb\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

trait Activity {

    public static function log($thisAction, $model)
    {
        //who
        $userNameColumn = config('activity.user_name_column');

//        $user = isset( Auth::user()->$userNameColumn ? Auth::user()->$userNameColumn : 'guest');
        $user = 'guest';
        if (Auth::check()) {
            $user = Auth::user()->$userNameColumn;
        }
        $ipAddress = Request::getClientIp();

        //what
        $modelName = class_basename($model);
        $modelId = $model->getkey();

        //How
        $payload = json_encode($model->getDirty());
        $action = $thisAction;

        ActivityLog::create([
           'user' => $user,
            'ip_address' => $ipAddress,
            'model_name' => $modelName,
            'model_id' => $modelId,
            'payload' => $payload,
            'action' => $action
        ]);
    }
    public static function bootActivity()
    {
        static::created(function ($model) {
            static ::log('created',$model);
        });
        static::updated(function ($model) {
            static ::log('updated',$model);
        });
        static::deleted(function ($model) {
            static ::log('deleted',$model);
        });
    }
}
