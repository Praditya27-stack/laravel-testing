<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SignUp extends Component
{
    // Step 1: NIK & Basic Info
    public $nik = '';
    public $nik_verified = false;
    public $birth_date = '';
    public $birth_date_verified = false;
    
    // Step 2: Account Info
    public $password = '';
    public $password_confirmation = '';
    public $full_name = '';
    public $email = '';
    public $phone = '';
    
    // Step 3: Disability Questions
    public $has_disability = false;
    public $disability_type = '';
    public $is_colorblind = false;
    public $has_vision_correction = false;
    public $vision_details = '';
    
    public $current_step = 1;
    public $show_guide = true;

    protected $rules = [
        'nik' => 'required|digits:16|unique:applicant_identities,national_id_number',
        'password' => 'required|min:8|confirmed',
        'full_name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'phone' => 'required|string|max:20',
    ];

    public function verifyNIK()
    {
        $this->validate([
            'nik' => 'required|digits:16|unique:applicant_identities,national_id_number'
        ]);

        // TODO: Integrate with Disdukcapil API
        // For now, extract birth date from NIK
        // NIK format: DDMMYY... (first 6 digits)
        $day = substr($this->nik, 0, 2);
        $month = substr($this->nik, 2, 2);
        $year = substr($this->nik, 4, 2);
        
        // If day > 40, it's female (subtract 40)
        if ($day > 40) {
            $day = $day - 40;
        }
        
        // Determine century (assume 2000s if year > 50, else 1900s)
        $year = ($year > 50) ? '19' . $year : '20' . $year;
        
        $this->birth_date = $year . '-' . $month . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);
        $this->nik_verified = true;
        
        session()->flash('success', 'NIK berhasil diverifikasi!');
    }

    public function confirmBirthDate()
    {
        $this->birth_date_verified = true;
        $this->current_step = 2;
    }

    public function nextStep()
    {
        if ($this->current_step == 2) {
            $this->validate([
                'password' => 'required|min:8|confirmed',
                'full_name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|string|max:20',
            ]);
            $this->current_step = 3;
        }
    }

    public function register()
    {
        $this->validate();

        // Create user account
        $user = User::create([
            'name' => $this->full_name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'email_verified_at' => now(), // Auto verify for now
        ]);

        // Assign applicant role
        $user->assignRole('applicant');

        // Create applicant identity with NIK and disability info
        $user->applicantIdentity()->create([
            'full_name' => $this->full_name,
            'national_id_number' => $this->nik,
            'birth_date' => $this->birth_date,
            'phone_number' => $this->phone,
            'email' => $this->email,
            // Temporary values for required fields (will be completed in profile)
            'address_ktp' => 'Belum diisi',
            'address_domicile' => 'Belum diisi',
            'religion' => 'islam',
            'gender' => 'L',
        ]);

        // Auto login
        Auth::login($user);

        // Redirect to dashboard
        return redirect()->route('applicant.dashboard');
    }

    public function render()
    {
        return view('livewire.auth.sign-up');
    }
}
