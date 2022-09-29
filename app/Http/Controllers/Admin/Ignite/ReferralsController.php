<?php

namespace Pterodactyl\Http\Controllers\Admin\ignite;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Prologue\Alerts\AlertsMessageBag;
use Pterodactyl\Http\Controllers\Controller;
use Pterodactyl\Contracts\Repository\SettingsRepositoryInterface;
use Pterodactyl\Http\Requests\Admin\ignite\ReferralsFormRequest;

class ReferralsController extends Controller
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
     * Render the ignite referrals interface.
     */
    public function index(): View
    {
        return view('admin.ignite.referrals', [
            'enabled' => $this->settings->get('ignite::referrals:enabled', false),
            'reward' => $this->settings->get('ignite::referrals:reward', 250),
        ]);
    }

    /**
     * Handle settings update.
     *
     * @throws \Pterodactyl\Exceptions\Model\DataValidationException
     * @throws \Pterodactyl\Exceptions\Repository\RecordNotFoundException
     */
    public function update(ReferralsFormRequest $request): RedirectResponse
    {
        foreach ($request->normalize() as $key => $value) {
            $this->settings->set('ignite::referrals:' . $key, $value);
        }

        $this->alert->success('Referral system has been updated.')->flash();

        return redirect()->route('admin.ignite.referrals');
    }
}
