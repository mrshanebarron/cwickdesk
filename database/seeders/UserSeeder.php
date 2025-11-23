<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Fetches user data from Snipe-IT encrypted API endpoint
     * and imports them into the IT Management System
     */
    public function run(): void
    {
        // API configuration (same as phonelist)
        $sharedKey = base64_decode('cJ7nEpn8S3eCzXpiBqvNvmLd7ntrz8RZSGbtL9iQgIM=');
        $authKey = 'uD3rA9XqLp6YzbNf';
        $apiUrl = "https://it.daniellehub.com/useroutput/$authKey";

        $this->command->info('Fetching user data from Snipe-IT API...');

        // Fetch encrypted data from API
        $response = file_get_contents($apiUrl);
        if (!$response) {
            $this->command->error('❌ Failed to fetch data from Snipe-IT API');
            return;
        }

        $parsed = json_decode($response, true);
        if (!isset($parsed['iv'], $parsed['data'])) {
            $this->command->error('❌ Invalid API response format');
            return;
        }

        // Decrypt the data
        $iv = base64_decode($parsed['iv']);
        $encrypted = $parsed['data'];
        $decryptedJson = openssl_decrypt($encrypted, 'AES-256-CBC', $sharedKey, 0, $iv);

        if (!$decryptedJson) {
            $this->command->error('❌ Failed to decrypt user data');
            return;
        }

        $users = json_decode($decryptedJson, true);

        if (!is_array($users)) {
            $this->command->error('❌ Decrypted data is not valid JSON');
            return;
        }

        $this->command->info("📥 Found " . count($users) . " users from Snipe-IT");

        // Clear existing users (except the first super admin if exists)
        $this->command->info('Clearing existing users...');
        DB::table('users')->where('id', '>', 1)->delete();

        $imported = 0;
        $skipped = 0;

        // Import each user
        foreach ($users as $userData) {
            // Skip users without email
            if (empty($userData['email'])) {
                $skipped++;
                continue;
            }

            // Create or update user
            $user = User::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'] ?? 'Unknown',
                    'password' => !empty($userData['plain_text_password'])
                        ? bcrypt($userData['plain_text_password'])
                        : null,
                    'extension' => $userData['extension'] ?? null,
                    'cell' => $userData['cell'] ?? null,
                    'direct' => $userData['phone'] ?? null,
                    'department' => $userData['department'] ?? null,
                    'area_of_responsibility' => $userData['jobtitle'] ?? null,
                    'building' => $userData['location'] ?? null,
                ]
            );

            // Assign default 'user' role if user doesn't have any roles
            if ($user->roles()->count() === 0) {
                $user->assignRole('user');
            }

            $imported++;
            $this->command->info("  ✓ {$userData['name']} ({$userData['email']})");
        }

        $this->command->info("✅ Successfully imported $imported users");
        if ($skipped > 0) {
            $this->command->warn("⚠️  Skipped $skipped users (missing email)");
        }
    }
}
