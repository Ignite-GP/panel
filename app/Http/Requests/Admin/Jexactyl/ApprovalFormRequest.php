<?php

namespace Pterodactyl\Http\Requests\Admin\ignite;

use Pterodactyl\Http\Requests\Admin\AdminFormRequest;

class ApprovalFormRequest extends AdminFormRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'enabled' => 'required|in:true,false',
            'webhook' => 'nullable|active_url',
        ];
    }
}
