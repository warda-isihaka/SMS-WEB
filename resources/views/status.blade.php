<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHEREHE MANAGEMENT SYSTEM - Pledge Status</title>
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
        <h1 class="text-3xl font-bold text-gray-800">VIEW PLEDGE STATUS</h1>
    </div>

    <!-- Main Card -->
    <div class="sherehe-card mx-4 mb-12">
        <div class="flex justify-between items-center mb-8">
            <!-- Back Arrow to Pledge Form -->
            <a href="/" class="text-gray-600 hover:text-gray-900">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            
            <h2 class="text-2xl font-semibold text-gray-900 flex-grow text-center">SHEREHE MANAGEMENT SYSTEM</h2>
            
            <div class="w-8"></div>
        </div>

        <!-- Search Form -->
        <form action="{{ route('status.search') }}" method="GET" class="mb-8">
            <label class="block gray-label mb-2">SEARCH BY PHONE NUMBER</label>
            <div class="flex gap-4">
                <input type="text" name="phone" value="{{ request('phone') }}" placeholder="Ingiza namba ya simu mfano: 0712345678" required class="flex-grow p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:outline-none text-gray-700">
                <button type="submit" class="golden-btn">
                    Tafuta
                </button>
            </div>
        </form>

        <!-- Status Result (Onyesho pindi mtu akitafuta) -->
        @if(isset($pledge))
            <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 mb-8 space-y-4">
                <div class="border-b pb-3 flex justify-between items-center">
                    <span class="gray-label">Jina la Mfadhili</span>
                    <span class="text-lg font-bold text-gray-800">{{ $pledge->name ?? 'N/A' }}</span>
                </div>

                <div class="border-b pb-3 flex justify-between items-center">
                    <span class="gray-label">Aina ya Ahadi (Category)</span>
                    <span class="text-lg font-semibold text-gray-800">{{ $pledge->category }}</span>
                </div>

                <div class="border-b pb-3 flex justify-between items-center">
                    <span class="gray-label">Kiasi Kilichoahidiwa</span>
                    <span class="text-lg font-bold text-yellow-800">{{ number_format($pledge->amount) }} TSH</span>
                </div>

                <div class="border-b pb-3 flex justify-between items-center">
                    <span class="gray-label">Kiasi Kilicholipwa</span>
                    <span class="text-lg font-bold text-green-700">{{ number_format($pledge->paid_amount ?? 0) }} TSH</span>
                </div>

                <div class="border-b pb-3 flex justify-between items-center">
                    <span class="gray-label">Salio Lililobaki</span>
                    <span class="text-lg font-bold text-red-600">{{ number_format($pledge->amount - ($pledge->paid_amount ?? 0)) }} TSH</span>
                </div>

                <div class="flex justify-between items-center pt-2">
                    <span class="gray-label">Hali ya Malipo (Status)</span>
                    @if(($pledge->paid_amount ?? 0) >= $pledge->amount)
                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full font-semibold text-sm">Amehitimisha (PAID)</span>
                    @elseif(($pledge->paid_amount ?? 0) > 0)
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full font-semibold text-sm">Amelipa Sehemu (PARTIAL)</span>
                    @else
                        <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full font-semibold text-sm">Bado Hajalipa (PENDING)</span>
                    @endif
                </div>
            </div>
        @elseif(request('phone'))
            <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-lg mb-8 text-center">
                Hakuna Taarifa za ahadi zilizopatikana kwa namba hii: <strong>{{ request('phone') }}</strong>
            </div>
        @endif

        <!-- Contacts Section -->
        <div class="mb-8 flex items-center gap-6">
            <svg class="w-10 h-10 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
            </svg>
            
            <div class="space-y-1 text-gray-700">
                <p class="font-semibold text-lg">CONTACTS</p>
                <p>CHAIRPERSON +255 695 629 136</p>
                <p>ACCOUNTANT +255 750 308 710</p>
            </div>
        </div>

        <!-- Action Button Section -->
        <div class="flex justify-between items-center pt-6 border-t border-gray-100">
            <a href="/" class="golden-btn text-lg w-full text-center">
                Rudi Kwenye Form ya Ahadi
            </a>
        </div>
    </div>

</body>
</html>