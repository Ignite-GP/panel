<?php

namespace Pterodactyl\Http\Requests\Admin\ignite;

use Pterodactyl\Http\Requests\Admin\AdminFormRequest;

class ReferralsFormRequest extends AdminFormRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'enabled' => 'required|in:true,false',
            'reward' => 'required|min:0',
        ];
    }
}
