<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>student-screen</title>
    <link rel="shortcut icon" href="/images/logofstt.png">
    <link rel="stylesheet" href="/css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />


</head>
<style>
    body {
    overflow-y: scroll;
}
.filiere-container{
    overflow-y: scroll;
}
</style>
<body>
    <header id="header">
        <img src="/images/invite/fst.jpeg" />
        <nav id="navbar">
            <ul>
                <li><a href="/admin/dashbord"><i   id="dash" class="fa-solid fa-gauge"></i>&nbsp; Dashboard</a></li>

                <li><a href="/admin/emplois"><i class="fas fa-graduation-cap"></i>&nbsp; Gèrer les emplois</a></li>
                <li><a href="/admin/affectersalle"><i  id="cal" class='bx bxs-calendar' ></i>Affectation des salles</a></li>
                <li><a href="/admin/modifierrole"><i class="fa-solid fa-file"></i>&nbsp;  Affectation des roles</a></li>
                <li><a href="/admin/nouveauclasse"><i class="fa-solid fa-file"></i>&nbsp;  inscrire une nouvelle classe </a></li>
                <li><a href="/admin/changercontenue"><i class="fa-solid fa-file"></i>&nbsp;  Changer le contenue d une filiere </a></li>
                <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out" aria-hidden="true"></i>&nbsp; Logout</a></li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </ul>
        </nav>
    </header>
    <main id="main">
        <section id="home">
            <h1 class="heading">Les services pédagogique </h1>
            <li><a href="{{ route('admin.nouveaufiliere') }}"><i class="fa-solid fa-file"></i>&nbsp; Nouvelle Filiere</a></li>
                @foreach($filiere as $f)
                <div class="filiere-container"style="background-color: rgb(39, 140, 140); width: 50%; padding: 15px; margin: 10px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                    <h2>{{ $f->nom }}</h2>
                    <p style="color: aliceblue">{{ $f->description }}</p>
                    <a href="{{ route('modifierFiliere.show', ['id' => $f->id]) }}" class="modifier-link">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                </div>
            @endforeach

            </div>

        </section>
    </main>
</body>
</html>
