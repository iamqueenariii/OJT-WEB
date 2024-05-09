<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Offices') }}
    </h2>
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
                    class="bg-blue-900 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3">Create New Offices
            </button>

            <input wire:model="searchToken" id="searchToken" wire:keyup="change"
                   class="border-2 rounded-lg border-yellow-900 text-black-700 mr-3 py-1 px-2 leading-tight focus:outline-none"
                   type="text" placeholder="Search Office here...">

            @if($isOpen)
                @include('livewire.offices.create')
            @endif

            <table class="table-fixed w-full">
                <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 w-20">ID</th>
                    <th class="px-4 py-2 text-center">Office Name</th>
                    <th class="px-4 py-2 text-center">Office Head</th>
                    <th class="px-4 py-2 text-center">Position</th>
                    <th width="230px" class="px-4 py-2">Action</th>
                </tr>
                </thead>
                <tbody>
                    @php
                        $count = 1;
                    @endphp
                @foreach($offices as $office)
                    <tr>
                        <td class="border px-4 py-2 text-center">{{ $count++}}</td>
                        <td class="border px-4 py-2 text-center">{{ $office->name }}</td>
                        <td class="border px-4 py-2 text-center">{{ $office->office_head }}</td>
                        <td class="border px-4 py-2 text-center">{{ $office->position }}</td>
                        <td class="border px-4 py-2 text-center">
                            <button wire:click="edit({{ $office->id }})"
                                    class="bg-blue-900 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded">Edit
                            </button>

                            @if($confirming===$office->id)
                                <button wire:click="kill({{ $office->id }})"
                                        class="bg-red-600 text-white w-32 px-4 py-1 hover:bg-red-500 rounded border">
                                    Sure?
                                </button>
                            @else
                                <button wire:click="confirmDelete({{ $office->id }})"
                                        class="bg-red-600 text-white w-32 px-4 py-1 hover:bg-red-500 rounded border">
                                    Delete
                                </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
