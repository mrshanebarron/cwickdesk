<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to CwickDesk!</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-2xl w-full">
            <!-- Success Icon -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-green-100 rounded-full mb-6">
                    <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Welcome to CwickDesk!</h1>
                <p class="text-xl text-gray-600">Your account has been created successfully</p>
            </div>

            <!-- Account Details -->
            <div class="bg-white rounded-lg shadow-md p-8 mb-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Your Account Details</h2>

                <div class="space-y-4">
                    <div class="flex justify-between py-3 border-b">
                        <span class="text-gray-600">Company:</span>
                        <span class="font-semibold">{{ $tenant->name }}</span>
                    </div>
                    <div class="flex justify-between py-3 border-b">
                        <span class="text-gray-600">Plan:</span>
                        <span class="font-semibold capitalize">{{ $tenant->plan }}</span>
                    </div>
                    <div class="flex justify-between py-3 border-b">
                        <span class="text-gray-600">Trial Ends:</span>
                        <span class="font-semibold">{{ $tenant->trial_ends_at->format('F j, Y') }}</span>
                    </div>
                    <div class="flex justify-between py-3">
                        <span class="text-gray-600">Your URL:</span>
                        <a href="{{ $loginUrl }}" class="font-semibold text-blue-600 hover:text-blue-800">
                            {{ $tenant->domain }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Next Steps -->
            <div class="bg-blue-50 rounded-lg p-8 mb-6">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Next Steps</h3>
                <ol class="space-y-3">
                    <li class="flex items-start">
                        <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center mr-3 flex-shrink-0 text-sm font-semibold">1</span>
                        <div>
                            <strong>Log in to your account</strong>
                            <p class="text-gray-600 text-sm">Use the link below to access your CwickDesk portal</p>
                        </div>
                    </li>
                    <li class="flex items-start">
                        <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center mr-3 flex-shrink-0 text-sm font-semibold">2</span>
                        <div>
                            <strong>Add your team members</strong>
                            <p class="text-gray-600 text-sm">Invite colleagues and assign roles</p>
                        </div>
                    </li>
                    <li class="flex items-start">
                        <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center mr-3 flex-shrink-0 text-sm font-semibold">3</span>
                        <div>
                            <strong>Import your assets</strong>
                            <p class="text-gray-600 text-sm">Add hardware, software, and equipment to track</p>
                        </div>
                    </li>
                    <li class="flex items-start">
                        <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center mr-3 flex-shrink-0 text-sm font-semibold">4</span>
                        <div>
                            <strong>Create your first ticket</strong>
                            <p class="text-gray-600 text-sm">Test the service desk and explore features</p>
                        </div>
                    </li>
                </ol>
            </div>

            <!-- CTA Button -->
            <div class="text-center">
                <a href="{{ $loginUrl }}" class="inline-block bg-blue-600 text-white px-8 py-3 rounded-md text-lg font-semibold hover:bg-blue-700">
                    Go to Your CwickDesk Portal
                </a>
            </div>

            <!-- Trial Information -->
            <div class="mt-8 bg-white rounded-lg shadow-md p-6">
                <h4 class="font-semibold text-gray-900 mb-2">About Your 14-Day Free Trial</h4>
                <ul class="space-y-2 text-gray-600 text-sm">
                    <li>✓ Full access to all {{ ucfirst($tenant->plan) }} plan features</li>
                    <li>✓ No credit card charges until trial ends on {{ $tenant->trial_ends_at->format('F j, Y') }}</li>
                    <li>✓ Cancel anytime during trial with no charges</li>
                    <li>✓ Email support available during trial period</li>
                </ul>
            </div>

            <!-- Support -->
            <div class="mt-8 text-center text-gray-600">
                <p class="mb-2">Need help getting started?</p>
                <a href="mailto:support@cwick.us" class="text-blue-600 hover:text-blue-800 font-semibold">
                    Contact Support
                </a>
            </div>
        </div>
    </div>
</body>
</html>
