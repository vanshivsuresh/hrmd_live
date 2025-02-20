<?php

namespace App\Actions\Fortify;

use App\Http\Controllers\AccountBaseController;
use App\Models\Company;
use App\Models\GlobalSetting;
use App\Models\Role;
use App\Models\User;
use App\Notifications\NewCustomer;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{

    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\UserAuth
     */
    public function create(array $input)
    {
        $company = Company::first();

        if ((!$company->allow_client_signup) || isHrmForSale()) {
            return abort(403, __('messages.clientSignUpDisabledByAdmin'));
        }

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => 'required|min:8',
        ];

        if (global_setting()->sign_up_terms == 'yes') {
            $rules['terms_and_conditions'] = 'required';
        }

        Validator::make($input, $rules)->validate();

        // Checking is google recaptcha is valid
        if (global_setting()->google_recaptcha_status == 'active') {
            $gRecaptchaResponseInput = global_setting()->google_recaptcha_v3_status == 'active' ? 'g_recaptcha' : 'g-recaptcha-response';
            $gRecaptchaResponse = $input[$gRecaptchaResponseInput];
            $validateRecaptcha = GlobalSetting::validateGoogleRecaptcha($gRecaptchaResponse);

            if (!$validateRecaptcha) {
                abort(403, __('auth.recaptchaFailed'));
            }
        }

        $user = User::create([
            'company_id' => $company->id,
            'name' => $input['name'],
            'email' => $input['email'],
            'admin_approval' => !$company->admin_client_signup_approval,
        ]);

        $userAuth = $user->userAuth()->create(['email' => $input['email'], 'password' => bcrypt($input['password'])]);
        $user->user_auth_id = $userAuth->id;
        $user->saveQuietly();

        $user->clientDetails()->create(['company_name' => $company->company_name]);

        $role = Role::where('company_id', $company->id)->where('name', 'client')->select('id')->first();
        $user->attachRole($role->id);

        $user->assignUserRolePermission($role->id);

        $log = new AccountBaseController();

        // Log search
        $log->logSearchEntry($user->id, $user->name, 'clients.show', 'client');

        if (!is_null($user->email)) {
            $log->logSearchEntry($user->id, $user->email, 'clients.show', 'client');
        }

        if (!is_null($user->clientDetails->company_name)) {
            $log->logSearchEntry($user->id, $user->clientDetails->company_name, 'clients.show', 'client');
        }

        Notification::send(User::allAdmins($user->company->id), new NewCustomer($user));

        return $userAuth;

    }

}
