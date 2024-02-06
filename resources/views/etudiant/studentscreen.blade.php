<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>student-screen</title>
    <link rel="shortcut icon" href="/images/logofstt.png">
    <link rel="stylesheet" type="text/css" href="{{asset("css/studentscreen.css")}}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Saira+Extra+Condensed:100,200,300,400,500,600,700,800,900">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body{
            background-image: url("/images/invite/fst.jpeg");
        }
    </style>
</head>

<body>
    <header id="header">
        <a href="/etudiant">
            <img src="/images/invite/fst.jpeg" />
        </a>
        <nav id="navbar">

            @if(str_ends_with(Auth::user()->email, '@etudiant.com'))
            <ul>
                <li><a href="/etudiant/studentscreen"><i id="dash" class="fa-solid fa-gauge"></i>&nbsp; Dashboard</a></li>
                <li><a href="/emplois"><i id="cal" class='bx bxs-calendar'></i>Emploi du temps</a></li>
                <li><a href="/demande"><i class="fa-solid fa-file"></i>&nbsp; Demande/suivi</a></li>
                <li><a href="/annonces"><i id="annan" class='bx bxs-megaphone'></i>Annonces</a></li>


                <li>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out" aria-hidden="true"></i>&nbsp; Logout
                    </a>
                </li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </ul>
            @endif

        </nav>
    </header>
    <main id="main">
        <section id="home">
            <h1 class="heading">NOM : {{$nom." ".$prenom}}</h1>
            <h1 class="heading">FILIERE : {{Auth::user()->classe}}</h1>
            <h1 class="heading">EMAIL : {{Auth::user()->email}}</h1>
            <div class="infos" >

            </div>
        </section>
        <section class="demande">
            <div></div>
        </section>
    </main>
</body>
</html>
