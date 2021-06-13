<?php

namespace App\Http\Livewire;

use App\Http\Middleware\PreventRequestsDuringMaintenance;
use App\Models\Organization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class OrganizationManagement extends Component
{
    use WithPagination, WithFileUploads;

    public $org_id, $name, $phone, $email, $website, $org_logo, $uploadImage;
    public $isModalOpen;

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $organizations = Organization::paginate(5);

        return view('livewire.organization.index', compact('organizations'));
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
        $this->org_id = null;
        $this->name = null;
        $this->email = null;
        $this->website = null;
        $this->phone = null;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'website' => 'nullable|string',
            'phone' => 'nullable|numeric',
            'uploadImage' => 'nullable|image|mimes:jpg,jpeg,png,svg,gif|max:2048'
        ]);

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'website' => $this->website
        ];

        if (!empty($this->uploadImage)) {
            if (!empty($this->org_logo) && File::exists($this->org_logo)) File::delete($this->org_logo);
            $data['org_logo'] = $this->uploadImage->store('organizations');
        }

        Organization::updateOrCreate(['id' => $this->org_id], $data);

        session()->flash('message', $this->org_id ? 'Organization updated.' : 'Organization created.');

        $this->closeModal();
        $this->resetForm();
    }

    public function edit($id)
    {
        if (Auth::user()->hasRole('super-admin') (Auth::user()->hasRole('account-manager') && $id == Auth::user()->organization_id)) {
            $user = Organization::findOrFail($id);
            $this->org_id = $user->id;
            $this->name = $user->name;
            $this->email = $user->email;
            $this->phone = $user->phone;
            $this->website = $user->website;
            $this->org_logo = $user->org_logo;

            $this->openModal();
        } else {
            session()->flash('message', 'You have no permission to do that!');
        }
    }

    public function delete($id)
    {
        if (Auth::user()->hasRole('super-admin') (Auth::user()->hasRole('account-manager') && $id == Auth::user()->organization_id)) {
            Organization::find($id)->delete();
            session()->flash('message', 'Organization deleted!');
        } else {
            session()->flash('message', 'You have no permission to do that!');
        }
    }
}
