<?php
namespace App\Http\Composers;

use Illuminate\Contracts\View\View;

class MasterComposer
{

    public function compose(View $view)
    {
        $view->with('idc', '65b0b277848054d579c90a968f89e397fe6b3b48');
    }

}