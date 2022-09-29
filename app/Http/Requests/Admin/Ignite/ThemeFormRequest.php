<?php

namespace Pterodactyl\Http\Requests\Admin\Ignite;

use Pterodactyl\Http\Requests\Admin\AdminFormRequest;

class ThemeFormRequest extends AdminFormRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'theme:admin' => 'required|string|in:ignite,dark,light,blue,minecraft',
        ];
    }
}
