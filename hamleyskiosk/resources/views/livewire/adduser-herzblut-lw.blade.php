<div>
    <div class="flex justify-left pt-8 sm:pt-0">
        <h1 class="text-3xl font-semibold">Register New Customer</h1>
    </div>

    <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
        <div class="grid grid-cols-4">
            <div class="col-span-4 p-6">
                <form wire:submit.prevent="submit" method="POST">
                    <div class="grid grid-cols-6 gap-6">
                        @if ($user->is_admin)
                            <div class="col-span-6 sm:col-span-3">
                                <label for="store" class="block text-sm font-medium text-gray-700">Store</label>
                                <select wire:model="store_id" id="store" autocomplete="store-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md disabled:opacity-70">
                                    @foreach($stores as $store)
                                        <option value="{{ $store->id }}">{{ $store->name }}</option>
                                    @endforeach
                                </select>
                                @error('store') <span class="error">{{ $message }}</span> @enderror
                            </div>
                        @else
                            <div class="col-span-6 sm:col-span-3">
                                <label for="store" class="block text-sm font-medium text-gray-700">Store</label>
                                <input type="text" wire:model="store_name" id="store" autocomplete="store-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md disabled:opacity-70" disabled>
                                @error('store') <span class="error text-red-500">{{ $message }}</span> @enderror
                            </div>
                        @endif
                        <div class="col-span-6 sm:col-span-3">
                            <label for="storeConsultantName" class="block text-sm font-medium text-gray-700">Store Consultant</label>
                            <input type="text" wire:model="store_consultant_name" id="storeConsultantName" autocomplete="given-name" placeholder="Your name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @error('store_consultant_name') <span class="error text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label for="firstName" class="block text-sm font-medium text-gray-700">First name</label>
                            <input type="text" wire:model="first_name" id="firstName" autocomplete="first-name" placeholder="Customer's first name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @error('first_name') <span class="error text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label for="surname" class="block text-sm font-medium text-gray-700">Last Name</label>
                            <input type="text" wire:model="last_name" id="surname" autocomplete="surname" placeholder="Customer's surname" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @error('last_name') <span class="error text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                            <input type="text" wire:model="email" id="email" autocomplete="email" placeholder="info@example.com" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @error('email') <span class="error text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                            <label for="mobileNumber" class="block text-sm font-medium text-gray-700">Mobile Number (numbers only, no spaces)</label>
                            <input type="text" wire:model="mobile_number" id="mobileNumber" autocomplete="family-name" placeholder="0821231234" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @error('mobile_number') <span class="error text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="mt-6 px-4 py-3 sm:px-6">
                        <div class="bg-yellow-500 bg-opacity-10 border-0 rounded-md px-4 py-3 text-yellow-800">
                            <div class="flex">
                                <div class="text-yellow-500">
                                    <i class="fas fa-exclamation-triangle mr-4"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-left">Attention needed</p>
                                    <p class="text-sm my-2">
                                        Make sure you get the Customer's consent before registration.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 ">
                            Register Customer
                        </button>
                    </div>

                </form>

            </div>


        </div>
    </div>

</div>
