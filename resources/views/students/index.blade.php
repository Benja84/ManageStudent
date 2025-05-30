@extends('layouts.base')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center">
        {{-- <h2 class="mb-4">Liste des membres du personnel ({{ $students->count() }})</h2> --}}

        <a href="{{ route('students.create') }}" class="btn btn-success mb-3">
            <i class="fas fa-plus-circle"></i> Ajouter un étudiant
        </a>
    </div>
    {{-- <a href="{{ route('students.create') }}" class="btn btn-success mb-3">➕ Ajouter un membre</a> --}}

    <table class="table align-middle text-center">
        <thead class="table-light">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">PHOTO</th>
                <th scope="col">GENRE</th>
                <th scope="col">NOM</th>
                <th scope="col">PRÉNOM</th>
                <th scope="col">EMAIL</th>
                <th scope="col">PORTABLE</th>
                <th scope="col">ACTIONS</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($students as $index => $student)
                <tr>
                    <td>{{ $student->id }}</td>
                    <td>
                        @if ($student->photo)
                            <img src="{{ asset('storage/' . $student->photo) }}"
                                alt="Photo de {{ $student->lastname }}"
                                width="60"
                                height="60"
                                class="rounded-circle border border-2 shadow"
                                style="object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-secondary d-flex justify-content-center align-items-center text-white"
                                style="width: 60px; height: 60px; font-size: 14px;">
                                N/A
                            </div>
                        @endif
                    </td>
                    <td>{{ $student->user->gender === 'F' ? '♀' : '♂' }}</td>
                    <td>{{ $student->user->lastname }}</td>
                    <td>{{ $student->user->firstname }}</td>
                    <td><a href="mailto:{{ $student->user->email }}">{{ $student->user->email }}</a></td>
                    <td><a href="tel:{{ $student->user->phone }}">{{ $student->user->phone }}</a></td>
                    <td class="d-flex justify-content-center gap-3">
                        <a href="{{ route('students.show', $student->id) }}" class="btn btn-sm btn-info">👁</a>

                        <a href="{{ route('students.edit', $student->id) }}" class="btn btn-sm btn-primary">✏️</a>

                        <form action="{{ route('students.destroy', $student->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Confirmer la suppression ?')">🗑️</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-muted">Aucun membre trouvé</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
