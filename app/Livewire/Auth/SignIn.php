<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\ApplicantIdentity;

class SignIn extends Component
{
    public $nik = '';
    public $password = '';
    public $remember = false;

    protected $rules = [
        'nik' => 'required',
        'password' => 'required',
    ];

    public function login()
    {
        $this->validate();

        // Check if input is email or NIK
        if (filter_var($this->nik, FILTER_VALIDATE_EMAIL)) {
            // Email login (for HRD/Staff)
            $credentials = [
                'email' => $this->nik,
                'password' => $this->password,
            ];

            if (Auth::attempt($credentials, $this->remember)) {
                request()->session()->regenerate();
                return $this->redirectByRole();
            }

            session()->flash('error', 'Email atau password salah.');
            return;
        }

        // NIK login (for Applicants)
        if (strlen($this->nik) !== 16 || !is_numeric($this->nik)) {
            session()->flash('error', 'NIK harus 16 digit angka atau gunakan email untuk staff.');
            return;
        }

        // Find user by NIK
        $identity = ApplicantIdentity::where('national_id_number', $this->nik)->first();

        if (!$identity) {
            session()->flash('error', 'NIK tidak ditemukan. Silakan daftar terlebih dahulu.');
            return;
        }

        // Attempt login with user's email
        $credentials = [
            'email' => $identity->user->email,
            'password' => $this->password,
        ];

        if (Auth::attempt($credentials, $this->remember)) {
            request()->session()->regenerate();
            return $this->redirectByRole();
        }

        session()->flash('error', 'NIK atau password salah.');
    }

    private function redirectByRole()
    {
        // Redirect based on role
        if (Auth::user()->hasRole('applicant')) {
            return redirect()->route('applicant.dashboard');
        } elseif (Auth::user()->hasRole('hr_recruiter')) {
            return redirect()->route('hrd.dashboard');
        } elseif (Auth::user()->hasRole(['admin', 'interviewer', 'manager'])) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.auth.sign-in');
    }
}
