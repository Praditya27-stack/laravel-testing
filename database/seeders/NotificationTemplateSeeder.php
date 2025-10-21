<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $templates = [
            [
                'name' => 'Psychotest Invitation',
                'type' => 'both',
                'stage' => 'psychotest_invite',
                'email_subject' => 'Undangan Psikotes - {{job_title}}',
                'email_body' => '<html><body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
                    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
                        <h2 style="color: #0066cc;">PT Aisin Indonesia</h2>
                        <p>Yth. <strong>{{name}}</strong>,</p>
                        <p>Selamat! Anda telah lolos tahap administratif untuk posisi <strong>{{job_title}}</strong>.</p>
                        <p>Kami mengundang Anda untuk mengikuti psikotes dengan detail sebagai berikut:</p>
                        <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
                            <tr><td style="padding: 8px; border-bottom: 1px solid #ddd;"><strong>Tanggal:</strong></td><td style="padding: 8px; border-bottom: 1px solid #ddd;">{{date}}</td></tr>
                            <tr><td style="padding: 8px; border-bottom: 1px solid #ddd;"><strong>Waktu:</strong></td><td style="padding: 8px; border-bottom: 1px solid #ddd;">{{time}}</td></tr>
                            <tr><td style="padding: 8px; border-bottom: 1px solid #ddd;"><strong>Lokasi:</strong></td><td style="padding: 8px; border-bottom: 1px solid #ddd;">{{location}}</td></tr>
                            <tr><td style="padding: 8px; border-bottom: 1px solid #ddd;"><strong>Berlaku hingga:</strong></td><td style="padding: 8px; border-bottom: 1px solid #ddd;">{{expiry_date}}</td></tr>
                        </table>
                        <p><a href="{{link}}" style="display: inline-block; padding: 12px 24px; background-color: #0066cc; color: white; text-decoration: none; border-radius: 4px;">Akses Psikotes</a></p>
                        <p style="color: #666; font-size: 14px;">Link akan kadaluarsa dalam 48 jam. Pastikan Anda menyelesaikan tes sebelum batas waktu.</p>
                        <p>Hormat kami,<br><strong>Tim Rekrutmen PT Aisin Indonesia</strong></p>
                    </div>
                </body></html>',
                'whatsapp_message' => 'Halo *{{name}}*, Selamat! Anda lolos tahap administratif untuk posisi *{{job_title}}*. 

Silakan ikuti psikotes:
📅 Tanggal: {{date}}
🕐 Waktu: {{time}}
📍 Lokasi: {{location}}

Link: {{link}}

⏰ Berlaku hingga: {{expiry_date}}

Terima kasih,
PT Aisin Indonesia',
                'available_variables' => json_encode(['name', 'job_title', 'date', 'time', 'location', 'link', 'expiry_date']),
                'is_active' => true,
                'is_default' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Interview Invitation',
                'type' => 'both',
                'stage' => 'interview_invite',
                'email_subject' => 'Undangan Interview - {{job_title}}',
                'email_body' => '<html><body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
                    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
                        <h2 style="color: #0066cc;">PT Aisin Indonesia</h2>
                        <p>Yth. <strong>{{name}}</strong>,</p>
                        <p>Selamat! Anda telah lolos tahap psikotes untuk posisi <strong>{{job_title}}</strong>.</p>
                        <p>Kami mengundang Anda untuk interview dengan detail sebagai berikut:</p>
                        <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
                            <tr><td style="padding: 8px; border-bottom: 1px solid #ddd;"><strong>Tanggal:</strong></td><td style="padding: 8px; border-bottom: 1px solid #ddd;">{{date}}</td></tr>
                            <tr><td style="padding: 8px; border-bottom: 1px solid #ddd;"><strong>Waktu:</strong></td><td style="padding: 8px; border-bottom: 1px solid #ddd;">{{time}}</td></tr>
                            <tr><td style="padding: 8px; border-bottom: 1px solid #ddd;"><strong>Mode:</strong></td><td style="padding: 8px; border-bottom: 1px solid #ddd;">{{mode}}</td></tr>
                            <tr><td style="padding: 8px; border-bottom: 1px solid #ddd;"><strong>Lokasi/Link:</strong></td><td style="padding: 8px; border-bottom: 1px solid #ddd;">{{location}}</td></tr>
                            <tr><td style="padding: 8px; border-bottom: 1px solid #ddd;"><strong>Interviewer:</strong></td><td style="padding: 8px; border-bottom: 1px solid #ddd;">{{interviewer}}</td></tr>
                        </table>
                        <p><a href="{{confirmation_link}}" style="display: inline-block; padding: 12px 24px; background-color: #28a745; color: white; text-decoration: none; border-radius: 4px; margin-right: 10px;">Konfirmasi Kehadiran</a></p>
                        <p style="color: #666; font-size: 14px;">Mohon konfirmasi kehadiran Anda paling lambat H-1. File ICS terlampir untuk menambahkan ke kalender Anda.</p>
                        <p>Hormat kami,<br><strong>Tim Rekrutmen PT Aisin Indonesia</strong></p>
                    </div>
                </body></html>',
                'whatsapp_message' => 'Halo *{{name}}*, Selamat! Anda lolos tahap psikotes untuk posisi *{{job_title}}*.

Kami mengundang Anda untuk interview:
📅 Tanggal: {{date}}
🕐 Waktu: {{time}}
💻 Mode: {{mode}}
📍 Lokasi/Link: {{location}}
👤 Interviewer: {{interviewer}}

Mohon konfirmasi kehadiran: {{confirmation_link}}

Terima kasih,
PT Aisin Indonesia',
                'available_variables' => json_encode(['name', 'job_title', 'date', 'time', 'mode', 'location', 'interviewer', 'confirmation_link']),
                'is_active' => true,
                'is_default' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'MCU Invitation',
                'type' => 'both',
                'stage' => 'mcu_invite',
                'email_subject' => 'Undangan Medical Checkup - {{job_title}}',
                'email_body' => '<html><body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
                    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
                        <h2 style="color: #0066cc;">PT Aisin Indonesia</h2>
                        <p>Yth. <strong>{{name}}</strong>,</p>
                        <p>Selamat! Anda telah lolos tahap interview untuk posisi <strong>{{job_title}}</strong>.</p>
                        <p>Silakan melakukan Medical Checkup dengan detail sebagai berikut:</p>
                        <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
                            <tr><td style="padding: 8px; border-bottom: 1px solid #ddd;"><strong>Tanggal:</strong></td><td style="padding: 8px; border-bottom: 1px solid #ddd;">{{date}}</td></tr>
                            <tr><td style="padding: 8px; border-bottom: 1px solid #ddd;"><strong>Lokasi:</strong></td><td style="padding: 8px; border-bottom: 1px solid #ddd;">{{location}}</td></tr>
                            <tr><td style="padding: 8px; border-bottom: 1px solid #ddd;"><strong>Klinik:</strong></td><td style="padding: 8px; border-bottom: 1px solid #ddd;">{{clinic_name}}</td></tr>
                        </table>
                        <div style="background-color: #fff3cd; padding: 15px; border-left: 4px solid #ffc107; margin: 20px 0;">
                            <h4 style="margin-top: 0;">Syarat MCU:</h4>
                            <p style="margin-bottom: 0;">{{requirements}}</p>
                        </div>
                        <p>Hormat kami,<br><strong>Tim Rekrutmen PT Aisin Indonesia</strong></p>
                    </div>
                </body></html>',
                'whatsapp_message' => 'Halo *{{name}}*, Selamat! Anda lolos tahap interview untuk posisi *{{job_title}}*.

Silakan MCU:
📅 Tanggal: {{date}}
📍 Lokasi: {{location}}
🏥 Klinik: {{clinic_name}}

⚠️ Syarat MCU:
{{requirements}}

Terima kasih,
PT Aisin Indonesia',
                'available_variables' => json_encode(['name', 'job_title', 'date', 'location', 'clinic_name', 'requirements']),
                'is_active' => true,
                'is_default' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Offer Letter',
                'type' => 'email',
                'stage' => 'offer',
                'email_subject' => 'Offering Letter - {{job_title}}',
                'email_body' => '<html><body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
                    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
                        <h2 style="color: #0066cc;">PT Aisin Indonesia</h2>
                        <p>Yth. <strong>{{name}}</strong>,</p>
                        <p>Selamat! Kami dengan senang hati menawarkan posisi <strong>{{job_title}}</strong> kepada Anda di PT Aisin Indonesia.</p>
                        <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
                            <tr><td style="padding: 8px; border-bottom: 1px solid #ddd;"><strong>Posisi:</strong></td><td style="padding: 8px; border-bottom: 1px solid #ddd;">{{position}}</td></tr>
                            <tr><td style="padding: 8px; border-bottom: 1px solid #ddd;"><strong>Department:</strong></td><td style="padding: 8px; border-bottom: 1px solid #ddd;">{{department}}</td></tr>
                            <tr><td style="padding: 8px; border-bottom: 1px solid #ddd;"><strong>Gaji:</strong></td><td style="padding: 8px; border-bottom: 1px solid #ddd;">{{salary}}</td></tr>
                            <tr><td style="padding: 8px; border-bottom: 1px solid #ddd;"><strong>Tanggal Bergabung:</strong></td><td style="padding: 8px; border-bottom: 1px solid #ddd;">{{join_date}}</td></tr>
                            <tr><td style="padding: 8px; border-bottom: 1px solid #ddd;"><strong>Tanggal Briefing:</strong></td><td style="padding: 8px; border-bottom: 1px solid #ddd;">{{briefing_date}}</td></tr>
                        </table>
                        <p>Terlampir surat penawaran resmi. Mohon konfirmasi penerimaan Anda paling lambat {{deadline}}.</p>
                        <p>Kami menantikan kehadiran Anda di tim kami!</p>
                        <p>Hormat kami,<br><strong>Tim Rekrutmen PT Aisin Indonesia</strong></p>
                    </div>
                </body></html>',
                'whatsapp_message' => null,
                'available_variables' => json_encode(['name', 'job_title', 'position', 'department', 'salary', 'join_date', 'briefing_date', 'deadline']),
                'is_active' => true,
                'is_default' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Application Status Update',
                'type' => 'both',
                'stage' => 'status_update',
                'email_subject' => 'Update Status Lamaran - {{job_title}}',
                'email_body' => '<html><body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
                    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
                        <h2 style="color: #0066cc;">PT Aisin Indonesia</h2>
                        <p>Yth. <strong>{{name}}</strong>,</p>
                        <p>Status lamaran Anda untuk posisi <strong>{{job_title}}</strong> telah diupdate.</p>
                        <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
                            <tr><td style="padding: 8px; border-bottom: 1px solid #ddd;"><strong>Status Sebelumnya:</strong></td><td style="padding: 8px; border-bottom: 1px solid #ddd;">{{old_status}}</td></tr>
                            <tr><td style="padding: 8px; border-bottom: 1px solid #ddd;"><strong>Status Baru:</strong></td><td style="padding: 8px; border-bottom: 1px solid #ddd;">{{new_status}}</td></tr>
                        </table>
                        <p>{{message}}</p>
                        <p>Hormat kami,<br><strong>Tim Rekrutmen PT Aisin Indonesia</strong></p>
                    </div>
                </body></html>',
                'whatsapp_message' => 'Halo *{{name}}*, Status lamaran Anda untuk posisi *{{job_title}}* telah diupdate.

Status: {{old_status}} → {{new_status}}

{{message}}

Terima kasih,
PT Aisin Indonesia',
                'available_variables' => json_encode(['name', 'job_title', 'old_status', 'new_status', 'message']),
                'is_active' => true,
                'is_default' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Background Check Form',
                'type' => 'email',
                'stage' => 'background_check',
                'email_subject' => 'Formulir Background Check - {{applicant_name}}',
                'email_body' => '<html><body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
                    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
                        <h2 style="color: #0066cc;">PT Aisin Indonesia</h2>
                        <p>Yth. <strong>{{referee_name}}</strong>,</p>
                        <p>Kami sedang melakukan proses rekrutmen untuk posisi <strong>{{job_title}}</strong> dan <strong>{{applicant_name}}</strong> mencantumkan Anda sebagai referensi.</p>
                        <p>Mohon kesediaan Anda untuk mengisi formulir background check melalui link berikut:</p>
                        <p><a href="{{form_link}}" style="display: inline-block; padding: 12px 24px; background-color: #0066cc; color: white; text-decoration: none; border-radius: 4px;">Isi Formulir</a></p>
                        <p style="color: #666; font-size: 14px;">Link berlaku hingga: {{expiry_date}}</p>
                        <p>Informasi yang Anda berikan akan dijaga kerahasiaannya dan hanya digunakan untuk keperluan rekrutmen.</p>
                        <p>Terima kasih atas kerjasamanya.</p>
                        <p>Hormat kami,<br><strong>Tim Rekrutmen PT Aisin Indonesia</strong></p>
                    </div>
                </body></html>',
                'whatsapp_message' => null,
                'available_variables' => json_encode(['referee_name', 'applicant_name', 'job_title', 'form_link', 'expiry_date']),
                'is_active' => true,
                'is_default' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('notification_templates')->insert($templates);

        $this->command->info('Notification templates created successfully!');
        $this->command->info('Created ' . count($templates) . ' templates');
    }
}
