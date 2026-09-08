<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHEREHE MANAGEMENT SYSTEM - Pledge Form</title>
    <!-- Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .sherehe-card {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            padding: 2.5rem;
            width: 100%;
            max-width: 800px;
        }
        
        .radio-custom {
            height: 20px;
            width: 20px;
            border-radius: 50%;
            border: 2px solid #ccc;
            display: inline-block;
            vertical-align: middle;
            margin-right: 8px;
            cursor: pointer;
        }

        input[type="radio"]:checked + .radio-custom {
            border-color: #a16207;
            background-color: #a16207;
        }

        .golden-btn {
            background-color: #a16207;
            color: white;
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: background-color 0.2s;
        }
        
        .golden-btn:hover {
            background-color: #854d0e;
        }
        
        .gray-label {
            color: #6b7280;
            text-transform: uppercase;
            font-size: 0.875rem;
            letter-spacing: 0.05em;
        }
    </style>
</head>
<body class="bg-gray-100 flex flex-col items-center min-h-screen">

    <!-- Header / Title -->
    <div class="w-full max-w-7xl mt-12 mb-6 px-4">
        <h1 class="text-3xl font-bold text-gray-800">PLEDGES FORM</h1>
    </div>

    <!-- Main Card -->
    <div class="sherehe-card mx-4">
        <div class="flex justify-between items-center mb-8">
            <a href="#" class="text-gray-600 hover:text-gray-900">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            
            <h2 class="text-2xl font-semibold text-gray-900 flex-grow text-center">SHEREHE MANAGEMENT SYSTEM</h2>
            
            <div class="w-8"></div>
        </div>
        
        <!-- Display Success Message -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <!-- Display Validation Errors -->
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('store') }}" method="POST">
            @csrf

            <!-- Category Section -->
            <div class="mb-10">
                <label class="block gray-label mb-4">CATEGORY</label>
                <div class="flex flex-wrap gap-8">
                    <!-- Single -->
                    <label class="flex items-center cursor-pointer">
                        <input type="radio" name="category" value="SINGLE" class="category-radio hidden" {{ old('category', 'SINGLE') == 'SINGLE' ? 'checked' : '' }}>
                        <span class="radio-custom"></span>
                        <span class="text-lg text-gray-800 ml-2">SINGLE</span>
                    </label>
                    
                    <!-- Double -->
                    <label class="flex items-center cursor-pointer">
                        <input type="radio" name="category" value="DOUBLE" class="category-radio hidden" {{ old('category') == 'DOUBLE' ? 'checked' : '' }}>
                        <span class="radio-custom"></span>
                        <span class="text-lg text-gray-800 ml-2">DOUBLE</span>
                    </label>
                    
                    <!-- Others -->
                    <label class="flex items-center cursor-pointer">
                        <input type="radio" name="category" value="OTHERS" class="category-radio hidden" {{ old('category') == 'OTHERS' ? 'checked' : '' }}>
                        <span class="radio-custom"></span>
                        <span class="text-lg text-gray-800 ml-2">OTHERS</span>
                    </label>
                </div>
            </div>

            <!-- Hidden input kwa ajili ya kutuma amount kwenye controller ikiwa ni Single/Double -->
            <input type="hidden" id="amount_hidden" name="amount" value="">

            <!-- Amount & People Display Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                <!-- Amount Field -->
                <div>
                    <label class="block gray-label mb-2">AMOUNT (TSH)</label>
                    <!-- Readonly field kwa ajili ya Onyesho la Single & Double -->
                    <input type="text" id="amount_readonly" class="w-full p-3 border rounded-lg bg-gray-100 text-gray-700 font-bold" readonly placeholder="Sera ya kiasi itaonekana hapa">
                    
                    <!-- Input ya kiasi cha kuandika ikiwa ni OTHERS -->
                    <input type="number" id="amount_input" class="w-full p-3 border rounded-lg hidden focus:ring-2 focus:ring-yellow-500" placeholder="Ingiza kiasi chako">
                </div>

                <!-- Number of People Field -->
                <div>
                    <label class="block gray-label mb-2">NUMBER OF PEOPLE</label>
                    <input type="text" id="people_count" name="people_count" class="w-full p-3 border rounded-lg bg-gray-100 text-gray-700 font-bold" readonly value="1 Person">
                </div>
            </div>

            <!-- Pay Through Section (Display Only) -->
            <div class="mb-10">
                <label class="block gray-label mb-4 text-gray-500 font-bold uppercase tracking-wide">PAY THROUGH</label>
                <div class="grid grid-cols-2 gap-x-12 gap-y-6 text-xl">
                    <div class="flex items-center text-gray-700 font-medium">
                        <span class="h-3 w-3 rounded-full bg-green-500 mr-3"></span>
                        M-PESA
                    </div>
                    <div class="flex items-center text-gray-700 font-medium">
                        <span class="h-3 w-3 rounded-full bg-red-500 mr-3"></span>
                        AIRTEL MONEY
                    </div>
                    <div class="flex items-center text-gray-700 font-medium">
                        <span class="h-3 w-3 rounded-full bg-yellow-500 mr-3"></span>
                        MIXX BY YAS
                    </div>
                    <div class="flex items-center text-gray-700 font-medium">
                        <span class="h-3 w-3 rounded-full bg-orange-500 mr-3"></span>
                        HALOPESA
                    </div>
                </div>
            </div>
            
            <!-- Contacts Section -->
            <div class="mb-10 flex items-center gap-6">
                <svg class="w-10 h-10 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                </svg>
                
                <div class="space-y-1 text-gray-700">
                    <p class="font-semibold text-lg">CONTACTS</p>
                    <p>CHAIRPERSON +255 695 629 136</p>
                    <p>ACCOUNTANT +255 750 308 710</p>
                </div>
            </div>
            
            <!-- Action Buttons Section -->
            <div class="flex justify-between items-center mt-12 pt-8 border-t border-gray-100">
                <button type="submit" class="golden-btn text-lg">
                    make pledge
                </button>
                
                <a href='status' class="golden-btn text-lg">
                    view pledge status
                </a>
            </div>
            
        </form>
    </div>

    <!-- JavaScript Logic -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const priceSingle = {{ $settings->single_amount ?? 50000 }};
        const priceDouble = {{ $settings->double_amount ?? 100000 }};

        const categoryRadios = document.querySelectorAll('.category-radio');
        const amountReadonly = document.getElementById('amount_readonly');
        const amountInput = document.getElementById('amount_input');
        const amountHidden = document.getElementById('amount_hidden');
        const peopleCount = document.getElementById('people_count');

        function updateCategoryDetails(selectedCategory) {
            if (selectedCategory === 'SINGLE') {
                amountReadonly.classList.remove('hidden');
                amountInput.classList.add('hidden');
                amountInput.removeAttribute('name'); // Ondoa name kwenye input isiyotumika

                amountReadonly.value = priceSingle.toLocaleString() + ' TSH';
                amountHidden.value = priceSingle; // Weka kiasi kinachotakiwa kutumwa
                amountHidden.setAttribute('name', 'amount');

                peopleCount.value = "1 Person";
            } else if (selectedCategory === 'DOUBLE') {
                amountReadonly.classList.remove('hidden');
                amountInput.classList.add('hidden');
                amountInput.removeAttribute('name');

                amountReadonly.value = priceDouble.toLocaleString() + ' TSH';
                amountHidden.value = priceDouble;
                amountHidden.setAttribute('name', 'amount');

                peopleCount.value = "2 People";
            } else if (selectedCategory === 'OTHERS') {
                amountReadonly.classList.add('hidden');
                amountInput.classList.remove('hidden');
                amountInput.setAttribute('name', 'amount'); // Weka name kwa input inayoweza kujazwa
                amountHidden.removeAttribute('name'); // Ondoa name kwenye hidden field

                amountInput.value = '{{ old("amount") }}';
                amountInput.focus();
                peopleCount.value = "Custom / Group";
            }
        }

        categoryRadios.forEach(radio => {
            radio.addEventListener('change', function () {
                updateCategoryDetails(this.value);
            });

            if (radio.checked) {
                updateCategoryDetails(radio.value);
            }
        });

        // Hakikisha kuwa function inaendeshwa default kama hakuna iliyochaguliwa
        const checkedRadio = document.querySelector('.category-radio:checked');
        if (checkedRadio) {
            updateCategoryDetails(checkedRadio.value);
        } else {
            updateCategoryDetails('SINGLE');
        }
    });
    </script>
</body>
</html>