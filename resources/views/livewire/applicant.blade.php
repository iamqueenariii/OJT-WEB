<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Applicant') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-4">
            <div class="bg-white overflow-x-auto shadow-xl sm:rounded-lg px-4 py-4">
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
                    class="bg-blue-900 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3">Create New Student Intern
                </button>

                <input wire:model.live="searchToken" id="searchToken"
                    class="border-2 rounded-lg border-yellow-900 text-black-700 mr-3 py-1 px-2 leading-tight focus:outline-none"
                    type="text" placeholder="Search Name here...">

                    <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown"
                    class="text-white bg-blue-900 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    type="button">Select Year <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 4 4 4-4" />
                    </svg>
                </button>

                <!-- Dropdown menu -->
                <div id="dropdown"
                    class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                        @foreach ($years as $year)
                        <li>
                            <button wire:click="setYearCreated({{$year}})"
                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white w-full text-left">{{$year}}</button>
                        </li>
                        @endforeach

                    </ul>
                </div>

                @if ($isOpen)
                    @include('livewire.applicant.create')
                @endif
                @include('livewire.applicant.create-certificate-modal')

                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 w-20">No.</th>
                            <th class="px-4 py-2">Last Name</th>
                            <th class="px-4 py-2">First Name</th>
                            <th class="px-4 py-2">Middle Name</th>
                            <th class="px-4 py-2">Birthday</th>
                            <th class="px-4 py-2">Date Started</th>
                            <th class="px-4 py-2">No. of Hours</th>
                            <th class="px-4 py-2">School</th>
                            <th class="px-4 py-2">Office</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Type</th>
                            <th width="230px" class="px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $count = 1;
                        @endphp
                        @foreach ($applicants as $applicant)
                            <tr>
                                <td class="border px-4 py-2 text-center">{{ $count++ }}</td>
                                <td class="border px-4 py-2 text-center">{{ $applicant->lname }}</td>
                                <td class="border px-4 py-2 text-center">{{ $applicant->fname }}</td>
                                <td class="border px-4 py-2 text-center">{{ $applicant->mname }}</td>
                                <td class="border px-4 py-2 text-center">{{ $applicant->bday }}</td>
                                <td class="border px-4 py-2 text-center">{{ $applicant->started_date }}</td>
                                <td class="border px-4 py-2 text-center">{{ $applicant->hrs }}</td>
                                <td class="border px-4 py-2 text-center">{{ $applicant->school ?->name }}</td>
                                <td class="border px-4 py-2 text-center">
                                    @if ($applicant->office)
                                        {{ $applicant->office->name }}
                                    @endif

                                </td>
                                <td class="border px-4 py-2 text-center"><button wire:click="toggleStatus({{$applicant->id}})" wire:confirm="Are you sure?" class="{{ $applicant->status ? 'bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300' : 'bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300' }}">{{ $applicant->status ? 'completed' : 'on-going' }}</button></td>
                                <td class="border px-4 py-2 text-center">{{ $applicant->type}}</td>

                                <td class="border px-4 py-2 text-center">
                                    <button wire:click="edit({{ $applicant->id }})"
                                        class="bg-blue-900 justify-center text-white w-32 px-4 py-1 hover:bg-blue-700 rounded border">Edit
                                    </button>

                                    @if ($confirming === $applicant->id)
                                        <button wire:click="kill({{ $applicant->id }})"
                                            class="bg-red-600 justify-center text-white w-32 px-4 py-1 hover:bg-red-500 rounded border">
                                            Sure?
                                        </button>
                                    @else
                                        <button wire:click="confirmDelete({{ $applicant->id }})"
                                            class="bg-red-600 justify-center text-white w-32 px-4 py-1 hover:bg-red-500 rounded border">
                                            Delete
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $applicants->links() }}
            </div>
        </div>
    </div>
</div>
