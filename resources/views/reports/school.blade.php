<x-print-layout>
    {{-- <div class="flex"> --}}
        <img src="{{asset('img/OJTlogo.jpg')}}" alt="App Logo" class="h-16 absolute"/>
        <div class="w-full text-center font-bold">
            <h1> OJT Web</h1>
        <h1> List of On-the-Job Trainees per School</h1>
        </div>
<br>
    {{-- </div> --}}
    <table class="w-full text-sm rtl:text-right text-gray-500 dark:text-gray-400">
        @foreach ($schools as $school)
            @if ($school->applicants->count()== 0)
                @continue
            @endif
            <thead>

                <tr class="bg-blue-900 text-white text-bold">
                    <th class="px-4 py-3 " colspan="3">{{ $school->name }}</th>
                </tr>
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
                </tr>
            </thead>
            <tbody>
                @foreach ($school->applicants as $applicant)
                    <tr wire:key="{{ $applicant->id }}" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="text-center px-6 py-4 font-medium whitespace-nowrap">
                            {{ $applicant->fullname() }}
                        </th>
                        <td class="px-4 py-4 text-center">
                            {{ date('F d, Y', strtotime($applicant->bday)) }}
                        </td>
                        <td class="px-4 py-4 text-center">
                            {{ $applicant->address }}
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td><br>
                    </td>
                </tr>

            </tbody>
        @endforeach

    </table>
</x-print-layout>
