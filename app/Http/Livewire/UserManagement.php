<?php

namespace App\Http\Livewire;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class UserManagement extends Component
{
    use WithPagination;

    public $user_id, $name, $email, $phone_number, $organization_id;
    public $isModalOpen;

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $persons = User::paginate(5);
        $organizations = Organization::get()->pluck('name', 'id');
        return view('livewire.userman.index', compact('persons', 'organizations'));
    }

    public function create()
    {
        $this->resetForm();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    public function resetForm()
    {
        $this->user_id = null;
        $this->name = null;
        $this->email = null;
        $this->phone_number = null;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone_number' => 'nullable|numeric'
        ]);

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number
        ];

        if (empty($this->user_id)) $data['password'] = Hash::make('password');

        User::updateOrCreate(['id' => $this->user_id], $data);

        session()->flash('message', $this->user_id ? 'User updated.' : 'User created.');

        $this->closeModal();
        $this->resetForm();
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->user_id = $user->id;
        $this->organization_id = $user->organization_id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone_number = $user->phone_number;

        $this->openModal();
    }

    public function delete($id)
    {
        User::find($id)->delete();
        session()->flash('message', 'User deleted.');
    }
}
