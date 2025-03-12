<aside class="left-sidebar">
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <!-- Section Manager -->
                @if(auth()->user()->hasRole('gestionnaire'))
                
                <!-- Dashboard -->
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark" href="{{ route('manager.dashboard') }}">
                        <i class="mdi mdi-view-dashboard"></i>
                        <span class="hide-menu">Tableau de bord</span>
                    </a>
                </li>

                <li class="nav-small-cap">
                    <i class="mdi mdi-dots-horizontal"></i>
                    <span class="hide-menu">Gestion</span>
                </li>
                
                <!-- Vols -->
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)">
                        <i class="mdi mdi-airplane"></i>
                        <span class="hide-menu">Vols</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="{{ route('manager.flights.index') }}" class="sidebar-link">
                                <i class="mdi mdi-format-list-bulleted"></i>
                                <span class="hide-menu">Liste des vols</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('manager.flights.create') }}" class="sidebar-link">
                                <i class="mdi mdi-plus-circle"></i>
                                <span class="hide-menu">Ajouter un vol</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Destinations -->
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)">
                        <i class="mdi mdi-map-marker"></i>
                        <span class="hide-menu">Destinations</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="{{ route('manager.destinations.index') }}" class="sidebar-link">
                                <i class="mdi mdi-format-list-bulleted"></i>
                                <span class="hide-menu">Liste des destinations</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('manager.destinations.create') }}" class="sidebar-link">
                                <i class="mdi mdi-plus-circle"></i>
                                <span class="hide-menu">Ajouter une destination</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Réservations Manager -->
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)">
                        <i class="mdi mdi-book-multiple"></i>
                        <span class="hide-menu">Réservations</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="{{ route('manager.reservations.index') }}" class="sidebar-link">
                                <i class="mdi mdi-calendar-check"></i>
                                <span class="hide-menu">Toutes les réservations</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif

                <!-- Section Admin -->
                @if(auth()->user()->hasRole('admin'))
                <li class="nav-small-cap">
                    <i class="mdi mdi-dots-horizontal"></i>
                    <span class="hide-menu">Administration</span>
                </li>

                <!-- Statistiques Admin -->
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark" href="{{ route('admin.dashboard') }}">
                        <i class="mdi mdi-chart-bar"></i>
                        <span class="hide-menu">Tableau de bord</span>
                    </a>
                </li>

                <!-- Gestion des utilisateurs -->
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)">
                        <i class="mdi mdi-account-multiple"></i>
                        <span class="hide-menu">Utilisateurs</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="{{ route('admin.users.index') }}" class="sidebar-link">
                                <i class="mdi mdi-account-group"></i>
                                <span class="hide-menu">Liste des utilisateurs</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Vols Admin -->
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)">
                        <i class="mdi mdi-airplane"></i>
                        <span class="hide-menu">Gestion des Vols</span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="{{ route('admin.flights.index') }}" class="sidebar-link">
                                <i class="mdi mdi-format-list-bulleted"></i>
                                <span class="hide-menu">Liste des vols</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif

                <!-- Paramètres du compte -->
                <li class="nav-small-cap">
                    <i class="mdi mdi-dots-horizontal"></i>
                    <span class="hide-menu">Paramètres</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark" href="{{ route('profile.show') }}">
                        <i class="mdi mdi-account-settings"></i>
                        <span class="hide-menu">Mon profil</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="mdi mdi-logout"></i>
                        <span class="hide-menu">Déconnexion</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>