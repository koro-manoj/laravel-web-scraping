<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scrape Form</title>
</head>
<body>
    <h2>Scrape Form</h2>
    <form action="{{ route('scrape.result') }}" method="GET">
        <label for="name">Enter Name:</label>
        <input type="text" id="name" name="name" required>
        <button type="submit">Scrape</button>
    </form>
    <br>
    @if(isset($results))
        @if(count($results) > 0)
            <h2>Search Results</h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Location</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($results as $result)
                        <tr>
                            <td>{{ $result['name'] }}</td>
                            <td>{{ $result['age'] }}</td>
                            <td>{{ $result['location'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No results found.</p>
        @endif
    @endif
</body>
</html>