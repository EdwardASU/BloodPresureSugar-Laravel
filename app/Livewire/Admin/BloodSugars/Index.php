<?php

namespace App\Livewire\Admin\BloodSugars;

use App\Models\BloodSugar;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('admin.layouts.app')]
class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function delete(BloodSugar $record)
    {
        $record->delete();
        session()->flash('success', 'Blood sugar record deleted.');
    }

    public function render()
    {
        $records = BloodSugar::with('user')
            ->when($this->search, function ($q) {
                $q->whereHas('user', fn($u) => $u->where('name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%"));
            })
            ->latest('recorded_at')
            ->paginate(15);

        return view('livewire.admin.blood-sugars.index', compact('records'));
    }
}
