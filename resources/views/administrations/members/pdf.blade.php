<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des membres</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        th, td {
            border: 1px solid #333;
            padding: 5px;
            text-align: center;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h2>Liste des Membres</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Genre</th>
                <th>Email</th>
                <th>Téléphone</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($members as $member)
                <tr>
                    <td>{{ $member->id }}</td>
                    <td>{{ $member->user->lastname }}</td>
                    <td>{{ $member->user->firstname }}</td>
                    <td>{{ $member->user->gender }}</td>
                    <td>{{ $member->user->email }}</td>
                    <td>{{ $member->user->phone }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
