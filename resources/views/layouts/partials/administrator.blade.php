
<li class="sidebar-item">
    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('dashboard') }}" aria-expanded="false">
        <i class="mdi mdi-view-dashboard"></i>
        <span class="hide-menu">Tableaux de bord</span>
    </a>
</li>
<li class="sidebar-item">
    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
        <i class="mdi mdi-account-multiple"></i>
        <span class="hide-menu">Membres du personnel </span>
    </a>
    <ul aria-expanded="false" class="collapse  first-level">
        <li class="sidebar-item">
            <a href="{{ route('members.create') }}" class="sidebar-link">
                <i class="mdi mdi-note-outline"></i>
                <span class="hide-menu"> Créer  </span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="{{ route('members.index') }}" class="sidebar-link">
                <i class="mdi mdi-receipt"></i>
                <span class="hide-menu"> Liste du personnel </span>
            </a>
        </li>
    </ul>
</li>
<li class="sidebar-item">
    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
        <i class="mdi mdi-school"></i>
        <span class="hide-menu">Etudiants </span>
    </a>
    <ul aria-expanded="false" class="collapse  first-level">
        <li class="sidebar-item">
            <a href="{{ route('students.create') }}" class="sidebar-link">
                <i class="mdi mdi-note-outline"></i>
                <span class="hide-menu"> Créer  </span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="{{ route('students.index') }}" class="sidebar-link">
                <i class="mdi mdi-receipt"></i>
                <span class="hide-menu"> Liste des étudiants </span>
            </a>
        </li>
    </ul>
</li>
<li class="sidebar-item">
    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
        <i class="mdi mdi-clipboard-account"></i>
        <span class="hide-menu">Professeurs </span>
    </a>
    <ul aria-expanded="false" class="collapse  first-level">
        <li class="sidebar-item">
            <a href="{{ route('professors.create') }}" class="sidebar-link">
                <i class="mdi mdi-note-outline"></i>
                <span class="hide-menu"> Créer  </span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="{{ route('professors.index') }}" class="sidebar-link">
                <i class="mdi mdi-receipt"></i>
                <span class="hide-menu"> Liste des Professors </span>
            </a>
        </li>
    </ul>
</li>
<li class="sidebar-item">
    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
        <i class="fas fa-bookmark"></i>
        <span class="hide-menu">Mentions </span>
    </a>
    <ul aria-expanded="false" class="collapse  first-level">
        <li class="sidebar-item">
            <a href="{{ route('sections.create') }}" class="sidebar-link">
                <i class="mdi mdi-note-outline"></i>
                <span class="hide-menu"> Créer  </span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="{{ route('sections.index') }}" class="sidebar-link">
                <i class="mdi mdi-receipt"></i>
                <span class="hide-menu"> Liste des mentions </span>
            </a>
        </li>
    </ul>
</li>
<li class="sidebar-item">
    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
        <i class="fas fa-bookmark"></i>
        <span class="hide-menu">Parcours </span>
    </a>
    <ul aria-expanded="false" class="collapse  first-level">
        <li class="sidebar-item">
            <a href="{{ route('groups.create') }}" class="sidebar-link">
                <i class="mdi mdi-note-outline"></i>
                <span class="hide-menu"> Créer  </span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="{{ route('groups.index') }}" class="sidebar-link">
                <i class="mdi mdi-receipt"></i>
                <span class="hide-menu"> Liste des parcours </span>
            </a>
        </li>
    </ul>
</li>
<li class="sidebar-item">
    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
        <i class="fas fa-calendar"></i>
        <span class="hide-menu">Cours </span>
    </a>
    <ul aria-expanded="false" class="collapse  first-level">
        <li class="sidebar-item">
            <a href="{{ route('courses.create') }}" class="sidebar-link">
                <i class="mdi mdi-note-outline"></i>
                <span class="hide-menu"> Créer  </span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="{{ route('courses.index') }}" class="sidebar-link">
                <i class="mdi mdi-receipt"></i>
                <span class="hide-menu"> Calendrier des cours </span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="{{ route('closedays.create') }}" class="sidebar-link">
                <i class="mdi mdi-calendar-check"></i>
                <span class="hide-menu"> Gérer les jours fermés</span>
            </a>
        </li>
    </ul>
</li>
<li class="sidebar-item">
    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
        <i class="fas fa-book"></i>
        <span class="hide-menu">Matières </span>
    </a>
    <ul aria-expanded="false" class="collapse  first-level">
        <li class="sidebar-item">
            <a href="{{ route('subjects.create') }}" class="sidebar-link">
                <i class="mdi mdi-note-outline"></i>
                <span class="hide-menu"> Créer  </span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="{{ route('subjects.index') }}" class="sidebar-link">
                <i class="mdi mdi-receipt"></i>
                <span class="hide-menu"> Liste des matières </span>
            </a>
        </li>
    </ul>
</li>
<li class="sidebar-item">
    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false">
        <i class="fas fa-building"></i>
        <span class="hide-menu">Salle </span>
    </a>
    <ul aria-expanded="false" class="collapse  first-level">
        <li class="sidebar-item">
            <a href="{{ route('rooms.create') }}" class="sidebar-link">
                <i class="mdi mdi-note-outline"></i>
                <span class="hide-menu"> Créer  </span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="{{ route('rooms.index') }}" class="sidebar-link">
                <i class="mdi mdi-receipt"></i>
                <span class="hide-menu"> Liste des salles </span>
            </a>
        </li>
    </ul>
</li>