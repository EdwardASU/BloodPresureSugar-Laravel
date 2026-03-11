<?php

namespace App\Livewire\Admin;

use App\Models\BloodPressure;
use App\Models\BloodSugar;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('admin.layouts.app')]
class Dashboard extends Component
{
    public function render()
    {
        $stats = [
            'total_users'           => User::where('role', 'user')->count(),
            'total_blood_sugars'    => BloodSugar::count(),
            'total_blood_pressures' => BloodPressure::count(),
            'recent_blood_sugars'   => BloodSugar::with('user')->latest('recorded_at')->take(5)->get(),
            'recent_blood_pressures'=> BloodPressure::with('user')->latest('recorded_at')->take(5)->get(),
        ];

        return view('livewire.admin.dashboard', compact('stats'));
    }
}
