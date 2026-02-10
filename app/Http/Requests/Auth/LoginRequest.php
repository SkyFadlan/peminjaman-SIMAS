<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'login_type' => ['required', 'in:email,nisn'],
            'credential' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'credential.required' => 'Email atau NISN harus diisi',
            'login_type.required' => 'Pilih tipe login terlebih dahulu',
            'login_type.in' => 'Tipe login tidak valid',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'login_type' => $this->input('login_type', 'email'),
        ]);
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
{
    $this->ensureIsNotRateLimited();

    $credentials = $this->getCredentials();

    if (! Auth::attempt($credentials, $this->boolean('remember'))) {
        RateLimiter::hit($this->throttleKey());

        throw ValidationException::withMessages([
            'credential' => __('auth.failed'),
        ]);
    }

    // Validasi role sesuai dengan login type
    $user = Auth::user();
    $loginType = $this->input('login_type');
    
    // Jika user tidak punya role, set default
    if (empty($user->role)) {
        $user->role = 'siswa';
        $user->save();
    }
    
    // Jika login dengan NISN, harus role siswa
    if ($loginType === 'nisn' && !$user->isSiswa()) {
        Auth::logout();
        throw ValidationException::withMessages([
            'credential' => 'NISN hanya untuk siswa',
        ]);
    }
    
    // Jika login dengan email, harus admin atau petugas
    if ($loginType === 'email' && $user->isSiswa()) {
        Auth::logout();
        throw ValidationException::withMessages([
            'credential' => 'Email hanya untuk admin dan petugas',
        ]);
    }

    RateLimiter::clear($this->throttleKey());
}

    /**
     * Get the credentials based on login type.
     */
    private function getCredentials(): array
    {
        $loginType = $this->input('login_type');
        $credential = $this->input('credential');

        if ($loginType === 'email') {
            return [
                'email' => $credential,
                'password' => $this->input('password'),
            ];
        }

        // Login dengan NISN
        return [
            'nisn' => $credential,
            'password' => $this->input('password'),
        ];
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'credential' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        $loginType = $this->input('login_type', 'email');
        $credential = $this->input('credential');
        
        return Str::transliterate(Str::lower("{$loginType}:{$credential}").'|'.$this->ip());
    }
}