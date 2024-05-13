<div>
    <div>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Certificates') }}
            </h2>
        </x-slot>
        @include('livewire.certificate.cert-edit')
        <div class="py-5">
            <div class="max-w-7xl mx-auto">
                <div
                    class="bg-blue-900 overflow-hidden shadow-xl sm:rounded-lg px-3 py-3 text-center font-semibold text-white text-xl">
                    CERTIFICATE OF COMPLETION
                </div>
                <br>

                <button wire:click="print()"
                    class="bg-blue-900 hover:bg-blue-700 text-white font-bold py-1 px-1 rounded my-3"> PRINT
                </button>
                <button wire:click="saveCertificates()"
                    class="bg-green-600 text-white font-bold py-1 px-1 rounded my-3"> SAVE
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
                            <button wire:click="setYear({{$year}})"
                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white w-full text-left">{{$year}}</button>
                        </li>
                        @endforeach

                    </ul>
                </div>

                <div class="flex items-center">
                    <input id="link-checkbox" type="checkbox" wire:model.live="selectAll"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="link-checkbox" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">SELECT
                        ALL </label>
                </div>
            </div>

            <div class="relative overflow-x-auto">
                <table class="w-full text-sm rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" colspan="2" class="px-4 py-3 bg-blue-900 text-white border px-6 py-4">
                                Full Name
                            </th>
                            <th scope="col" class="px-4 py-3 text-center bg-blue-900 text-white border px-6 py-4">
                                Office
                            </th>
                            <th scope="col" class="px-4 py-3 text-center bg-blue-900 text-white border px-6 py-4">
                                Type
                            </th>
                            <th scope="col" class="px-4 py-3 text-center bg-blue-900 text-white border px-6 py-4">
                                No. of Hours
                            </th>
                            <th scope="col" class="px-4 py-3 text-center bg-blue-900 text-white border px-6 py-4">
                                Date Finished
                            </th>
                            <th scope="col" class="px-4 py-3 text-center bg-blue-900 text-white border px-6 py-4">
                                Date Issued
                            </th>
                            <th scope="col" class="px-4 py-3 text-center bg-blue-900 text-white border px-6 py-4">
                                Action
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($certificates as $certificate)
                            <tr>
                                <td class="border px-4 py-2 text-center">
                                    <input wire:model.live="selected_cert.{{ $certificate->id }}" id="yellow-checkbox"
                                        type="checkbox" value=""
                                        class="w-4 h-4 text-yellow-400 bg-gray-100 border-gray-300 rounded focus:ring-yellow-500 dark:focus:ring-yellow-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                </td>
                                <td class="border px-4 py-2 text-center">{{ $certificate->fullname }}</td>
                                <td class="border px-4 py-2 text-center">{{ $certificate->office_name }}</td>
                                <td class="border px-4 py-2 text-center">{{ $certificate->type }}</td>
                                <td class="border px-4 py-2 text-center">{{ $certificate->hrs }}</td>
                                <td class="border px-4 py-2 text-center">{{ $certificate->dateFinished }}</td>
                                <td class="border px-4 py-2 text-center">{{ $certificate->dateIssued }}</td>
                                <td class="border px-4 py-2 text-center">
                                    <button wire:click="edit('{{ $certificate->id }}')"
                                        class="bg-blue-900 hover:bg-blue-700 text-white  w-23 font-bold py-1 px-2 rounded">Edit</button>
                                    <button wire:click="delete({{ $certificate->id }})"
                                        wire:confirm="Are you sure you want to delete?"
                                        class="bg-red-600 text-white w-23 px-2 py-1 hover:bg-red-500 rounded border">
                                        Delete
                                    </button>
                                    <a href="{{ route('print-certificate', ['certificate_id' => $certificate->id]) }}"
                                        class="bg-blue-900 hover:bg-blue-700 text-white  w-23 font-bold py-1 px-2 rounded">Print</a>
                                    <button wire:click="saveCertificate({{ $certificate->id }})"
                                            wire:confirm="Are you sure you want to download this Certificate?"
                                            class="bg-green-600 text-white w-23 px-2 py-1 hover:bg-green-500 rounded border">
                                        Save
                                    </button>

                                </td>

                            </tr>
                        @endforeach
                    </tbody>


                </table>
            </div>
        </div>
    </div>
</div>
