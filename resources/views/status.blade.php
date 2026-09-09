<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MY PROMISES STATUS - SMS</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #a8f0c6;
            min-height: 100vh;
            padding: 20px;
        }

        .view-status-title {
            font-size: 14px;
            color: #666;
            margin-bottom: 30px;
            text-transform: uppercase;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
        }

        .system-title {
            font-size: 22px;
            font-weight: bold;
            color: #000;
            margin-bottom: 30px;
            letter-spacing: 1px;
        }

        .section-title {
            font-size: 20px;
            font-weight: bold;
            color: #000;
            margin-bottom: 40px;
            letter-spacing: 0.5px;
        }

        /* STATUS BOXES GRID */
        .status-grid {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .status-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 140px;
        }

        .status-label {
            font-size: 13px;
            font-weight: bold;
            color: #000;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .status-value-box {
            background-color: #ffffff;
            width: 100%;
            padding: 12px 10px;
            border-radius: 4px;
            font-size: 16px;
            font-weight: bold;
            color: #333;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            text-align: center;
        }

        /* CARD STYLE KWA ALIYEMALIZA MALIPO (REMAIN = 0) */
        .card-container {
            background: #ffffff;
            border-radius: 12px;
            padding: 30px;
            max-width: 500px;
            margin: 0 auto;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            border: 2px solid #a16207;
            text-align: left;
        }

        .card-header {
            text-align: center;
            border-b: 2px solid #f0f0f0;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .card-header h3 {
            color: #a16207;
            font-size: 20px;
            text-transform: uppercase;
        }

        .card-header span {
            background-color: #22c55e;
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            display: inline-block;
            margin-top: 8px;
        }

        .card-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px dashed #e5e7eb;
        }

        .card-label {
            font-weight: bold;
            color: #4b5563;
        }

        .card-value {
            font-weight: bold;
            color: #111827;
        }

        .golden-btn {
            background-color: #a16207;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="view-status-title"># </div>

    <div class="container">
        <h1 class="system-title">SHEREHE MANAGEMENT SYSTEM</h1>
        <h2 class="section-title">MY PROMISES STATUS</h2>

        @php
            $amount = $pledge->amount ?? 0;
            $paid = $pledge->paid ?? $pledge->paid_amount ?? 0;
            $remain = $amount - $paid;
        @endphp

        @if(isset($pledge) && $remain <= 0)
            <!-- CARD YA UTHIBITISHO (INATOKEA KAMA REMAIN NI ZERO) -->
            <div class="card-container">
                <div class="card-header">
                    <h3>KADI YA MSHIRIKI</h3>
                    <span>AMEMALIZA MALIPO</span>
                </div>

                <div class="card-row">
                    <span class="card-label">Jina:</span>
                    <span class="card-value">{{ $pledge->name ?? $pledge->phone ?? 'N/A' }}</span>
                </div>

                <div class="card-row">
                    <span class="card-label">Kipengele (Category):</span>
                    <span class="card-value">{{ $pledge->category ?? $pledge->promise ?? 'N/A' }}</span>
                </div>

                <div class="card-row">
                    <span class="card-label">Idadi ya Watu:</span>
                    <span class="card-value">{{ $pledge->people_count ?? '1 Person' }}</span>
                </div>

                <div class="card-row">
                    <span class="card-label">Jumla Iliyolipwa:</span>
                    <span class="card-value" style="color: #15803d;">{{ number_format($paid) }} TSH</span>
                </div>

                <div class="card-row">
                    <span class="card-label">Njia ya Malipo:</span>
                    <span class="card-value">{{ $pledge->payment_method ?? 'N/A' }}</span>
                </div>

                <div style="text-align: center;">
                    <a href="/" class="golden-btn">Rudi Mwanzo</a>
                </div>
            </div>

        @else
            <!-- STATUS GRID YA KAWAIDA (INATOKEA KAMA BADO ANADAIWA) -->
            <div class="status-grid">
                <!-- CATEGORY / PROMISE -->
                <div class="status-card">
                    <span class="status-label">CATEGORY</span>
                    <div class="status-value-box">
                        {{ $pledge->category ?? $pledge->promise ?? 'N/A' }}
                    </div>
                </div>

                <!-- AMOUNT -->
                <div class="status-card">
                    <span class="status-label">AMOUNT</span>
                    <div class="status-value-box">
                        {{ isset($pledge->amount) ? number_format($pledge->amount) : 'N/A' }}
                    </div>
                </div>

                <!-- PAID -->
                <div class="status-card">
                    <span class="status-label">PAID</span>
                    <div class="status-value-box">
                        {{ isset($pledge->paid) ? number_format($pledge->paid ?? $pledge->paid_amount) : 'N/A' }}
                    </div>
                </div>

                <!-- REMAIN -->
                <div class="status-card">
                    <span class="status-label">REMAIN</span>
                    <div class="status-value-box">
                        {{ number_format($remain) }}
                    </div>
                </div>
            </div>
        @endif

    </div>

</body>
</html>