<?php

namespace App\Livewire\Hrd;

use Livewire\Component;
use App\Models\HiringApprovalRequest;
use App\Models\OfferLetter;

class GenerateOfferLetter extends Component
{
    public $approvalId;
    public $approval;
    public $offerLetterContent;
    public $showPreview = false;

    public function mount($approvalId = null)
    {
        if ($approvalId) {
            $this->approvalId = $approvalId;
            $this->approval = HiringApprovalRequest::with(['application.user', 'application.job'])
                ->findOrFail($approvalId);
            
            $this->generateOfferContent();
        }
    }

    public function loadApprovedCandidates()
    {
        return HiringApprovalRequest::with(['application.user', 'application.job'])
            ->where('status', 'approved')
            ->whereDoesntHave('offerLetter')
            ->get();
    }

    public function selectCandidate($approvalId)
    {
        $this->mount($approvalId);
    }

    public function generateOfferContent()
    {
        $candidate = $this->approval->application->user;
        $job = $this->approval->application->job;
        
        $this->offerLetterContent = "
<div style='font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto;'>
    <div style='text-align: center; margin-bottom: 30px;'>
        <h2>PT AISIN INDONESIA</h2>
        <p>Jl. Industri Raya No. 1, Karawang, Jawa Barat</p>
    </div>
    
    <p style='text-align: right;'>" . now()->format('d F Y') . "</p>
    
    <p>Kepada Yth,<br>
    <strong>{$candidate->name}</strong><br>
    {$candidate->address}</p>
    
    <p><strong>Perihal: Surat Penawaran Kerja</strong></p>
    
    <p>Dengan hormat,</p>
    
    <p>Berdasarkan hasil seleksi yang telah dilakukan, dengan ini kami menawarkan kepada Saudara/i untuk bergabung dengan PT Aisin Indonesia dengan detail sebagai berikut:</p>
    
    <table style='width: 100%; margin: 20px 0;'>
        <tr>
            <td width='200'><strong>Posisi</strong></td>
            <td>: {$this->approval->position_title}</td>
        </tr>
        <tr>
            <td><strong>Departemen</strong></td>
            <td>: {$this->approval->department}</td>
        </tr>
        <tr>
            <td><strong>Status Karyawan</strong></td>
            <td>: " . ucfirst($this->approval->employment_type) . "</td>
        </tr>
        <tr>
            <td><strong>Gaji</strong></td>
            <td>: Rp " . number_format($this->approval->salary_offered, 0, ',', '.') . "</td>
        </tr>
        <tr>
            <td><strong>Tanggal Bergabung</strong></td>
            <td>: " . \Carbon\Carbon::parse($this->approval->join_date)->format('d F Y') . "</td>
        </tr>
    </table>
    
    <p><strong>Benefit yang diterima:</strong></p>
    <p>{$this->approval->benefits_package}</p>
    
    <p>Mohon untuk memberikan konfirmasi penerimaan atau penolakan tawaran ini paling lambat 7 hari sejak surat ini diterima.</p>
    
    <p>Demikian surat penawaran ini kami sampaikan. Atas perhatian dan kerjasamanya, kami ucapkan terima kasih.</p>
    
    <p style='margin-top: 50px;'>Hormat kami,<br><br><br>
    <strong>PT Aisin Indonesia</strong><br>
    HRD Department</p>
</div>
        ";
    }

    public function openPreview()
    {
        $this->showPreview = true;
    }

    public function generateAndSend()
    {
        $offerNumber = OfferLetter::generateOfferNumber();

        $offer = OfferLetter::create([
            'application_id' => $this->approval->application_id,
            'approval_request_id' => $this->approval->id,
            'offer_number' => $offerNumber,
            'offer_letter_content' => $this->offerLetterContent,
            'status' => 'sent',
            'generated_by' => auth()->id(),
        ]);

        // TODO: Generate PDF
        // TODO: Send email & WhatsApp

        $offer->markAsSent();

        session()->flash('message', "✅ Offer letter #{$offerNumber} sent successfully!");
        
        return redirect()->route('hrd.hiring-approval.offers');
    }

    public function render()
    {
        $candidates = $this->approvalId ? null : $this->loadApprovedCandidates();
        
        return view('livewire.hrd.generate-offer-letter', [
            'candidates' => $candidates,
        ])->layout('layouts.hrd');
    }
}
