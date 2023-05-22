<div>
    <div class="flex justify-left pt-8 sm:pt-0">
        <h1 class="text-3xl font-semibold">Customer Details</h1>
    </div>
    <!-- Card -->
    <table class="mt-4 shadow overflow-hidden border-b border-gray-200 sm:rounded-lg w-full divide-y divide-gray-200 table-auto">
        <thead class="bg-gray-100">
        <tr>
            <th scope="col" class="px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                Code
            </th>
            <th scope="col" class="px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                Full Name
            </th>
            <th scope="col" class="px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                Mobile Number
            </th>
            <th scope="col" class="px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                Email
            </th>
            <th scope="col" class="px-3 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                Actions
            </th>
        </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200 border-collapse">
            <tr>
                <td class="px-3 py-2 whitespace-nowrap">
                    {{$customer_code}}
                </td>
                <td class="px-3 py-2">
                    {{ ucwords(strtolower($first_name)) }} {{ ucwords(strtolower($last_name)) }}
                </td>
                <td class="px-3 py-2 whitespace-nowrap">
                    {{$mobile_number}}
                </td>
                <td class="px-3 py-2 whitespace-nowrap">
                    {{ strtolower($email) }}
                </td>
                <td class="px-3 py-2 whitespace-nowrap text-left text-sm font-medium">
                    <a href="{{route('update_customer', ['customer_code' => $customer_code])}}" class="text-xs px-3 font-small text-base bg-red-500 text-white rounded-md py-1.5 hover:no-underline hover:bg-red-300">Edit</a>
                    <a href="{{route('redeem_gifts', ['customer_code' => $customer_code])}}" class="text-xs px-2 font-small text-base bg-indigo-500 text-white rounded-md py-1.5 hover:no-underline hover:bg-indigo-300">Gifts</a>
                </td>
            </tr>
        </tbody>
    </table>
    <!-- Card -->
    <div class="flex justify-left mt-8 pt-8 sm:pt-0">
        <h1 class="text-3xl font-semibold">Print Cards</h1>
    </div>
    <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
        <div class="grid grid-cols-4">
            <div class="col-span-2 p-6">
                <div class="justify-left sm:pt-0 bg-gray-50">
                    <h3 class="text-lg font-semibold p-2">Add Children</h3>
                </div>
                <form wire:submit.prevent="submit" method="POST">
                    <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-3">
                            <label for="name" class="block text-sm font-medium text-gray-700">Child's First Name</label>
                            <input type="text" wire:model="name" id="name" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @error('name') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label for="dob" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                            <input type="date" wire:model="dob" id="dob" autocomplete="first-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            @error('dob') <span class="error">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-span-6 sm:col-span-6">
                            <label class="inline-flex items-center">
                                <input type="checkbox" id="terms" wire:model="terms" class="form-checkbox" checked/>
                                <span class="ml-2">By signing up to the Hamleys Club you consent to receiving marketing communication.</span>
                            </label>
                            @error('terms') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="mt-6 px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" {{ (count($children) >= 5) ? 'disabled="disabled"' : '' }}>
                            Add Child
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-span-2 p-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Name
                        </th>
                        <th scope="col" class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            DOB
                        </th>
                        <th scope="col" class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>

                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($children as $index => $child)
                        <tr>
                            <td class="px-2 py-3 whitespace-nowrap">
                                <span>{{ $child['name']  }}</span>
                            </td>
                            <td class="px-2 py-3 whitespace-nowrap">
                                <span>{{ $child['dob']  }}</span>
                            </td>
                            <td class="px-2 py-3 whitespace-nowrap text-sm font-medium">
                                <a href="#" wire:click="$emit('printCard','{{$customer_code}}','{{ $child['name']  }}', '{{ $index }}')" class="text-xs px-3 font-small text-base bg-green-500 text-white rounded-md py-1.5 hover:no-underline hover:bg-green-300" data-code="{{$customer_code}}" data-name="{{ $child['name']  }}" data-dob="{{ $child['dob']  }}">Print</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
