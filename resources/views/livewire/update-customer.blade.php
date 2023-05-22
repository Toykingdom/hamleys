<div>
    <div class="flex justify-left sm:pt-0">
        <h1 class="text-3xl font-semibold">Update Customer Details</h1>
    </div>

    <div class="mt-4 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
        <div class="grid grid-cols-4">
            <div class="col-span-4 p-6">
                <form wire:submit.prevent="submit" method="POST">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-6">
                            <label for="account_code" class="block text-sm font-medium text-gray-700">Account Code</label>
                            <input type="text" wire:model="account_number" id="account_code" autocomplete="account_code" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md disabled:opacity-70" disabled>
                            @error('account_code') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label for="firstName" class="block text-sm font-medium text-gray-700">First name</label>
                            <input type="text" wire:model="first_name" id="firstName" autocomplete="first-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @error('first_name') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label for="surname" class="block text-sm font-medium text-gray-700">Last Name</label>
                            <input type="text" wire:model="last_name" id="surname" autocomplete="surname" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @error('last_name') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                            <input type="text" wire:model="email" id="email" autocomplete="email" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @error('email') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                            <label for="mobileNumber" class="block text-sm font-medium text-gray-700">Mobile Number</label>
                            <input type="text" wire:model="mobile_number" id="mobileNumber" autocomplete="family-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @error('mobile_number') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-6">
                            <label for="store" class="block text-sm font-medium text-gray-700">Store</label>
                            <input type="text" wire:model="store_name" id="store" autocomplete="store-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md disabled:opacity-70" disabled>
                            @error('store') <span class="error">{{ $message }}</span> @enderror
                        </div>

                    </div>
                    <div class="mt-6 px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Save and Close
                        </button>
                        <button wire:click="save_and_print" value="1" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Save and Print Cards
                        </button>
                    </div>

                </form>

            </div>


        </div>
    </div>

</div>
