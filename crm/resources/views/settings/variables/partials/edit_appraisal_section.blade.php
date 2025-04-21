<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Appraisal Section - Base Practice Support</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2c3e50;
            --accent-color: #0d6efd;
            --light-bg: #f7f9fc;
            --border-color: #e9ecef;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--light-bg);
            color: var(--primary-color);
            line-height: 1.6;
            padding: 20px;
        }

        .page-container {
            max-width: 1000px;
            margin: 0 auto;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        .company-header {
            text-align: center;
            margin-bottom: 30px;
            padding: 25px;
            border-bottom: 2px solid var(--accent-color);
        }

        .company-name {
            font-size: 2rem;
            font-weight: 600;
            color: var(--primary-color);
            margin: 0;
        }

        .subtitle {
            font-size: 1.1rem;
            color: #666;
            margin-top: 10px;
        }

        .section-container {
            margin-bottom: 30px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            background-color: white;
            transition: box-shadow 0.2s ease;
        }

        .section-container:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px;
            background-color: #f8f9fa;
            border-bottom: 1px solid var(--border-color);
            border-radius: 8px 8px 0 0;
        }

        .section-title-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-icon {
            color: var(--accent-color);
            font-size: 1.2rem;
        }

        .section-title-input {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--primary-color);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            padding: 8px 12px;
            width: 100%;
            max-width: 400px;
            transition: border-color 0.2s ease;
        }

        .section-title-input:focus {
            outline: none;
            border-color: var(--accent-color);
            box-shadow: 0 0 0 2px rgba(13, 110, 253, 0.25);
        }

        .section-content {
            padding: 20px;
        }

        .indicators-section {
            margin-top: 20px;
        }

        .indicators-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .indicators-title i {
            color: var(--accent-color);
        }

        .indicator-item {
            padding: 16px;
            background-color: white;
            border-left: 3px solid var(--accent-color);
            border-radius: 6px;
            margin-bottom: 12px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            transition: box-shadow 0.2s ease;
        }

        .indicator-item:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .indicator-name {
            margin: 0;
            font-size: 1rem;
            font-weight: 500;
            color: var(--primary-color);
        }

        .indicator-input {
            margin-top: 10px;
            width: 100%;
            padding: 8px 12px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            font-size: 0.9rem;
            transition: border-color 0.2s ease;
        }

        .indicator-input:focus {
            outline: none;
            border-color: var(--accent-color);
            box-shadow: 0 0 0 2px rgba(13, 110, 253, 0.25);
        }

        .btn-save {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: var(--accent-color);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .btn-save:hover {
            background-color: #0b5ed7;
        }

        @media (max-width: 768px) {
            .section-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .section-title-input {
                max-width: 40vw;
            }
        }
    </style>
</head>
<body>
    <div class="page-container">
        <!-- Company Header -->
        <div class="company-header">
            <h1 class="company-name">Base Practice Support</h1>
            <p class="subtitle">Employee Performance Appraisal</p>
        </div>

        <!-- Sections Container -->
        <!-- In your edit_appraisal.blade.php -->
<div id="sectionsContainer">
    <form action="{{ route('update.edit.appraisal.section') }}" method="post" id="edit-section-form">
        @csrf
        @if(isset($sections) && is_array($sections))
            @foreach($sections as $section)
                @include('settings.variables.partials.appraisal_partials.sections', ['section' => $section])
            @endforeach
        @else
            @include('settings.variables.partials.appraisal_partials.section', ['section' => $section])
        @endif

        <!-- Weightage Summary -->
        @if(isset($sections))
        <div class="weightage-summary mt-4">
            <div class="alert alert-info">
                <strong>Total Weightage: <span id="total-weightage">0</span>%</strong> 
                <span id="weightage-warning" class="text-danger d-none">Total must equal exactly 100%</span>
            </div>
        </div>
        @endif


        <button type="submit" class="btn-save">Save Changes</button>
    </form>
</div> 
    </div>
</body>