<?php

namespace Database\Seeders;

use App\Models\KbArticle;
use App\Models\KbCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class KbArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get categories
        $categories = [
            'account' => KbCategory::where('slug', 'account-access')->first(),
            'email' => KbCategory::where('slug', 'email-communication')->first(),
            'network' => KbCategory::where('slug', 'network-connectivity')->first(),
            'hardware' => KbCategory::where('slug', 'hardware-devices')->first(),
            'software' => KbCategory::where('slug', 'software-applications')->first(),
            'security' => KbCategory::where('slug', 'passwords-security')->first(),
            'printers' => KbCategory::where('slug', 'printers-scanners')->first(),
            'mobile' => KbCategory::where('slug', 'mobile-devices')->first(),
            'remote' => KbCategory::where('slug', 'remote-access')->first(),
        ];

        // Get first admin user as author
        $author = User::role('super_admin')->first() ?? User::first();

        if (!$author) {
            $this->command->error('No users found. Please run UserSeeder first.');
            return;
        }

        $articles = [
            // Account & Access
            [
                'category' => $categories['account'],
                'title' => 'How to Reset Your Password',
                'excerpt' => 'Step-by-step guide to resetting your account password',
                'content' => '<h2>Resetting Your Password</h2>
                <p>If you\'ve forgotten your password or need to reset it for security reasons, follow these simple steps:</p>

                <h3>Step 1: Navigate to the Login Page</h3>
                <p>Go to the company login page and click on the "Forgot Password?" link below the login button.</p>

                <h3>Step 2: Enter Your Email</h3>
                <p>Enter the email address associated with your account. Make sure to use your company email address.</p>

                <h3>Step 3: Check Your Email</h3>
                <p>You\'ll receive a password reset link via email within a few minutes. Check your spam folder if you don\'t see it in your inbox.</p>

                <h3>Step 4: Create a New Password</h3>
                <p>Click the link in the email and create a new password. Your password must:</p>
                <ul>
                    <li>Be at least 8 characters long</li>
                    <li>Include uppercase and lowercase letters</li>
                    <li>Include at least one number</li>
                    <li>Include at least one special character (@, #, $, etc.)</li>
                </ul>

                <h3>Still Having Issues?</h3>
                <p>If you\'re still unable to reset your password, please submit a support ticket or call the IT help desk at Ext. 4357.</p>',
                'is_featured' => true,
            ],
            [
                'category' => $categories['account'],
                'title' => 'Setting Up Two-Factor Authentication (2FA)',
                'excerpt' => 'Secure your account with two-factor authentication',
                'content' => '<h2>What is Two-Factor Authentication?</h2>
                <p>Two-factor authentication (2FA) adds an extra layer of security to your account by requiring both your password and a verification code from your phone.</p>

                <h3>How to Enable 2FA</h3>
                <ol>
                    <li>Log in to your account</li>
                    <li>Go to Account Settings → Security</li>
                    <li>Click "Enable Two-Factor Authentication"</li>
                    <li>Download an authenticator app (Google Authenticator, Microsoft Authenticator, or Authy)</li>
                    <li>Scan the QR code with your authenticator app</li>
                    <li>Enter the 6-digit code from your app to confirm</li>
                    <li>Save your backup codes in a secure location</li>
                </ol>

                <h3>Using 2FA to Log In</h3>
                <p>Once enabled, you\'ll enter your password as normal, then provide the 6-digit code from your authenticator app.</p>

                <h3>Lost Your Phone?</h3>
                <p>If you\'ve lost access to your authenticator app, use one of your backup codes or contact IT support for assistance.</p>',
                'is_featured' => false,
            ],

            // Email & Communication
            [
                'category' => $categories['email'],
                'title' => 'Setting Up Email on Your Phone',
                'excerpt' => 'Configure company email on iPhone or Android',
                'content' => '<h2>Email Setup for Mobile Devices</h2>
                <p>Follow these instructions to set up your company email on your smartphone.</p>

                <h3>For iPhone/iPad:</h3>
                <ol>
                    <li>Open Settings → Mail → Accounts</li>
                    <li>Tap "Add Account" → Select "Microsoft Exchange"</li>
                    <li>Enter your company email address</li>
                    <li>Enter your password</li>
                    <li>Enter server details if prompted:
                        <ul>
                            <li>Server: outlook.office365.com</li>
                            <li>Domain: (leave blank)</li>
                        </ul>
                    </li>
                    <li>Choose what to sync (Mail, Contacts, Calendars)</li>
                    <li>Tap "Save"</li>
                </ol>

                <h3>For Android:</h3>
                <ol>
                    <li>Open Gmail or Email app</li>
                    <li>Tap Menu → Settings → Add Account</li>
                    <li>Select "Exchange and Office 365"</li>
                    <li>Enter your company email and password</li>
                    <li>Follow the prompts to complete setup</li>
                </ol>

                <h3>Need Help?</h3>
                <p>If you encounter any errors during setup, contact IT support with your device model and the error message.</p>',
                'is_featured' => true,
            ],
            [
                'category' => $categories['email'],
                'title' => 'How to Report Spam or Phishing Emails',
                'excerpt' => 'Learn to identify and report suspicious emails',
                'content' => '<h2>Identifying Phishing Emails</h2>
                <p>Phishing emails attempt to steal your credentials or install malware. Watch for these red flags:</p>

                <h3>Warning Signs:</h3>
                <ul>
                    <li>Urgent requests for passwords or personal information</li>
                    <li>Unexpected attachments or links</li>
                    <li>Suspicious sender email addresses</li>
                    <li>Poor grammar or spelling</li>
                    <li>Requests to verify account information</li>
                    <li>Too-good-to-be-true offers</li>
                </ul>

                <h3>What to Do:</h3>
                <ol>
                    <li><strong>Don\'t click</strong> any links or open attachments</li>
                    <li><strong>Don\'t reply</strong> to the email</li>
                    <li><strong>Forward</strong> the email to IT security</li>
                    <li><strong>Delete</strong> the email from your inbox</li>
                </ol>

                <h3>Reporting Phishing:</h3>
                <p>Use the "Report Phishing" button in Outlook or forward suspicious emails to: <strong>security@company.com</strong></p>

                <blockquote>
                <p><strong>Remember:</strong> IT will NEVER ask for your password via email. When in doubt, call us at Ext. 4357 to verify.</p>
                </blockquote>',
                'is_featured' => true,
            ],

            // Network & Connectivity
            [
                'category' => $categories['network'],
                'title' => 'Troubleshooting WiFi Connection Issues',
                'excerpt' => 'Common WiFi problems and how to fix them',
                'content' => '<h2>WiFi Not Working? Try These Steps</h2>

                <h3>Step 1: Check the Basics</h3>
                <ul>
                    <li>Is WiFi enabled on your device?</li>
                    <li>Are you connected to the correct network?</li>
                    <li>Is airplane mode turned off?</li>
                </ul>

                <h3>Step 2: Restart Your Connection</h3>
                <ol>
                    <li>Turn WiFi off and back on</li>
                    <li>Forget the network and reconnect</li>
                    <li>Restart your device</li>
                </ol>

                <h3>Step 3: Check Network Status</h3>
                <p>Visit our network status page or ask nearby colleagues if they\'re experiencing issues. A wider outage requires different troubleshooting.</p>

                <h3>Step 4: Advanced Troubleshooting</h3>
                <p><strong>Windows:</strong></p>
                <ol>
                    <li>Open Command Prompt as Administrator</li>
                    <li>Run: <code>ipconfig /release</code></li>
                    <li>Run: <code>ipconfig /renew</code></li>
                    <li>Run: <code>ipconfig /flushdns</code></li>
                </ol>

                <p><strong>Mac:</strong></p>
                <ol>
                    <li>System Settings → Network → WiFi</li>
                    <li>Click "Advanced" → "Renew DHCP Lease"</li>
                </ol>

                <h3>Still Not Working?</h3>
                <p>Submit a support ticket with:< /p>
                <ul>
                    <li>Your device type and model</li>
                    <li>Your location in the building</li>
                    <li>When the issue started</li>
                    <li>Any error messages</li>
                </ul>',
                'is_featured' => true,
            ],
            [
                'category' => $categories['network'],
                'title' => 'Connecting to the Guest WiFi Network',
                'excerpt' => 'How to connect visitors to the guest network',
                'content' => '<h2>Guest WiFi Access</h2>
                <p>Our guest WiFi network allows visitors secure internet access without accessing company resources.</p>

                <h3>For Guests:</h3>
                <ol>
                    <li>Connect to the "CompanyName-Guest" network</li>
                    <li>Open a web browser - you\'ll be redirected to the login page</li>
                    <li>Enter the guest access code provided by your host</li>
                    <li>Accept the terms and conditions</li>
                    <li>You\'re connected!</li>
                </ol>

                <h3>For Employees Hosting Guests:</h3>
                <p>To get a guest WiFi code:</p>
                <ol>
                    <li>Submit a ticket requesting guest WiFi access</li>
                    <li>Include: guest name, company, and duration of visit</li>
                    <li>IT will provide a temporary access code</li>
                    <li>Share the code with your guest</li>
                </ol>

                <h3>Access Duration:</h3>
                <ul>
                    <li>Daily codes: Valid for 24 hours</li>
                    <li>Weekly codes: Valid for 7 days</li>
                    <li>Event codes: Valid for specified event duration</li>
                </ul>

                <p><strong>Note:</strong> Guest network has limited access and does not connect to company resources or printers.</p>',
                'is_featured' => false,
            ],

            // Hardware & Devices
            [
                'category' => $categories['hardware'],
                'title' => 'Requesting New Hardware or Equipment',
                'excerpt' => 'How to request new computers, monitors, keyboards, and peripherals',
                'content' => '<h2>Hardware Request Process</h2>
                <p>Need new equipment? Follow this process to request hardware.</p>

                <h3>What You Can Request:</h3>
                <ul>
                    <li>Desktop computers</li>
                    <li>Laptops</li>
                    <li>Monitors and docking stations</li>
                    <li>Keyboards and mice</li>
                    <li>Headsets and webcams</li>
                    <li>Mobile devices (phones/tablets)</li>
                    <li>Specialized equipment</li>
                </ul>

                <h3>Request Process:</h3>
                <ol>
                    <li>Submit a support ticket with "Hardware Request" as the subject</li>
                    <li>Include:
                        <ul>
                            <li>What equipment you need</li>
                            <li>Business justification</li>
                            <li>Urgency level</li>
                            <li>Budget/cost center (if known)</li>
                        </ul>
                    </li>
                    <li>IT will review and get manager approval if needed</li>
                    <li>You\'ll receive a timeline for procurement and setup</li>
                </ol>

                <h3>Typical Timelines:</h3>
                <ul>
                    <li>In-stock items: 1-2 business days</li>
                    <li>Standard orders: 5-10 business days</li>
                    <li>Custom/specialized equipment: 2-4 weeks</li>
                </ul>

                <h3>Emergency Replacements:</h3>
                <p>If your equipment fails and you need an immediate replacement, call the IT help desk at Ext. 4357. We maintain spare equipment for emergencies.</p>',
                'is_featured' => false,
            ],
            [
                'category' => $categories['hardware'],
                'title' => 'Connecting an External Monitor',
                'excerpt' => 'Set up a second monitor for your workstation',
                'content' => '<h2>Adding a Second Monitor</h2>
                <p>Boost your productivity with a dual monitor setup.</p>

                <h3>Connection Steps:</h3>
                <ol>
                    <li>Locate the video port on your computer (HDMI, DisplayPort, USB-C, or VGA)</li>
                    <li>Connect the appropriate cable from the monitor to your computer</li>
                    <li>Connect the monitor\'s power cable and turn it on</li>
                    <li>Your computer should automatically detect the monitor</li>
                </ol>

                <h3>Configuring Display Settings:</h3>

                <p><strong>Windows:</strong></p>
                <ol>
                    <li>Right-click on desktop → Display Settings</li>
                    <li>Click "Identify" to see which monitor is which</li>
                    <li>Choose display mode:
                        <ul>
                            <li><strong>Extend:</strong> Separate desktops (recommended)</li>
                            <li><strong>Duplicate:</strong> Same content on both screens</li>
                            <li><strong>Second screen only:</strong> Use external monitor only</li>
                        </ul>
                    </li>
                    <li>Drag and drop monitor icons to match physical arrangement</li>
                    <li>Adjust resolution if needed</li>
                </ol>

                <p><strong>Mac:</strong></p>
                <ol>
                    <li>System Settings → Displays</li>
                    <li>Click "Arrange" to position displays</li>
                    <li>Drag white menu bar to set primary display</li>
                    <li>Adjust resolution in "Display Settings"</li>
                </ol>

                <h3>Troubleshooting:</h3>
                <ul>
                    <li><strong>No signal:</strong> Check cable connections and input source on monitor</li>
                    <li><strong>Wrong resolution:</strong> Update graphics drivers</li>
                    <li><strong>Flickering:</strong> Try a different cable or port</li>
                </ul>',
                'is_featured' => false,
            ],

            // Software & Applications
            [
                'category' => $categories['software'],
                'title' => 'How to Request New Software Installation',
                'excerpt' => 'Process for requesting software licenses and installations',
                'content' => '<h2>Software Installation Requests</h2>
                <p>Need new software? Here\'s how to request it.</p>

                <h3>Before You Request:</h3>
                <ul>
                    <li>Check if the software is already available in the company catalog</li>
                    <li>Verify you have a business need for the software</li>
                    <li>Check if a free alternative exists</li>
                    <li>Get manager approval for paid software</li>
                </ul>

                <h3>Request Process:</h3>
                <ol>
                    <li>Submit a support ticket with:
                        <ul>
                            <li>Software name and version</li>
                            <li>Business justification</li>
                            <li>URL to software vendor</li>
                            <li>Licensing requirements (one-time vs. subscription)</li>
                            <li>Estimated cost (if known)</li>
                        </ul>
                    </li>
                    <li>IT will review for:
                        <ul>
                            <li>Security compliance</li>
                            <li>License availability</li>
                            <li>Compatibility with existing systems</li>
                        </ul>
                    </li>
                    <li>If approved, IT will schedule installation</li>
                </ol>

                <h3>Self-Service Software:</h3>
                <p>The following approved software can be installed from the company software center:</p>
                <ul>
                    <li>Microsoft Office Suite</li>
                    <li>Adobe Acrobat Reader</li>
                    <li>Google Chrome</li>
                    <li>Mozilla Firefox</li>
                    <li>Zoom</li>
                    <li>Slack</li>
                </ul>

                <h3>Security Notice:</h3>
                <blockquote>
                <p><strong>Never download or install unauthorized software.</strong> All software must be approved by IT to ensure security and compliance.</p>
                </blockquote>',
                'is_featured' => true,
            ],

            // Security
            [
                'category' => $categories['security'],
                'title' => 'Creating Strong Passwords',
                'excerpt' => 'Best practices for secure password creation',
                'content' => '<h2>Password Security Best Practices</h2>
                <p>Strong passwords are your first line of defense against unauthorized access.</p>

                <h3>Password Requirements:</h3>
                <ul>
                    <li>Minimum 12 characters (longer is better)</li>
                    <li>Mix of uppercase and lowercase letters</li>
                    <li>Include numbers and special characters</li>
                    <li>Avoid dictionary words</li>
                    <li>Don\'t use personal information</li>
                </ul>

                <h3>Creating Memorable Strong Passwords:</h3>
                <p><strong>Method 1: Passphrase</strong></p>
                <p>Use a sentence and take the first letter of each word:</p>
                <p>Example: "I love to drink 2 cups of coffee every morning at 8am!"<br>
                Password: <code>Iltd2co cema8a!</code></p>

                <p><strong>Method 2: Random Words</strong></p>
                <p>Combine 4-5 unrelated words with numbers/symbols:</p>
                <p>Example: <code>Purple7$Elephant#Bicycle42</code></p>

                <h3>What NOT to Do:</h3>
                <ul>
                    <li>❌ Don\'t use the same password across multiple sites</li>
                    <li>❌ Don\'t share passwords with colleagues</li>
                    <li>❌ Don\'t write passwords on sticky notes</li>
                    <li>❌ Don\'t use sequential numbers (123456)</li>
                    <li>❌ Don\'t use common patterns (qwerty, password)</li>
                </ul>

                <h3>Password Manager:</h3>
                <p>We recommend using a password manager to:</p>
                <ul>
                    <li>Generate strong random passwords</li>
                    <li>Store passwords securely</li>
                    <li>Auto-fill login forms</li>
                    <li>Sync across devices</li>
                </ul>

                <p>Approved password managers: LastPass, 1Password, Dashlane</p>',
                'is_featured' => true,
            ],

            // Printers & Scanners
            [
                'category' => $categories['printers'],
                'title' => 'How to Connect to Network Printers',
                'excerpt' => 'Set up network printers on your computer',
                'content' => '<h2>Network Printer Setup</h2>
                <p>Connect to shared office printers from your computer.</p>

                <h3>Windows Setup:</h3>
                <ol>
                    <li>Open Settings → Devices → Printers & Scanners</li>
                    <li>Click "Add a printer or scanner"</li>
                    <li>Wait for available printers to appear</li>
                    <li>Select your desired printer and click "Add device"</li>
                    <li>Print a test page to confirm</li>
                </ol>

                <h3>Mac Setup:</h3>
                <ol>
                    <li>System Settings → Printers & Scanners</li>
                    <li>Click the "+" button</li>
                    <li>Select printer from the list</li>
                    <li>Click "Add"</li>
                    <li>Print a test page</li>
                </ol>

                <h3>Available Printers by Location:</h3>
                <table>
                    <tr>
                        <th>Location</th>
                        <th>Printer Name</th>
                        <th>Color/B&W</th>
                    </tr>
                    <tr>
                        <td>1st Floor - Main</td>
                        <td>HP-LaserJet-1F</td>
                        <td>B&W</td>
                    </tr>
                    <tr>
                        <td>2nd Floor - North</td>
                        <td>HP-Color-2N</td>
                        <td>Color</td>
                    </tr>
                    <tr>
                        <td>2nd Floor - South</td>
                        <td>HP-LaserJet-2S</td>
                        <td>B&W</td>
                    </tr>
                </table>

                <h3>Default Printer:</h3>
                <p>Set your most-used printer as default to save time:</p>
                <ul>
                    <li><strong>Windows:</strong> Right-click printer → Set as default</li>
                    <li><strong>Mac:</strong> System Settings → Printers → Default printer dropdown</li>
                </ul>',
                'is_featured' => false,
            ],
            [
                'category' => $categories['printers'],
                'title' => 'Troubleshooting Common Printer Problems',
                'excerpt' => 'Fix paper jams, print quality, and connection issues',
                'content' => '<h2>Printer Troubleshooting Guide</h2>

                <h3>Printer Not Responding</h3>
                <ol>
                    <li>Check if printer is powered on</li>
                    <li>Verify network cable is connected (or WiFi is active)</li>
                    <li>Restart the print spooler:
                        <ul>
                            <li>Windows: Services → Print Spooler → Restart</li>
                            <li>Mac: System Settings → Printers → Reset printing system</li>
                        </ul>
                    </li>
                    <li>Remove and re-add the printer</li>
                </ol>

                <h3>Paper Jams</h3>
                <ol>
                    <li>Turn off the printer</li>
                    <li>Open all access panels</li>
                    <li>Gently remove jammed paper in the direction of paper flow</li>
                    <li>Check for torn pieces</li>
                    <li>Close panels and restart printer</li>
                    <li>Run a test print</li>
                </ol>

                <h3>Poor Print Quality</h3>
                <p><strong>Faded prints:</strong></p>
                <ul>
                    <li>Check toner/ink levels</li>
                    <li>Run printer cleaning cycle</li>
                    <li>Replace toner cartridge if low</li>
                </ul>

                <p><strong>Streaks or spots:</strong></p>
                <ul>
                    <li>Clean printer rollers</li>
                    <li>Run automatic cleaning</li>
                    <li>Check for damaged drum</li>
                </ul>

                <h3>Print Job Stuck in Queue</h3>
                <ol>
                    <li>Open print queue</li>
                    <li>Cancel all documents</li>
                    <li>Restart print spooler service</li>
                    <li>Try printing again</li>
                </ol>

                <h3>When to Contact IT:</h3>
                <ul>
                    <li>Error codes displayed on printer</li>
                    <li>Persistent quality issues after cleaning</li>
                    <li>Hardware malfunctions (noises, burning smell)</li>
                    <li>Network connectivity issues</li>
                </ul>',
                'is_featured' => false,
            ],

            // Mobile Devices
            [
                'category' => $categories['mobile'],
                'title' => 'Mobile Device Security Guidelines',
                'excerpt' => 'Keep your mobile devices secure',
                'content' => '<h2>Mobile Security Best Practices</h2>
                <p>Protect company data on your mobile devices.</p>

                <h3>Device Security Requirements:</h3>
                <ul>
                    <li>Enable strong passcode (6+ digits or biometric)</li>
                    <li>Set auto-lock to 5 minutes or less</li>
                    <li>Enable Find My Device/Find My iPhone</li>
                    <li>Keep iOS/Android updated to latest version</li>
                    <li>Encrypt device storage</li>
                </ul>

                <h3>App Security:</h3>
                <ul>
                    <li>Only install apps from official stores (App Store/Play Store)</li>
                    <li>Review app permissions before installing</li>
                    <li>Keep apps updated</li>
                    <li>Remove unused apps</li>
                    <li>Don\'t jailbreak or root your device</li>
                </ul>

                <h3>Email & Data:</h3>
                <ul>
                    <li>Don\'t forward company emails to personal accounts</li>
                    <li>Use company VPN on public WiFi</li>
                    <li>Enable remote wipe capability</li>
                    <li>Back up important data</li>
                    <li>Don\'t store sensitive files on device</li>
                </ul>

                <h3>Lost or Stolen Device:</h3>
                <ol>
                    <li><strong>Immediately</strong> contact IT at Ext. 4357</li>
                    <li>We\'ll remotely wipe company data</li>
                    <li>Change your passwords</li>
                    <li>File a police report if stolen</li>
                    <li>Contact your carrier to suspend service</li>
                </ol>

                <blockquote>
                <p><strong>Remember:</strong> Mobile devices are targets for thieves and hackers. Always treat them as if they contain sensitive company data - because they do!</p>
                </blockquote>',
                'is_featured' => false,
            ],

            // Remote Access
            [
                'category' => $categories['remote'],
                'title' => 'Setting Up VPN for Remote Work',
                'excerpt' => 'Connect securely to company resources from home',
                'content' => '<h2>VPN Setup Guide</h2>
                <p>Access company resources securely when working remotely.</p>

                <h3>What is VPN?</h3>
                <p>A Virtual Private Network (VPN) creates a secure, encrypted connection between your device and the company network, allowing you to access internal resources safely from anywhere.</p>

                <h3>Installation Steps:</h3>
                <ol>
                    <li>Submit a ticket requesting VPN access</li>
                    <li>IT will verify your approval with your manager</li>
                    <li>You\'ll receive VPN credentials and software download link via email</li>
                    <li>Download and install the VPN client</li>
                    <li>Enter your credentials when prompted</li>
                    <li>Click "Connect" to establish VPN tunnel</li>
                </ol>

                <h3>Using the VPN:</h3>
                <p><strong>When to Connect:</strong></p>
                <ul>
                    <li>Accessing internal file shares</li>
                    <li>Using company applications</li>
                    <li>Checking internal websites</li>
                    <li>On public WiFi networks</li>
                </ul>

                <p><strong>When VPN is NOT Needed:</strong></p>
                <ul>
                    <li>Checking web-based email (Office 365)</li>
                    <li>General internet browsing</li>
                    <li>Cloud applications (Salesforce, etc.)</li>
                </ul>

                <h3>Troubleshooting:</h3>
                <p><strong>Cannot connect:</strong></p>
                <ul>
                    <li>Check internet connection</li>
                    <li>Verify credentials are correct</li>
                    <li>Restart VPN client</li>
                    <li>Check firewall isn\'t blocking VPN</li>
                </ul>

                <p><strong>Slow connection:</strong></p>
                <ul>
                    <li>Disconnect and reconnect</li>
                    <li>Choose different VPN server</li>
                    <li>Check your internet speed</li>
                    <li>Close unnecessary applications</li>
                </ul>

                <h3>Security Reminders:</h3>
                <ul>
                    <li>Never share your VPN credentials</li>
                    <li>Disconnect when not actively using company resources</li>
                    <li>Always use VPN on public WiFi</li>
                    <li>Report suspicious VPN behavior immediately</li>
                </ul>',
                'is_featured' => true,
            ],
        ];

        $count = 0;
        foreach ($articles as $article) {
            KbArticle::create([
                'category_id' => $article['category']->id,
                'author_id' => $author->id,
                'title' => $article['title'],
                'slug' => Str::slug($article['title']),
                'content' => $article['content'],
                'excerpt' => $article['excerpt'],
                'is_published' => true,
                'is_featured' => $article['is_featured'],
                'published_at' => now(),
                'view_count' => rand(5, 150), // Random view counts for realism
            ]);

            $count++;
            $this->command->info("✓ Created article: {$article['title']}");
        }

        $this->command->info("✅ Created $count knowledge base articles");
    }
}
