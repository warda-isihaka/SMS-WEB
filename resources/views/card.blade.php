<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wedding Invitation Card</title>
    <!-- Fonts za Google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Libraries za QR Code na Download Image -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: ffffff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            font-family: 'Montserrat', sans-serif;
            padding: 15px;
        }

        /* CARD WRAPPER - Size ya Simu (Mobile Friendly) */
        .card-container {
            width: 100%;
            max-width: 360px; /* Saizi iliyoboreshwa kwa ajili ya screen za simu */
            background-color: #0d0e15;
            color: #ffffff;
            padding: 25px 20px;
            position: relative;
            box-shadow: 0 10px 25px rgba(0,0,0,0.6);
            text-align: center;
            border: 4px solid #d4af37; /* Mstari wa Dhahabu */
            border-radius: 4px;
        }

        /* HEADER TEXT */
        .intro-text {
            font-size: 11px;
            line-height: 1.4;
            font-weight: 300;
            margin-bottom: 12px;
            color: #f0f0f0;
        }

        /* MAJINA YA MAHARUSI */
        .names h1 {
            font-family: 'Great Vibes', cursive;
            color: #dfb15b;
            font-size: 36px;
            font-weight: normal;
            line-height: 1.1;
        }

        .names .and {
            font-family: 'Great Vibes', cursive;
            color: #dfb15b;
            font-size: 26px;
            margin: -4px 0;
        }

        /* PICHA YA DUARA */
        .photo-wrapper {
            display: flex;
            justify-content: center;
            margin: 15px 0;
        }

        .photo-container {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            border: 2px solid #dfb15b;
            overflow: hidden;
        }

        .photo-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* TAREHE NA MAHALI */
        .details {
            text-align: left;
            font-size: 11px;
            line-height: 1.6;
            color: #ffffff;
            margin-bottom: 15px;
            padding-left: 5px;
        }

        .details strong {
            font-weight: 600;
        }

        /* CATEGORY TAG */
        .guest-category {
            font-size: 12px;
            color: #dfb15b;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        /* QR CODE SECTION */
        .qr-section p {
            font-size: 10px;
            margin-bottom: 6px;
            color: #cccccc;
        }

        #qrcode {
            background-color: #ffffff;
            padding: 5px;
            display: inline-block;
            border-radius: 4px;
        }

        #qrcode img {
            margin: 0 auto;
        }

        /* BUTTON YA DOWNLOAD */
        .download-btn {
            margin-top: 20px;
            background-color: #dfb15b;
            color: #000;
            border: none;
            padding: 12px 25px;
            font-size: 14px;
            font-weight: bold;
            border-radius: 25px;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(223, 177, 91, 0.3);
            transition: 0.2s;
        }

        .download-btn:active {
            transform: scale(0.96);
        }
    </style>
</head>
<body>
    <!-- KADI YENYEWE -->
    <div class="card-container" id="weddingCard">
        <p class="intro-text">
            The families of ISIAKA and KAPELE<br>
            wish to invite you to the wedding ceremony<br>
            of their son and daughter
        </p>

        <div class="names">
            <h1>Maiko stephen</h1>
            <div class="and">and</div>
            <h1>Viginia madam</h1>
        </div>

        <div class="photo-wrapper">
            <div class="photo-container">
                <!-- Weka picha ya couples hapa -->
                <img src="{{ asset('images/couple.webp') }}" alt="Warda & Kelvin">
            </div>
        </div>

        <div class="details">
            <p><strong>DATE:</strong> 20/9/2026 saturday.</p>
            <p><strong>TIME:</strong> 11:30AM.</p>
            <p><strong>VENUE:</strong> The split way masaki-dar es salaam-Tanzania.</p>
        </div>

        <!-- Onyesho la Category ya Mgeni -->
      <div class="guest-category">
    CATEGORY: <span id="categoryName">{{ auth()->user()->pledge?->category ?? 'PENDING' }}</span>
</div>

        <div class="qr-section">
            <p>for more information scan here</p>
            <div id="qrcode"></div>
        </div>
    </div>

   <!-- BUTTON YA KUDOWNLOAD KADI / REMAINING BALANCE -->
@php
    $pledge = auth()->user()->pledge ?? null;
    $Amount = (float)($pledge->amount ?? $pledge->amount ?? 0);
    $paid = (float)($pledge->paid ?? 0);
    $Remain = max(0, $Amount - $paid);
@endphp

@if($pledge && $Remain<= 0)
    <button class="download-btn" onclick="downloadCard()">
        Download Card (PNG)
    </button>
@else
    <p style="margin-top: 15px; color: #666; font-size: 14px; text-align: center;">
        Remaining Balance: <strong>{{ number_format($Remain, 2) }} TZS</strong><br>
        <small>(Pay full pledge to enable card download)</small>
    </p>
@endif

    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
   
   <script>
    // 1. Data za mgeni kutoka kwenye Laravel
   const guestData = {
    bride_and_groom: "Maiko stephen & Viginia madam",
    guest_name: @json(auth()->user()->name ?? 'Guest'),
    category: @json(auth()->user()->pledge?->category ?? 'PENDING')
};

    // 2. Text itakayokuwa ndani ya QR Code
    const qrText = `WEDDING INVITATION\nCouple: ${guestData.bride_and_groom}\nGuest: ${guestData.guest_name}\nCategory: ${guestData.category}`;

    // 3. Tengeneza QR Code baada ya DOM kuload kamili
    document.addEventListener("DOMContentLoaded", function () {
        const qrElement = document.getElementById("qrcode");
        
        if (qrElement) {
            qrElement.innerHTML = ""; // Safisha eneo la QR
            
            new QRCode(qrElement, {
                text: qrText,
                width: 85,
                height: 85,
                colorDark: "#000000",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H
            });
            
        }
    });

    

    // 4. Function ya kupakua kadi
    function downloadCard() {
        const cardElement = document.getElementById("weddingCard");

        // Subiri kidogo kisha render html2canvas ili kuhakikisha QR code na picha zote ziko tayari
        setTimeout(() => {
            html2canvas(cardElement, {
                scale: 3,             // Kuongeza ubora wa picha (High Quality)
                useCORS: true,        // Kuruhusu picha za nje kurender
                allowTaint: false,    // Inazuia picha kuwa na shida ya usalama
                backgroundColor: null // Inahifadhi rangi na muundo halisi wa background
            }).then(canvas => {
                const link = document.createElement("a");
                link.download = `Wedding_Card_${guestData.guest_name.replace(/\s+/g, '_')}.png`;
                link.href = canvas.toDataURL("image/png", 1.0);
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }).catch(err => {
                console.error("Download Error: ", err);
                alert("Imeshindikana kupakua kadi. Tafadhali jaribu tena.");
            });
        }, 300); // Timed delay ndogo inahakikisha QR code snapshot inachukuliwa kikamilifu
    }
</script>

</body>
</html>