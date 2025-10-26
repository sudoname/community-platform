<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Facebook Data Deletion Instructions
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="prose max-w-none">
                        <p class="text-sm text-gray-500 mb-6">
                            This page provides instructions for deleting your data collected through Facebook Login.
                        </p>

                        @if(request('confirmation'))
                            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-400">
                                <h3 class="text-lg font-semibold text-green-800 mb-2">Data Deletion Request Received</h3>
                                <p class="text-green-700 mb-2">Your data deletion request has been received and logged.</p>
                                <p class="text-sm text-green-600">Confirmation Code: <strong>{{ request('confirmation') }}</strong></p>
                            </div>
                        @endif

                        <h3 class="text-lg font-semibold mb-3">What Data We Collect via Facebook</h3>
                        <p class="mb-4">
                            When you sign in to Community Platform using Facebook Login, we collect:
                        </p>
                        <ul class="list-disc pl-6 mb-4">
                            <li>Your name</li>
                            <li>Your email address</li>
                            <li>Your Facebook profile picture</li>
                            <li>Your Facebook User ID</li>
                        </ul>

                        <h3 class="text-lg font-semibold mb-3">How to Delete Your Data</h3>
                        <p class="mb-4">
                            To delete your data from Community Platform, you have two options:
                        </p>

                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-4">
                            <h4 class="font-semibold text-blue-800 mb-2">Option 1: Delete Your Account (Recommended)</h4>
                            <ol class="list-decimal pl-6 text-blue-900">
                                <li class="mb-2">
                                    <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">Log in to your account</a>
                                </li>
                                <li class="mb-2">Go to your Profile Settings</li>
                                <li class="mb-2">Scroll to the bottom and click "Delete Account"</li>
                                <li>Confirm the deletion</li>
                            </ol>
                            <p class="text-sm text-blue-700 mt-2">
                                This will permanently delete all your data, including your profile, posts, and activity.
                            </p>
                        </div>

                        <div class="bg-gray-50 border-l-4 border-gray-400 p-4 mb-6">
                            <h4 class="font-semibold text-gray-800 mb-2">Option 2: Contact Us</h4>
                            <p class="text-gray-700 mb-2">
                                Send an email to <a href="mailto:hello@example.com" class="text-indigo-600 hover:text-indigo-800 font-medium">hello@example.com</a>
                                with the subject "Data Deletion Request" and include:
                            </p>
                            <ul class="list-disc pl-6 text-gray-700">
                                <li>The email address associated with your account</li>
                                <li>Your Facebook User ID (if known)</li>
                            </ul>
                            <p class="text-sm text-gray-600 mt-2">
                                We will process your request within 30 days and send you a confirmation email.
                            </p>
                        </div>

                        <h3 class="text-lg font-semibold mb-3">What Happens When You Delete Your Data</h3>
                        <p class="mb-4">When you delete your data:</p>
                        <ul class="list-disc pl-6 mb-4">
                            <li>Your account and profile will be permanently removed</li>
                            <li>All your posts and comments will be deleted</li>
                            <li>Your chat messages will be anonymized</li>
                            <li>Data stored via Facebook Login will be removed from our database</li>
                            <li>You will no longer be able to log in with your Facebook account</li>
                        </ul>

                        <h3 class="text-lg font-semibold mb-3">Data Retention</h3>
                        <p class="mb-4">
                            Some data may be retained for legal compliance purposes (such as transaction records for paid subscriptions) for up to 7 years.
                            However, this data will not be accessible to you or other users and will not be used for any other purpose.
                        </p>

                        <h3 class="text-lg font-semibold mb-3">Questions?</h3>
                        <p class="mb-4">
                            If you have any questions about data deletion or our privacy practices, please contact us at:
                            <a href="mailto:hello@example.com" class="text-indigo-600 hover:text-indigo-800 font-medium">hello@example.com</a>
                        </p>

                        <div class="mt-8 pt-8 border-t border-gray-200">
                            <p class="text-sm text-gray-600">
                                This data deletion policy complies with Facebook Platform Policy
                                <a href="https://developers.facebook.com/docs/facebook-login/permissions/requesting-and-revoking#revokelogin"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="text-indigo-600 hover:text-indigo-800">
                                    Section 5.1.2
                                </a>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
