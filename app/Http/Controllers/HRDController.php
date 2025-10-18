<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HRDController extends Controller
{
    /**
     * Display the HRD dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        // Sample data - replace with actual database queries
        $data = [
            'totalKaryawan' => 248,
            'hadirHariIni' => 235,
            'cutiPending' => 8,
            'rekrutmenAktif' => 5,
        ];
        
        return view('hrd.dashboard', $data);
    }
    
    /**
     * Display employee list.
     *
     * @return \Illuminate\View\View
     */
    public function karyawan()
    {
        // TODO: Implement employee list
        return view('hrd.karyawan');
    }
    
    /**
     * Display attendance records.
     *
     * @return \Illuminate\View\View
     */
    public function absensi()
    {
        // TODO: Implement attendance records
        return view('hrd.absensi');
    }
    
    /**
     * Display leave requests.
     *
     * @return \Illuminate\View\View
     */
    public function cuti()
    {
        // TODO: Implement leave requests
        return view('hrd.cuti');
    }
    
    /**
     * Display payroll information.
     *
     * @return \Illuminate\View\View
     */
    public function penggajian()
    {
        // TODO: Implement payroll
        return view('hrd.penggajian');
    }
    
    /**
     * Display recruitment section.
     *
     * @return \Illuminate\View\View
     */
    public function rekrutmen()
    {
        // TODO: Implement recruitment
        return view('hrd.rekrutmen');
    }
    
    /**
     * Display reports.
     *
     * @return \Illuminate\View\View
     */
    public function laporan()
    {
        // TODO: Implement reports
        return view('hrd.laporan');
    }
}
