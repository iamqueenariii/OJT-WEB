<x-dialog-modal wire:model="certModal" maxWidth="lg">
    <x-slot name="title"><h2>Add Necessary Details </h2></x-slot>

    <x-slot name="content">
        <form>
            <div class="mb-4">
                <label for="exampleFormControlInput1"
                       class="block text-gray-700 text-sm font-bold mb-2">Date Finished</label>

                <input type="date"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       id="exampleFormControlInput1" placeholder="Type Here..." wire:model.lazy="dateFinished">
                @error('dateFinished') <span class="text-red-500">{{ $message }}</span>@enderror
            </div>

            <div class="mb-4">
                <label for="exampleFormControlInput1"
                       class="block text-gray-700 text-sm font-bold mb-2">Date Issued</label>

                <input type="date"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       id="exampleFormControlInput1" placeholder="Type Here..." wire:model.lazy="dateIssued">
                @error('dateIssued') <span class="text-red-500">{{ $message }}</span>@enderror
            </div>
        </form>

    </x-slot>

    <x-slot name="footer">

        <div class="sm:flex sm:flex-row-reverse">
            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                <button wire:click.prevent="storeCert()" type="button"
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

