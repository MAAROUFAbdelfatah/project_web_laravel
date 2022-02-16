<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    <style>
      .rachid{
        height:50px;
      }
      </style>
    <!-- Navbar -->
    <nav class="rachid main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      

      <!-- SEARCH FORM -->
      
      {{-- <div class="dropdown navbar-nav ml-auto">
        <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
          <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
          <strong>mdo</strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg-end" aria-labelledby="dropdownUser2" style="">
          <li><a class="dropdown-item" href="#">New project...</a></li>
          <li><a class="dropdown-item" href="#">Settings</a></li>
          <li><a class="dropdown-item" href="#">Profile</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="#">Sign out</a></li>
        </ul>
      </div> --}}
      <div class="dropdown position-absolute top-1 end-0" >
        <a id="navbarDropdown" class="float-right nav-link dropdown-toggle ml-auto" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
          <img class="rachid1" src="/images/users/{{Auth::user()->image}}"/>  {{ Auth::user()->lname }}  {{Auth::user()->name}}
        </a>
        <style>
          .rachid1{
            height: 30px;
            width: 30px;
            border-radius: 50%;
            margin-bottom: 2px;
          }
        </style>

        <div class="dropdown-menu " aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{ route('logout') }}"
               onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
      </div>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-primary">
      <!-- Brand Logo -->
      <a href="index3.html" class="brand-link">
        <!--<img src="" alt="Admin Logo" class="brand-image img-circle elevation-3"
          style="opacity: .8"> -->
        <span class="brand-text font-weight-light">Admin</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            @isAdmin   
            <li class="nav-item menu-close">
              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-users-cog"></i>
                {{-- <i class="nav-icon fas fa-tachometer-alt"></i> --}}
                <p>
                  Encadrant
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('encadrants.create')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Ajouter</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('encadrants.index')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Encadrant</p>
                  </a>
                </li>
              </ul>
            </li>
            
            <li class="nav-item menu-close">
              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-users-cog"></i>
                <p>
                  Co-encadrant
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('coencadrants.create')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Ajouter</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('coencadrants.index')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Co-encadrants</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item menu-close">
              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-user-graduate"></i>
                {{-- <i class="nav-icon fas fa-tachometer-alt"></i> --}}
                <p>
                  Etudiant
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('etudiants.create')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Ajouter</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('etudiants.index')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Etudiants</p>
                  </a>
                </li>
              </ul>
            </li>
            @endisAdmin 
            <li class="nav-item menu-close">
              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-project-diagram"></i>
                <p>
                  Projet
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('projects.index')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Projects</p>
                  </a>
                </li>
              </ul>
            </li>
            @isEncadrant
            <li class="nav-item menu-close">
              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-sticky-note"></i>
                <p>
                  Business Plan
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('busniess_plans.create')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Ajouter</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('busniess_plans.index')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Business Plans</p>
                  </a>
                </li>
              </ul>
            </li>
            @endisEncadrant
            <li class="nav-item menu-close">
              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-users"></i>
                <p>
                  Equipe
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                @isEncadrant
                <li class="nav-item">
                  <a href="{{route('equipes.create')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Ajouter</p>
                  </a>
                </li>
                @endisEncadrant
                <li class="nav-item">
                  <a href="{{route('equipes.index')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Equipes</p>
                  </a>
                </li>
              </ul>
            </li>
            @isEncadrant
            <li class="nav-item menu-close">
              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-scroll"></i>
                <p>
                  Article
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('articles.create')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Ajouter</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('articles.index')}}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Article</p>
                  </a>
                </li>
              </ul>
            </li>
            @endisEncadrant
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      @yield('content')
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
      <div class="p-3">
        <h5>Title</h5>
        <p>Sidebar content</p>
      </div>
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->

  <!-- jQuery -->
  <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>