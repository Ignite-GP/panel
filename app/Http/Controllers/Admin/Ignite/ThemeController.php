<?php

namespace Pterodactyl\Http\Controllers\Admin\ignite;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Prologue\Alerts\AlertsMessageBag;
use Illuminate\Contracts\Config\Repository;
use Pterodactyl\Http\Controllers\Controller;
use Pterodactyl\Http\Requests\Admin\ignite\ThemeFormRequest;
use Pterodactyl\Contracts\Repository\SettingsRepositoryInterface;

class ThemeController extends Controller
{
    private Repository $config;
    private AlertsMessageBag $alert;
    private SettingsRepositoryInterface $settings;

    /**
     * ThemeController constructor.
     */
    public function __construct(
        Repository $config,
        AlertsMessageBag $alert,
        SettingsRepositoryInterface $settings
    ) 
    {
        $this->alert = $alert;
        $this->config = $config;
        $this->settings = $settings;
    }

    /**
     * Render the ignite settings interface.
     */
    public function index(): View
    {
        return view('admin.ignite.theme', [
            'admin' => $this->settings->get('settings::theme:admin', 'ignite'),
        ]);
    }

    /**
     * Handle settings update.
     *
     * @throws \Pterodactyl\Exceptions\Model\DataValidationException
     * @throws \Pterodactyl\Exceptions\Repository\RecordNotFoundException
     */
    public function update(ThemeFormRequest $request): RedirectResponse
    {
        foreach ($request->normalize() as $key => $value) {
            $this->settings->set('settings::' . $key, $value);
        }

        $this->alert->success('ignite Admin Theme has been updated.')->flash();

        return redirect()->route('admin.ignite.theme');
    }
}