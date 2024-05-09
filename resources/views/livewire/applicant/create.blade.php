<x-dialog-modal maxWidth="lg">
    <x-slot name="title"><h2>Add On-the-Job Trainee </h2></x-slot>

    <x-slot name="content">
        <form>
            <div class="mb-4">
                <label for="exampleFormControlInput1"
                       class="block text-gray-700 text-sm font-bold mb-2">Lastname</label>

                <input type="text"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       id="exampleFormControlInput1" placeholder="Type Here..." wire:model.lazy="lname">
                @error('lname') <span class="text-red-500">{{ $message }}</span>@enderror
            </div>

            <div class="mb-4">
                <label for="exampleFormControlInput1"
                       class="block text-gray-700 text-sm font-bold mb-2">Firstname</label>

                <input type="text"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       id="exampleFormControlInput1" placeholder="Type Here..." wire:model.lazy="fname">
                @error('fname') <span class="text-red-500">{{ $message }}</span>@enderror
            </div>

            <div class="mb-4">
                <label for="exampleFormControlInput1"
                       class="block text-gray-700 text-sm font-bold mb-2">Middlename</label>

                <input type="text"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       id="exampleFormControlInput1" placeholder="Type Here..." wire:model.lazy="mname">
                @error('mname') <span class="text-red-500">{{ $message }}</span>@enderror
            </div>

            <div class="mb-4">
                <label for="exampleFormControlInput1"
                       class="block text-gray-700 text-sm font-bold mb-2">Address</label>

                <input type="text"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       id="exampleFormControlInput1" placeholder="Type Here..." wire:model.lazy="address">
                @error('address') <span class="text-red-500">{{ $message }}</span>@enderror
            </div>

            <div class="mb-4">
                <label for="exampleFormControlInput1"
                       class="block text-gray-700 text-sm font-bold mb-2">Birthday</label>

                <input type="date"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       id="exampleFormControlInput1" wire:model.lazy="bday">
                @error('bday') <span class="text-red-500">{{ $message }}</span>@enderror
            </div>

            <div class="mb-4">
                <label for="exampleFormControlInput1"
                       class="block text-gray-700 text-sm font-bold mb-2">Date Started</label>

                <input type="date"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       id="exampleFormControlInput1" wire:model.lazy="started_date">
                @error('started_date') <span class="text-red-500">{{ $message }}</span>@enderror
            </div>

            <div class="mb-4">
                <label for="exampleFormControlInput1"
                       class="block text-gray-700 text-sm font-bold mb-2">No. of Hours</label>

                <input type="float"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       id="exampleFormControlInput1" wire:model.lazy="hrs">
                @error('hrs') <span class="text-red-500">{{ $message }}</span>@enderror
            </div>

            <div class="mb-4">
                <label for="school_id" class="block text-gray-700 text-sm font-bold mb-2">School</label>

                <select id="school_id" wire:model="school_id"
                        class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">Select...</option>
                @foreach($schools as $school)
                    <option value="{{$school->id}}">{{$school->name}}</option>
                @endforeach

                </select>
                @error('school_id') <span class="text-red-500">{{ $message }}</span>@enderror
            </div>

            <div class="mb-4">
                <label for="office_id" class="block text-gray-700 text-sm font-bold mb-2">Office</label>

                <select id="office_id" wire:model="office_id"
                        class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">Select...</option>
                @foreach($offices as $office)
                    <option value="{{$office->id}}">{{$office->name}}</option>
                @endforeach

                </select>
                @error('office_id') <span class="text-red-500">{{ $message }}</span>@enderror
            </div>

            <div class="mb-4">
                <label for="type" class="block text-gray-700 text-sm font-bold mb-2">Type</label>

                <select id="type" wire:model="type"
                        class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">Select...</option>
                    <option value="Work Immersion Program">Work Immersion Program</option>
                    <option value="Internship Program">Internship Program</option>
                </select>
                @error('type') <span class="text-red-500">{{ $message }}</span>@enderror
            </div>

        </form>


    </x-slot>

    <x-slot name="footer">

        <div class="sm:flex sm:flex-row-reverse">
            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                <button wire:click.prevent="store()" type="button"
                        class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-red-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                    Save
                </button>
            </span>

            <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                <button wire:click="closeModal()" type="button"
                        class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                    Cancel
                </button>
            </span>
        </div>

    </x-slot>

</x-dialog-modal>

