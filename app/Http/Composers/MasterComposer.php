<?php
namespace App\Http\Composers;

use Illuminate\Contracts\View\View;
use App\Http\Helpers\AppHelper;

class MasterComposer
{

    public function compose(View $view)
    {
        $view->with(
            [
            'idh' => AppHelper::gerCRVHash(),
            'idc' => '65b0b277848054d579c90a968f89e397fe6b3b48'
            ]
        );
    }

}