<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('admin.layouts.app')]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $role = '';

    // Modal state
    public $showModal = false;
    public $editingId = null;

    // Form fields
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $userRole = 'user';

    protected function rules()
    {
        $rules = [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email' . ($this->editingId ? ',' . $this->editingId : '')],
            'userRole' => ['required', 'in:admin,user'],
        ];

        if (!$this->editingId || $this->password) {
            $rules['password'] = ['required', 'confirmed', Password::defaults()];
        }

        return $rules;
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedRole()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->resetValidation();
        $this->reset(['editingId', 'name', 'email', 'password', 'password_confirmation']);
        $this->userRole = 'user';
        $this->showModal = true;
    }

    public function edit(User $user)
    {
        $this->resetValidation();
        $this->editingId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->userRole = $user->role;
        $this->reset(['password', 'password_confirmation']);
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name'  => $this->name,
            'email' => $this->email,
            'role'  => $this->userRole,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        User::updateOrCreate(['id' => $this->editingId], $data);

        $this->showModal = false;
        session()->flash('success', $this->editingId ? 'User updated successfully.' : 'User created successfully.');
    }

    public function delete(User $user)
    {
        $user->delete();
        session()->flash('success', 'User deleted.');
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%")
                ->orWhere('email', 'like', "%{$this->search}%"))
            ->when($this->role, fn($q) => $q->where('role', $this->role))
            ->latest()
            ->paginate(15);

        return view('livewire.admin.users.index', compact('users'));
    }
}
