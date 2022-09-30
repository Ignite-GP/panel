<?php

namespace Pterodactyl\Http\Controllers\Admin\Ignite;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Prologue\Alerts\AlertsMessageBag;
use Pterodactyl\Http\Controllers\Controller;
use Pterodactyl\Contracts\Repository\SettingsRepositoryInterface;
use Pterodactyl\Http\Requests\Admin\Ignite\RegistrationFormRequest;

class RegistrationController extends Controller
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
     * RegistrationController constructor.
     */
    public function __construct(
        AlertsMessageBag $alert,
        SettingsRepositoryInterface $settings
    ) {
        $this->alert = $alert;
        $this->settings = $settings;
    }

    /**
     * Render the Ignite settings interface.
     */
    public function index(): View
    {
        return view('admin.ignite.registration', [
            'enabled' => $this->settings->get('ignite::registration:enabled', false),

            'discord_enabled' => $this->settings->get('ignite::discord:enabled', false),
            'discord_id' => $this->settings->get('ignite::discord:id', 0),
            'discord_secret' => $this->settings->get('ignite::discord:secret', 0),

            'cpu' => $this->settings->get('ignite::registration:cpu', 100),
            'memory' => $this->settings->get('ignite::registration:memory', 1024),
            'disk' => $this->settings->get('ignite::registration:disk', 5120),
            'slot' => $this->settings->get('ignite::registration:slot', 1),
            'port' => $this->settings->get('ignite::registration:port', 1),
            'backup' => $this->settings->get('ignite::registration:backup', 1),
            'database' => $this->settings->get('ignite::registration:database', 0),
        ]);
    }

    /**
     * Handle settings update.
     *
     * @throws \Pterodactyl\Exceptions\Model\DataValidationException
     * @throws \Pterodactyl\Exceptions\Repository\RecordNotFoundException
     */
    public function update(RegistrationFormRequest $request): RedirectResponse
    {
        foreach ($request->normalize() as $key => $value) {
            $this->settings->set('ignite::' . $key, $value);
        }

        $this->alert->success('Ignite Registration has been updated.')->flash();

        return redirect()->route('admin.ignite.registration');
    }
}
