<?php
// Temporary password reset script for development
// DELETE THIS FILE AFTER USE!

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Replace 'your_email@example.com' with your actual email
$email = 'amirbutt@basepracticesupport.co.uk';
$newPassword = '123123';

try {
    $user = User::where('email', $email)->first();
    
    if ($user) {
        $user->password = Hash::make($newPassword);
        $user->save();
        
        echo "Password reset successfully for: " . $email . "\n";
        echo "New password: " . $newPassword . "\n";
    } else {
        echo "User not found with email: " . $email . "\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\nIMPORTANT: Delete this file after use for security!\n";
?>











