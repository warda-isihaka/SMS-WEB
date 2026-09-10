
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SMS Dashboard</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #ffffff;
            color: #333;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: 230px;
            min-height: 100vh;
            border-right: 1px solid #e5e5e5;
            padding: 25px 15px;
            background: #fff;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 40px;
            padding-left: 10px;
            color: #ab6005;
        }
        .logo img {
            width: 100px;
            height: 100px;
            object-fit: contain;
        }

        .menu {
            list-style: none;
        
        }

        .menu li {
            margin-bottom: 12px;
        }

        .menu a {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 12px;
            text-decoration: none;
            color: #777;
            border-radius: 8px;
            font-size: 15px;
        }

        .menu a:hover,
        .menu a.active {
            background: #fff;
            color: #ab6005;
        }

        .icon {
            width: 22px;
            text-align: center;
            font-size: 18px;
        }
        .icon img {
            width: 22px;
            height: 22px;
        }

        .logout {
            position: absolute;
            bottom: 25px;
            left: 25px;
        }

        .logout a {
            text-decoration: none;
            color: #ff1008;
        }
        .logout img {
            width: 22px;
            height: 22px;
            margin-left: 130px;
        }

        /* MAIN CONTENT */
        .main {
            flex: 1;
            padding: 30px 45px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 65px;
        }

        .welcome {
            font-size: 25px;
            color: #ab6005;
            font-weight: 600;
        }

        .top-icons {
            display: flex;
            gap: 20px;
            color: #777;
            font-size: 20px;
        }

        /* ANNOUNCEMENT */
    
       /* Container for the 2-column grid */
.announcement-grid {
    display: grid !important;
    grid-template-columns: repeat(2, 1fr) !important; /* Forces exactly 2 equal columns */
    gap: 20px !important;                             /* Space between cards */
    max-width: 800px;                                 /* Prevents cards from expanding endlessly */
    width: 100%;
    margin-top: 20px;
    box-sizing: border-box;
}

/* Individual card styling */
.announcement-card {
    border: 1.5px solid #c8a264;
    border-radius: 12px;
    background-color: #ffffff;
    min-height: 140px;
    width: 100%;
    box-sizing: border-box;
    display: flex;
}

/* Centering content inside the card */
.announcement-box {
    width: 100%;
    display: flex !important;
    flex-direction: column !important;
    justify-content: center !important;
    align-items: center !important;
    text-align: center !important;
    padding: 20px;
}

.announcement-box p {
    margin: 0 0 6px 0;
    color: #666666;
    font-size: 1.1rem;
}

.announcement-box small {
    color: #999999;
    font-size: 0.875rem;
}
        

        .announcement-grid .announcement-box:hover {
            transform:translatey(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.12);
        }

        

        /* MOBILE */
        @media (max-width: 800px) {

            .sidebar {
                width: 70px;
            }

            .logo span,
            .menu a span {
                display: none;
            }

            .main {
                padding: 25px;
            }
            .announcement-grid{
             grid-template-columns: 1fr !important;
             row-gap: 20px !important;;
           }
            
        }


        /* --- CODE MPYA YA POP-UP MENU YA PEMBENI --- */
.menu li {
    position: relative; /* Inashikilia pop-up ipae pembeni ya Pledge */
}

.flyout-menu {
    position: absolute;
    top: 0;
    left: 50%; /* Inasukuma pop-up itokee kulia mwa sidebar */
    margin-left: 8px; /* Nafasi ndogo kati ya sidebar na pop-up */
    background: #ffffff;
    border: 1px solid #e5e5e5;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    width: 160px;
    padding: 6px 0;
    display: none; /* Inajificha hadi ikibonyezwa */
    z-index: 999;
    list-style: none;
}

.flyout-menu li {
    margin-bottom: 0 !important;
}

.flyout-menu a {
    padding: 10px 16px !important;
    font-size: 14px !important;
    color: #444 !important;
    border-radius: 0 !important;
    display: block !important;
    text-decoration: none !important;
}

.flyout-menu a:hover {
    background: #fdf8f3 !important;
    color: #ab6005 !important;
}


    </style>
</head>

<body>

<div class="container">

    <!-- SIDEBAR -->
    <aside class="sidebar">

        <div class="logo" >
            <span>
            <img src="{{ asset('images/logo.jpg')}}" alt="Logo">
            </span>
            <span >SMS</span>
        </div>

        <ul class="menu">

            <li>
                <a href="{{ route('dashboard') }}" class="active">
                    <span class="icon">
                        <img src="{{ asset('icons/dashboard.svg')}}" alt="Dashboard">
                    </span>
                    <span>Dashboard</span>
                </a>
            </li>

           <!-- PLEDGE MENU INAYO-POP UP PEMBENI -->
            <li>

                <a href="/pledges" class="active">
                <a href="javascript:void(0)" onclick="toggleFlyout(event)" class="active">
                    <span class="icon">
                        <img src="{{ asset('icons/pledge.svg')}}" alt="Pledge">
                    </span>
                    <span>Pledge</span>
                   
                </a>

                <!-- POP-UP MENU YA PEMBENI (WEKA LINK ZAKO HAPA) -->
                <ul class="flyout-menu" id="pledgeFlyout">
                    <li>
                        <a href="/create">Create</a>
                    </li>
                    <li>
                        <a href="/pledge_management">Manage</a>
                    </li>
                    <li>
                        <a href="/status">Status</a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="/budget" class="active">
                    <span class="icon">
                        <img src="{{ asset('icons/budget.svg')}}" alt="Budget">
                    </span>
                    <span>Budget</span>
                </a>
            </li>

            <li>
                <a href="/card" class="active">
                    <span class="icon">
                        <img src="{{ asset('icons/cards.svg')}}" alt="Cards">
                    </span>
                    <span>Cards</span>
                </a>
            </li>

            <li>
                <a href="{{ route('announcement.create') }}" class="active">
                    <span class="icon">
                        <img src="{{ asset('icons/announcement.svg')}}" alt="Announcement">
                        </span>
                    <span>Announcement</span>
                </a>
            </li>

            <li>
               <a href="/user-management" class="active">
                    <span class="icon">
                        <img src="{{ asset('icons/settings.svg')}}" alt="Settings">
                    </span>
                    <span>Settings</span>
                </a>
            </li>

        </ul>


      <div class="logout">
    <a href="{{ route('logout') }}" 
       onclick="event.preventDefault(); if(confirm('Are you sure you want to log out?')) { document.getElementById('logout-form').submit(); }">
        <img src="{{ asset('icons/logout.svg') }}" alt="Logout"> logout
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</div>
    </aside>


    <!-- MAIN CONTENT -->
    <main class="main">

        <div class="topbar">

            <div class="welcome">
                Welcome, user
            </div>

            <div class="top-icons">
                <span class="icon">
                    <img src="{{ asset('icons/comments.svg')}}" alt="Messages">
                </span>
                <span class="icon">
                    <img src="{{ asset('icons/notifications.svg')}}" alt="Notifications">
                </span>
                <span class="icon">
                    <img src="{{ asset('icons/profile.svg')}}" alt="Profile">
                </span>
            </div>

        </div>


        <!-- ANNOUNCEMENTS -->
        <h2 class="announcement-title">
            Announcement
        </h2>

        <div class="announcement-grid">
       @for ($i = 1; $i <= 4; $i++)
       @if (isset($boxes[$i]))
        <div class="announcement-card" >
            <div class="announcement-box">
                <p>{{ $boxes[$i]->content }}</p>
                <small>{{ $boxes[$i]->created_at->format('d M Y') }}</small>
                  </div>
               </div>                     
         @endif
         @endfor
</div>
 

    </main>

</div>

<!-- JAVASCRIPT YA POP-UP -->
<script>
    function toggleFlyout(event) {
        event.stopPropagation();
        const flyout = document.getElementById('pledgeFlyout');
        
        if (flyout.style.display === "block") {
            flyout.style.display = "none";
        } else {
            flyout.style.display = "block";
        }
    }

    // Ukibonyeza popote nje ya pop-up au ukurasa mwingine, inajificha
    document.addEventListener('click', function() {
        const flyout = document.getElementById('pledgeFlyout');
        if (flyout) {
            flyout.style.display = "none";
        }
    });
</script>

</body>
</html>
