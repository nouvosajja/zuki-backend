<nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Navbar</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        
        {{-- <form class="d-flex" role="search">
          <a class="btn btn-outline-success me-2" href="/login/all">Sign in</a>
          <a class="btn btn-outline-danger" href="/register/all">Sign up</a>
        </form> --}}
        <ul class="navbar-nav ms-auto">
          @auth
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Hi, {{ auth()->user()->name }}
            </a>
            <ul class="dropdown-menu">
              <li>
                <a class="dropdown-item" href="/dashboard/index">
                  <i class="bi bi-layout-text-sidebar-reverse">Dashboard</i>
                </a>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li>
                <form action="/session/logout" method="post">
                  @csrf
                  <button type="submit" class="dropdown-item">
                    <i class="bi bi-box-arrow-right">Logout</i>
                  </button>
                </form>
              </li>
            </ul>
          </li>
          @else
            <li class="nav-item">
              <a class="nav-link" href="/session/login">Login</a>
            </li>
          @endauth
        </ul>
      </div>
    </div>
  </nav>