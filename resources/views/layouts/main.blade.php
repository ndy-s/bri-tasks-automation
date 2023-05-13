<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Hendy Saputra">
    <meta name="generator" content="Hugo 0.108.0">
    <title>@yield('title')</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/dashboard/">
    <link href="{{ asset('dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        .callout {
            padding: 20px;
            margin: 20px 0;
            border: 1px solid #eee;
            border-left-width: 5px;
            border-radius: 3px;
        }
        .callout h4 {
            margin-top: 0;
            margin-bottom: 5px;
        }
        .callout p:last-child {
            margin-bottom: 0;
        }
        .callout code {
            border-radius: 3px;
        }
        .callout + .bs-callout {
            margin-top: -5px;
        }
        .callout-default {
            border-left-color: #777;
        }
        .callout-default h4 {
            color: #777;
        }
        .callout-primary {
            border-left-color: #428bca;
        }
        .callout-primary h4 {
            color: #428bca;
        }
        .callout-success {
            border-left-color: #5cb85c;
        }
        .callout-success h4 {
            color: #5cb85c;
        }
        .callout-danger {
            border-left-color: #d9534f;
        }
        .callout-danger h4 {
            color: #d9534f;
        }
        .callout-warning {
            border-left-color: #f0ad4e;
        }
        .callout-warning h4 {
            color: #f0ad4e;
        }
        .callout-info {
            border-left-color: #5bc0de;
        }
        .callout-info h4 {
            color: #5bc0de;
        }
        .callout-bdc {
            border-left-color: #29527a;
        }
        .callout-bdc h4 {
            color: #29527a;
        }
    </style>

    <!-- Custom styles for this template -->
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
</head>
<body>

<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="#">Quick Learning App</a>
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
            aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-nav">
        <div class="nav-item text-nowrap">
            <a class="nav-link px-3" href="#">&#169; Ndy</a>
        </div>
    </div>
</header>

<div class="container-fluid">
    <div class="row">
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3 sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ $title == 'Quick Learning' || $title == 'Quick Learning Create' || $title == 'Quick Learning Edit' ? 'active' : '' }}" aria-current="page" href="/m202">
                            <span data-feather="home" class="align-text-bottom"></span>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $title == 'Quick E-Learning' ? 'active' : '' }}" href="/quicklearn">
                            <span data-feather="layers" class="align-text-bottom"></span>
                            Quick E-Learning
                        </a>
                    </li>
                </ul>

                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
                    <span>Relax Export PDF</span>
                    <a class="link-secondary" href="#" aria-label="Add a new report">
                        <span data-feather="coffee" class="align-text-bottom"></span>
                    </a>
                </h6>
                <ul class="nav flex-column mb-2">
                    <li class="nav-item">
                        <a class="nav-link  {{ $title == 'Daftar Peserta' || $title == 'Daftar Peserta Create' || $title == 'Daftar Peserta Edit' ? 'active' : ''}}" href="/peserta">
                            <span data-feather="file-text" class="align-text-bottom"></span>
                            Daftar Peserta UUCK atau Resign
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $title == 'ELR to PDF' ? 'active' : ''}}" href="/elrpdf">
                            <span data-feather="file-text" class="align-text-bottom"></span>
                            ELR to PDF
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        @yield('content')
    </div>
</div>


<script src="{{ asset('dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"
integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE"
crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"
integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha"
crossorigin="anonymous"></script>
<script src="{{ asset('js/dashboard.js') }}"></script>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
@yield('js')
</body>
</html>
