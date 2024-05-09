<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reports') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="max-w-7xl mx-auto">
            <div
                class="bg-blue-900 overflow-hidden shadow-xl sm:rounded-lg px-3 py-3 text-center font-semibold text-white text-xl">
                GENERATE REPORT
            </div>
            <br>

            <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown"
                class="text-white bg-blue-900 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                type="button">Select Here <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 4 4 4-4" />
                </svg>
            </button>

            <!-- Dropdown menu -->
            <div id="dropdown"
                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                    <li>
                        <button wire:click="setOfficeSchool"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Office</a>
                    </li>
                    <li>
                        <button wire:click="setTableSchool"
                            class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">School</button>
                    </li>
            </div>

        </div>
    </div>

    <div>
        <div class="max-w-7xl mx-auto">

            @if ($showSchoolTable)
            <div class="flex gap-3">
                <select id="school_id" wire:model="school_id" wire:change="FilterApplicantsBySchool"
            class="block appearance-none w-full bg-white border border-blue-700 hover:border-blue-700 hover:bg-blue-700 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                <option>Select...</option>
                @foreach ($schools as $school)
                    <option value="{{ $school->id }}">{{ $school->name }}</option>
                @endforeach
            </select>
            <a href="{{ route('print-school', ['school_id' => $school_id ?? 0]) }}" target="_blank" type="button" class="text-blue-700 border border-blue-700 hover:bg-blue-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:focus:ring-blue-800 dark:hover:bg-blue-500">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                  </svg>

                <span class="sr-only">Icon description</span>
            </a>
            </div>
            <br>
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead>
                            <tr>
                                <th scope="col" class="px-4 py-3 bg-blue-900 text-white border px-4 py-4">
                                    Full Name
                                </th>
                                <th scope="col" class="px-4 py-3 bg-blue-900 text-white border px-4 py-4">
                                    Birthday
                                </th>
                                <th scope="col" class="px-4 py-3 bg-blue-900 text-white border px-4 py-4">
                                    Address
                                </th>
                                <th scope="col" class="px-4 py-3 bg-blue-900 text-white border px-4 py-4">
                                    School
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($applicants as $applicant)
                                <tr wire:key="{{ $applicant->id }}"
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row" class="text-left px-6 py-4 font-medium whitespace-nowrap">
                                        {{ $applicant->fullname() }}
                                    </th>
                                    <td class="px-4 py-4 text-center">
                                        {{ date('F d, Y', strtotime($applicant->bday)) }}
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        {{ $applicant->address }}
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        {{ $applicant->school ?->name }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
    <div>
        <div class="max-w-7xl mx-auto">
            @if ($showOfficeTable)
            <div class="flex gap-3">
                <select id="office_id" wire:model="office_id" wire:change="FilterApplicantsByOffice"
                class="w-full block appearance-none bg-white border border-blue-700 hover:border-blue-700 hover:bg-blue-700 hover:text-white px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                <option>Select...</option>
                @foreach ($offices as $office)
                    <option value="{{ $office->id }}">{{ $office->name }}</option>
                @endforeach
                </select>
                <a href="{{ route('print-office', ['office_id' => $office_id ?? 0]) }}" target="_blank" type="button" class="text-blue-700 border border-blue-700 hover:bg-blue-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:focus:ring-blue-800 dark:hover:bg-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                      </svg>

                    <span class="sr-only">Icon description</span>
                </a>
            </div>

                <br>
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-3 bg-blue-900 text-white border px-6 py-4">
                                    Assigned Office
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-center bg-blue-900 text-white border px-6 py-4">
                                    On-The-Job Trainee
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($offices_table as $office)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="text-center border px-6 py-4">
                                        {{ $office->name }}
                                        <br>
                                        Total On-The-Job Trainees: {{ $office->applicants->count() }}
                                    </td>
                                    <td>
                                        <ul>
                                            @foreach ($office->applicants as $applicant)
                                                <li class="text-center px-4 py-2">{{ $applicant->fullname() }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
