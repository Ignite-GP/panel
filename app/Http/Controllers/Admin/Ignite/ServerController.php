<?php

namespace Pterodactyl\Http\Controllers\Admin\ignite;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Prologue\Alerts\AlertsMessageBag;
use Pterodactyl\Http\Controllers\Controller;
use Pterodactyl\Http\Requests\Admin\ignite\ServerFormRequest;
use Pterodactyl\Contracts\Repository\SettingsRepositoryInterface;

class ServerController extends Controller
{
    /**
     * @var \Prologue\Alerts\AlertsMessageBag
     */
    private $alert;

    /**
     * @var \Pterodactyl\Contracts\Repository\SettingsRepositoryInterface
     */
    private $settings;

    /**
     * StoreController constructor.
     */
    public function __construct(
        AlertsMessageBag $alert,
        SettingsRepositoryInterface $settings
    ) {
        $this->alert = $alert;
        $this->settings = $settings;
    }

    /**
     * Render the ignite settings interface.
     */
    public function index(): View
    {
        $prefix = 'ignite::renewal:';
    
        return view('admin.ignite.server', [
            'enabled' => $this->settings->get($prefix . 'enabled', false),
            'default' => $this->settings->get($prefix . 'default', 7),
            'cost' => $this->settings->get($prefix . 'cost', 20),
            'editing' => $this->settings->get($prefix . 'editing', false),
            'deletion' => $this->settings->get($prefix . 'deletion', true),
        ]);
    }

    /**
     * Handle settings update.
     *
     * @throws \Pterodactyl\Exceptions\Model\DataValidationException
     * @throws \Pterodactyl\Exceptions\Repository\RecordNotFoundException
     */
    public function update(ServerFormRequest $request): RedirectResponse
    {
        foreach ($request->normalize() as $key => $value) {
            $this->settings->set('ignite::renewal:' . $key, $value);
        }

        $this->alert->success('ignite Server settings has been updated.')->flash();

        return redirect()->route('admin.ignite.server');
    }
}
