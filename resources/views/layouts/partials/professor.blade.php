<li class="sidebar-item">
    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('dashboard') }}" aria-expanded="false">
        <i class="mdi mdi-view-dashboard"></i>
        <span class="hide-menu">Tableaux de bord</span>
    </a>
</li>
<li class="sidebar-item">
    <a href="{{ route('professors.show',auth()->user()->professor->id) }}" class="sidebar-link">
        <i class="mdi mdi-account-box"></i>
        <span class="hide-menu"> Mon profile </span>
    </a>
</li>
<li class="sidebar-item">
    <a href="{{ route('prof.courses_today') }}" class="sidebar-link">
        <i class="mdi mdi-book-open"></i>
        <span class="hide-menu"> Cours d'aujourd'hui</span>
    </a>
</li>
<li class="sidebar-item">
    <a href="{{ route('prof.courses') }}" class="sidebar-link">
        <i class="mdi mdi-book-open-page-variant"></i>
        <span class="hide-menu"> Calendrier de mes cours</span>
    </a>
</li>
@if(auth()->user()->hasRole('coordinator'))
<li class="sidebar-item">
    <a href="{{ route('groups-coordinator.index') }}" class="sidebar-link">
        <i class="mdi mdi-book-multiple"></i>
        <span class="hide-menu"> Mes parcours coordonnés</span>
    </a>
</li>
@endif
<li class="sidebar-item">
    <a href="{{ route('groups.index') }}" class="sidebar-link">
        <i class="mdi mdi-book"></i>
        <span class="hide-menu"> Tous les parcours </span>
    </a>
</li>