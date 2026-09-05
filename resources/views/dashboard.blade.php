
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
        .announcement-title {
            font-size: 25px;
            margin-bottom: 35px;
            font-weight: 600;
        }

        .announcement-grid {
            display: grid;
            grid-template-columns: repeat(2, 335px);
            gap: 55px 40px;
        }

        .announcement-card {
            height: 150px;
            border: 1px solid #d8d8d8;
            border-radius: 8px;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            border-color: #ab6005;
            transition: 0.2s;
        }

        .announcement-card:hover {
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        }

        .announcement-card h3 {
            font-size: 20px;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .announcement-card p {
            font-size: 17px;
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

            .announcement-grid {
                grid-template-columns: 1fr;
            }
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

            <li>
                <a href="#" class="active">
                    <span class="icon">
                        <img src="{{ asset('icons/pledge.svg')}}" alt="Pledge">
                    </span>
                    <span>Pledge</span>
                </a>
            </li>

            <li>
                <a href="#" class="active">
                    <span class="icon">
                        <img src="{{ asset('icons/budget.svg')}}" alt="Budget">
                    </span>
                    <span>Budget</span>
                </a>
            </li>

            <li>
                <a href="#" class="active">
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
                <a href="#" class="active" >
                    <span class="icon">
                        <img src="{{ asset('icons/settings.svg')}}" alt="Settings">
                    </span>
                    <span>Settings</span>
                </a>
            </li>

        </ul>

        <div class="logout">
            <a href="#">
                <img src="{{ asset('icons/logout.svg')}}" alt="Logout">logout
            </a>
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
 @if($announcement)
        <div class="announcement-card">
                        <h3>{{$announcement->title}}</h3>
                              <p>{{$announcement->content}}</p>
                    </div>
                    @else
                      <p>no announcement available.</p>
                        @endif   
    
 @if($announcement)
        <div class="announcement-card">
                        <h3>{{$announcement->title}}</h3>
                              <p>{{$announcement->content}}</p>
                    </div>
                    @else
                      <p>no announcement available.</p>
                        @endif   
    
 @if($announcement)
        <div class="announcement-card">
                        <h3>{{$announcement->title}}</h3>
                              <p>{{$announcement->content}}</p>
                    </div>
                    @else
                      <p>no announcement available.</p>
                        @endif   
    
 @if($announcement)
        <div class="announcement-card">
                        <h3>{{$announcement->title}}</h3>
                              <p>{{$announcement->content}}</p>
                    </div>
                    @else
                      <p>no announcement available.</p>
                        @endif   
@if(auth()->user()->role ==='admin')
<a
href="{{route('announcement.create')}}">
write annoubcement
</a>
@endif
        </div>

    </main>

</div>

</body>
</html>
