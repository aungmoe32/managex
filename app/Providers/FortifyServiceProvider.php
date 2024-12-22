<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use Illuminate\Support\Facades\RateLimiter;
use Laravel\Fortify\Contracts\LogoutResponse;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\PasswordUpdateResponse;
use Laravel\Fortify\Contracts\TwoFactorLoginResponse;
use Laravel\Fortify\Contracts\{LoginResponse, RegisterResponse, PasswordResetResponse};

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Customize login response
        $this->app->instance(LoginResponse::class, new class implements LoginResponse {
            public function toResponse($request)
            {
                if ($request->wantsJson()) {
                    $user = User::where('email', $request->email)->first();
                    return response()->json([
                        "message" => "You are successfully logged in",
                        "token" => $user->createToken($request->email)->plainTextToken,
                    ], 200);
                }
                return redirect()->intended(Fortify::redirects('login'));
            }
        });

        // Customize 2FA Success Response
        $this->app->instance(TwoFactorLoginResponse::class, new class implements TwoFactorLoginResponse {
            public function toResponse($request)
            {
                $user = request()->user();
                Auth::logout();
                if (request()->session()) {
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                }
                return response()->json([
                    "message" => "You are successfully logged in",
                    "token" => $user->createToken('api')->plainTextToken,
                ], 200);
            }
        });

        // Customize register response
        $this->app->instance(RegisterResponse::class, new class implements RegisterResponse {
            public function toResponse($request)
            {
                $user = User::where('email', $request->email)->first();
                return $request->wantsJson()
                    ? response()->json([
                        'message' => 'Registration successful, verify your email address',
                        "token" => $user->createToken($request->email)->plainTextToken,
                    ], 200)
                    : redirect()->intended(Fortify::redirects('register'));
            }
        });

        // Customized logout response
        $this->app->instance(LogoutResponse::class, new class implements LogoutResponse {
            public function toResponse($request)
            {
                return $request->wantsJson()
                    ? response()->json(['message' => 'Succesfully logged out'], 200)
                    : redirect(Fortify::redirects('logout', '/'));
            }
        });

        // Customized password update response
        $this->app->instance(PasswordUpdateResponse::class, new class implements PasswordUpdateResponse {
            public function toResponse($request)
            {
                return $request->wantsJson()
                    ? response()->json(['message' => 'password updated successfully'], 200)
                    : back()->with('status', Fortify::PASSWORD_UPDATED);
            }
        });

        // Response after reset success
        $this->app->singleton(
            PasswordResetResponse::class,
            function ($app, $status) {
                return new class implements PasswordResetResponse {
                    public function toResponse($request)
                    {
                        // TODO: need to revoke all tokens of user
                        return response()->json([
                            "message" => "Password reset successfully.",
                        ], 200);
                    }
                };
            }
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        // Fortify::registerView(function () {
        //     return view('auth.register');
        // });

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
