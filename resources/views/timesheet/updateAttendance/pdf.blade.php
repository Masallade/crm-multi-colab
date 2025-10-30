<!DOCTYPE html>
<html>
<head>
    <title>Attendance Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }
        h1 {
            text-align: center;
            color: #333;
        }
    </style>
</head>
<body>
    <h1>Attendance Report</h1>

    <table>
        <thead>
            <tr>
                <th>Employee</th>
                <th>In Time</th>
                <th>Out Time</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $row)
            <tr>
                <td>{{ $row->employee->first_name }} {{ $row->employee->last_name }}</td>
                <td>{{ $row->clock_in }}</td>
                <td>{{ $row->clock_out }}</td>
                <td>{{ $row->attendance_date }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html> 