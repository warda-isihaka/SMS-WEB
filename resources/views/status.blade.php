<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VIEW STATUS FORM</title>
    <!-- Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .status-card {
            background-color: #a7f3d0; /* Rangi ya kijani kama kwenye picha */
            border-radius: 12px;
            padding: 2.5rem;
            width: 100%;
            max-width: 800px;
        }
        
        .gray-label {
            color: #374151;
            text-transform: uppercase;
            font-size: 0.875rem;
            font-weight: 600;
            letter-spacing: 0.05em;
        }

        .data-box {
            background-color: white;
            padding: 0.75rem 1rem;
            border-radius: 6px;
            font-weight: bold;
            color: #1f2937;
            text-align: center;
            min-height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body class="bg-gray-100 flex flex-col items-center min-h-screen p-6">

    <!-- Header / Title -->
    

    <!-- Main Card -->
    <div class="status-card shadow-lg">
        <h2 class="text-2xl font-bold text-gray-900 text-center mb-6">SHEREHE MANAGEMENT SYSTEM</h2>
        <h3 class="text-xl font-bold text-gray-800 text-center mb-8">MY PROMISES STATUS</h3>

        @if(isset($pledges) && $pledges->count() > 0)
            @foreach($pledges as $pledge)
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <!-- Category -->
                    <div>
                        <label class="block gray-label mb-2 text-center">CATEGORY</label>
                        <div class="data-box">
                            {{ $pledge->category ?? 'N/A' }}
                        </div>
                    </div>

                    <!-- Amount -->
                    <div>
                        <label class="block gray-label mb-2 text-center">AMOUNT</label>
                        <div class="data-box">
                            {{ number_format($pledge->amount ?? 0) }} TSH
                        </div>
                    </div>

                    <!-- Paid -->
                    <div>
                        <label class="block gray-label mb-2 text-center">PAID</label>
                        <div class="data-box text-green-700">
                            {{ number_format($pledge->paid ?? 0) }} TSH
                        </div>
                    </div>

                    <!-- Remain -->
                    <div>
                        <label class="block gray-label mb-2 text-center">REMAIN</label>
                        <div class="data-box text-red-600">
                            {{ number_format($pledge->remain ?? 0) }} TSH
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <!-- Displayed when user has no pledges -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <label class="block gray-label mb-2 text-center">CATEGORY</label>
                    <div class="data-box">N/A</div>
                </div>
                <div>
                    <label class="block gray-label mb-2 text-center">AMOUNT</label>
                    <div class="data-box">N/A</div>
                </div>
                <div>
                    <label class="block gray-label mb-2 text-center">PAID</label>
                    <div class="data-box">N/A</div>
                </div>
                <div>
                    <label class="block gray-label mb-2 text-center">REMAIN</label>
                    <div class="data-box">N/A</div>
                </div>
            </div>
            <p class="text-center text-gray-700 font-semibold mt-6">Hujatengeneza ahadi yoyote bado.</p>
        @endif

        <!-- Action Button -->
        <div class="mt-8 text-center">
            <a href="{{ route('create') }}" class="inline-block bg-yellow-700 hover:bg-yellow-800 text-white font-semibold px-6 py-2 rounded-lg transition">
                Back to Pledge Form
            </a>
        </div>
    </div>

</body>
</html>