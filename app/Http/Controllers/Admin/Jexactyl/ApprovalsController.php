<?php

namespace Pterodactyl\Http\Controllers\Admin\ignite;

use Illuminate\View\View;
use Pterodactyl\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Prologue\Alerts\AlertsMessageBag;
use Pterodactyl\Http\Controllers\Controller;
use Pterodactyl\Http\Requests\Admin\ignite\ApprovalFormRequest;
use Pterodactyl\Contracts\Repository\SettingsRepositoryInterface;

class ApprovalsController extends Controller
{
    private AlertsMessageBag $alert;
    private SettingsRepositoryInterface $settings;

    /**
     * ApprovalsController constructor.
     */
    public function __construct(
        AlertsMessageBag $alert,
        SettingsRepositoryInterface $settings,
    )
    {
        $this->alert = $alert;
        $this->settings = $settings;
    }

    /**
     * Render the ignite referrals interface.
     */
    public function index(): View
    {
        $users = User::where('approved', false)->get();

        return view('admin.ignite.approvals', [
            'enabled' => $this->settings->get('ignite::approvals:enabled', false),
            'webhook' => $this->settings->get('ignite::approvals:webhook'),
            'users' => $users,
        ]);
    }

    /**
     * Updates the settings for approvals.
     *
     * @throws \Pterodactyl\Exceptions\Model\DataValidationException
     * @throws \Pterodactyl\Exceptions\Repository\RecordNotFoundException
     */
    public function update(ApprovalFormRequest $request): RedirectResponse
    {
        foreach ($request->normalize() as $key => $value) {
            $this->settings->set('ignite::approvals:' . $key, $value);
        }

        $this->alert->success('ignite Approval settings have been updated.')->flash();
        return redirect()->route('admin.ignite.approvals');
    }

    /**
     * Approve an incoming approval request.
     */
    public function approve(Request $request, int $id): RedirectResponse
    {
        $user = User::where('id', $id)->first();
        $user->update(['approved' => true]);
        // This gives the user access to the frontend.

        $this->alert->success($user->username . ' has been approved.')->flash();
        return redirect()->route('admin.ignite.approvals');
    }

    /**
     * Deny an incoming approval request.
     */
    public function deny(Request $request, int $id): RedirectResponse
    {
        $user = User::where('id', $id)->first();
        $user->delete();
        // While typically we should look for associated servers, there
        // shouldn't be any present - as the user has been waiting for approval.

        $this->alert->success($user->username . ' has been denied.')->flash();
        return redirect()->route('admin.ignite.approvals');
    }
}
