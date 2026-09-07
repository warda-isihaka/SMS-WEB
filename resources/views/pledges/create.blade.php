<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHEREHE MANAGEMENT SYSTEM - Pledge Form</title>
    <!-- Ongeza Tailwind CSS CDN kwa majaribio ya haraka (HAISHAURIWI PRODUCTION) -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Custom styles kwa ajili ya kufananisha zaidi na picha yako */
        .sherehe-card {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            padding: 2.5rem; /* ~10 */
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
            border-color: #a16207; /* dark golden yellow */
            background-color: #a16207;
        }

        .golden-btn {
            background-color: #a16207; /* dark golden yellow from image */
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
            color: #6b7280; /* Tailwind gray-500 */
            text-transform: uppercase;
            font-size: 0.875rem; /* text-sm */
            letter-spacing: 0.05em;
        }
    </style>
</head>
<body class="bg-gray-100 flex flex-col items-center min-h-screen">

    <!-- Header / Title as in image -->
    <div class="w-full max-w-7xl mt-12 mb-6 px-4">
        <h1 class="text-3xl font-bold text-gray-800">PLEDGES FORM</h1>
    </div>

    <!-- Main Card -->
    <div class="sherehe-card mx-4">
        <div class="flex justify-between items-center mb-8">
            <!-- Back arrow icon -->
            <a href="#" class="text-gray-600 hover:text-gray-900">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            
            <h2 class="text-2xl font-semibold text-gray-900 flex-grow text-center">SHEREHE MANAGEMENT SYSTEM</h2>
            
            <!-- Placeholder for right side to balance center, optional -->
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

        <form action="{{ route('pledges.store') }}" method="POST">
            @csrf
            
            <!-- Category Section -->
            <div class="mb-10">
                <label class="block gray-label mb-4">CATEGORY <span class="text-xs text-gray-400"> </span></label>
                <div class="flex flex-wrap gap-8">
                    <!-- Single -->
                    <label class="flex items-center cursor-pointer">
                        <input type="radio" name="category" value="SINGLE" class="hidden" {{ old('category') == 'SINGLE' ? 'checked' : '' }}>
                        <span class="radio-custom"></span>
                        <span class="text-lg text-gray-800">SINGLE</span>
                    </label>
                    
                    <!-- Double -->
                    <label class="flex items-center cursor-pointer">
                        <input type="radio" name="category" value="DOUBLE" class="hidden" {{ old('category') == 'DOUBLE' ? 'checked' : '' }}>
                        <span class="radio-custom"></span>
                        <span class="text-lg text-gray-800">DOUBLE</span>
                    </label>
                    
                    <!-- Others -->
                    <label class="flex items-center cursor-pointer">
                        <input type="radio" name="category" value="OTHERS" class="hidden" {{ old('category') == 'OTHERS' ? 'checked' : '' }}>
                        <span class="radio-custom"></span>
                        <span class="text-lg text-gray-800">OTHERS</span>
                    </label>
                </div>
            </div>
            
            <!-- Amount Section -->
            <div class="mb-10 w-full max-w-sm">
                <input type="number" name="amount" placeholder="Enter Amount" value="{{ old('amount') }}" 
                       class="w-full px-6 py-3 text-lg border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
            </div>
            
            <!-- Pay Through Section -->
            <div class="mb-10">
                <label class="block gray-label mb-4">PAY THROUGH</label>
                <div class="grid grid-cols-2 gap-x-12 gap-y-6 text-xl">
                    <label class="flex items-center cursor-pointer text-gray-700">
                        <input type="radio" name="payment_method" value="M-PESA" class="hidden" {{ old('payment_method') == 'M-PESA' ? 'checked' : '' }}>
                        <span class="radio-custom h-5 w-5 border-gray-400"></span>
                        M-PESA
                    </label>
                    <label class="flex items-center cursor-pointer text-gray-700">
                        <input type="radio" name="payment_method" value="AIRTEL MONEY" class="hidden" {{ old('payment_method') == 'AIRTEL MONEY' ? 'checked' : '' }}>
                        <span class="radio-custom h-5 w-5 border-gray-400"></span>
                        AIRTEL MONEY
                    </label>
                    <label class="flex items-center cursor-pointer text-gray-700">
                        <input type="radio" name="payment_method" value="MIXX BY YAS" class="hidden" {{ old('payment_method') == 'MIXX BY YAS' ? 'checked' : '' }}>
                        <span class="radio-custom h-5 w-5 border-gray-400"></span>
                        MIXX BY YAS
                    </label>
                    <label class="flex items-center cursor-pointer text-gray-700">
                        <input type="radio" name="payment_method" value="HALOPESA" class="hidden" {{ old('payment_method') == 'HALOPESA' ? 'checked' : '' }}>
                        <span class="radio-custom h-5 w-5 border-gray-400"></span>
                        HALOPESA
                    </label>
                </div>
            </div>
            
            <!-- Contacts Section -->
            <div class="mb-10 flex items-center gap-6">
                <!-- Phone icon -->
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
                
                <a href="{{ route('pledges.status') }}" class="golden-btn text-lg">
                    view pledge status
                </a>
            </div>
            
        </form>
    </div>

</body>
</html>