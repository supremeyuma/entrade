<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">KYC Verification</h2>
    </x-slot>

    <div class="max-w-3xl mx-auto p-6 bg-white rounded-xl shadow-md">

        {{-- Success Message --}}
        @if(session('kyc_success'))
            <div class="mb-4 p-4 text-green-800 bg-green-100 border border-green-300 rounded-lg">
                {{ session('kyc_success') }}
            </div>
        @endif

        {{-- Error Message --}}
        @if($errors->any())
            <div class="mb-4 p-4 text-red-800 bg-red-100 border border-red-300 rounded-lg">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Main KYC Form --}}
        <form method="POST" action="{{ route('kyc.store') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div>
                <x-label for="phone" value="Phone Number" class="font-medium text-gray-700" />
                <x-input id="phone" name="phone" type="text" class="w-full mt-1" required />
            </div>

            <div>
                <x-label for="country" value="Country" class="font-medium text-gray-700" />
                <x-input id="country" name="country" type="text" class="w-full mt-1" required />
            </div>

            <div>
                <x-label for="address" value="Address" class="font-medium text-gray-700" />
                <x-input id="address" name="address" type="text" class="w-full mt-1" required />
            </div>

            <div>
                <x-label for="identification_type" value="Identification Type" class="font-medium text-gray-700" />
                <select name="identification_type" id="identification_type" 
                        class="w-full border-gray-300 rounded-lg shadow-sm mt-1 focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                    <option value="National ID">National ID</option>
                    <option value="Driver's License">Driver's License</option>
                    <option value="Voter's Card">Voter's Card</option>
                </select>
            </div>

            <div>
                <x-label for="identification_number" value="Identification Number" class="font-medium text-gray-700" />
                <x-input id="identification_number" name="identification_number" type="text" class="w-full mt-1" required />
            </div>

            <div>
                <x-label for="passport_number" value="Passport Number (optional)" class="font-medium text-gray-700" />
                <x-input id="passport_number" name="passport_number" type="text" class="w-full mt-1" />
            </div>

            <div>
                <x-label for="id_document" value="Upload ID Document" class="font-medium text-gray-700" />
                <input id="id_document" name="id_document" type="file" 
                       class="block w-full mt-1 border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200" required />
            </div>

            <div>
                <x-label for="proof_of_address" value="Upload Proof of Address" class="font-medium text-gray-700" />
                <input id="proof_of_address" name="proof_of_address" type="file" 
                       class="block w-full mt-1 border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200" required />
            </div>

            <div>
                <x-label for="passport_document" value="Upload Passport (optional)" class="font-medium text-gray-700" />
                <input id="passport_document" name="passport_document" type="file" 
                       class="block w-full mt-1 border border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200" />
            </div>

            <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                <x-button class="bg-indigo-600 hover:bg-indigo-700">Submit</x-button>
                
                {{-- Skip KYC --}}
                <a href="{{ route('kyc.skip') }}"
                   onclick="event.preventDefault(); document.getElementById('skip-kyc-form').submit();"
                   class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                   Skip for Now
                </a>
            </div>
        </form>

        <form id="skip-kyc-form" action="{{ route('kyc.skip') }}" method="POST" class="hidden">
            @csrf
        </form>
    </div>
</x-layouts.app>
