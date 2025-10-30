<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appraisal Summary</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: linear-gradient(135deg, #2563eb 0%, #7c3aed 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }
        
        .success-card {
            position: relative;
            height: 50vh;
            width: 50vw;
            min-width: 400px;
            max-width: 600px;
            background-color: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            border-radius: 1rem;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: space-evenly;
            align-items: center;
            text-align: center;
        }
        
        .success-badge {
            position: absolute;
            top: -1.25rem;
            padding: 0.5rem 1.5rem;
            background-color: #22c55e;
            color: white;
            font-size: 0.875rem;
            font-weight: 600;
            border-radius: 9999px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .success-title {
            font-size: 1.875rem;
            font-weight: 600;
            color: #1f2937;
            margin: 1rem 0;
        }
        
        .success-message {
            font-size: 1.125rem;
            color: #4b5563;
            padding: 0 1.5rem;
            line-height: 1.6;
        }
        
        .action-button {
            margin-top: 1.5rem;
            padding: 0.75rem 1.5rem;
            background-color: #2563eb;
            color: white;
            font-size: 1.125rem;
            font-weight: 500;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        
        .action-button:hover {
            background-color: #1d4ed8;
        }
        
        @media (max-width: 768px) {
            .success-card {
                width: 90vw;
                min-width: 300px;
                height: auto;
                min-height: 50vh;
            }
        }
    </style>
</head>
<body>

    <div class="success-card">

        <!-- Top Banner -->
        <div class="success-badge">
            Submitted ✅
        </div>

        <!-- Main Content -->
        <h3 class="success-title">
            Congratulations! 🎉
        </h3>
        <p class="success-message">
            Your appraisal summary has been successfully submitted. Our team will review it shortly.
        </p>

        <!-- Action Button -->
        <button class="action-button" onclick="window.history.back()">
            Go Back
        </button>

    </div>

</body>
</html>
