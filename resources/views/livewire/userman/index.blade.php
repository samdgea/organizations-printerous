<x-slot name="header">
    <h2 class="text-center">User Management</h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            @if (session()->has('message'))
                <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3"
                     role="alert">
                    <div class="flex">
                        <div>
                            <p class="text-sm">{{ session('message') }}</p>
                        </div>
                    </div>
                </div>
            @endif
            <button wire:click="create()"
                    class="bg-green-700 text-white font-bold py-2 px-4 rounded my-3">Create User</button>
            @if($isModalOpen)
                @include('livewire.userman.form')
            @endif
            <table class="table-fixed w-full">
                <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 w-20">No.</th>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Phone Number</th>
                    <th class="px-4 py-2" style="width: 200px;">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($persons as $id => $person)
                    <tr>
                        <td class="border px-4 py-2">{{ $id+1 }}</td>
                        <td class="border px-4 py-2">{{ $person->name }}</td>
                        <td class="border px-4 py-2">{{ $person->email }}</td>
                        <td class="border px-4 py-2">{{ $person->phone_number }}</td>
                        <td class="border px-4 py-2 text-center">
                            <button wire:click="edit({{ $person->id }})"
                                    class="bg-blue-500  text-white font-bold py-2 px-4 rounded">Edit</button>
                            <button wire:click="delete({{ $person->id }})"
                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
