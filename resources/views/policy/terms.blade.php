<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Terms of Service
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="prose max-w-none">
                        <p class="text-sm text-gray-500 mb-6">Last Updated: {{ now()->format('F d, Y') }}</p>

                        <h3 class="text-lg font-semibold mb-3">1. Acceptance of Terms</h3>
                        <p class="mb-4">
                            By accessing and using Community Platform ("the Service"), you accept and agree to be bound by the terms and provision of this agreement.
                        </p>

                        <h3 class="text-lg font-semibold mb-3">2. Use of Service</h3>
                        <p class="mb-4">
                            You must be at least 18 years old to use this Service. You are responsible for maintaining the confidentiality of your account and password.
                            You agree to accept responsibility for all activities that occur under your account.
                        </p>

                        <h3 class="text-lg font-semibold mb-3">3. User Content</h3>
                        <p class="mb-4">
                            You retain ownership of any content you submit, post or display on or through the Service. By submitting content, you grant us a worldwide,
                            non-exclusive, royalty-free license to use, copy, reproduce, process, adapt, and display such content in connection with providing the Service.
                        </p>

                        <h3 class="text-lg font-semibold mb-3">4. Investment Disclaimer</h3>
                        <p class="mb-4 bg-yellow-50 border-l-4 border-yellow-400 p-4">
                            <strong>Important:</strong> Stock and options recommendations provided on this platform are for informational and educational purposes only.
                            They do not constitute financial advice. Always consult with a qualified financial advisor before making investment decisions.
                            Past performance does not guarantee future results. Investing involves risk, including the potential loss of principal.
                        </p>

                        <h3 class="text-lg font-semibold mb-3">5. Prohibited Activities</h3>
                        <p class="mb-2">You agree not to:</p>
                        <ul class="list-disc pl-6 mb-4">
                            <li>Violate any laws or regulations</li>
                            <li>Post offensive, abusive, or inappropriate content</li>
                            <li>Impersonate others or misrepresent your affiliation</li>
                            <li>Spam or harass other users</li>
                            <li>Attempt to gain unauthorized access to the Service</li>
                            <li>Share your account credentials with others</li>
                        </ul>

                        <h3 class="text-lg font-semibold mb-3">6. Subscription and Payment</h3>
                        <p class="mb-4">
                            Certain features of the Service require a paid subscription. Subscriptions automatically renew unless cancelled before the renewal date.
                            We reserve the right to change our pricing at any time with notice to active subscribers.
                        </p>

                        <h3 class="text-lg font-semibold mb-3">7. Account Termination</h3>
                        <p class="mb-4">
                            We reserve the right to suspend or terminate your account at any time for violations of these Terms of Service or for any other reason at our discretion.
                        </p>

                        <h3 class="text-lg font-semibold mb-3">8. Limitation of Liability</h3>
                        <p class="mb-4">
                            The Service is provided "as is" without warranties of any kind. We shall not be liable for any damages arising from the use or inability to use the Service,
                            including but not limited to investment losses based on recommendations provided through the platform.
                        </p>

                        <h3 class="text-lg font-semibold mb-3">9. Privacy</h3>
                        <p class="mb-4">
                            Your use of the Service is also governed by our Privacy Policy. We collect and use information as described in our Privacy Policy.
                        </p>

                        <h3 class="text-lg font-semibold mb-3">10. Changes to Terms</h3>
                        <p class="mb-4">
                            We reserve the right to modify these terms at any time. Changes will be effective immediately upon posting.
                            Your continued use of the Service constitutes acceptance of the modified terms.
                        </p>

                        <h3 class="text-lg font-semibold mb-3">11. Third-Party Services</h3>
                        <p class="mb-4">
                            The Service may integrate with third-party services (such as Google and Facebook for authentication, and Schwab for market data).
                            Your use of these third-party services is subject to their respective terms of service.
                        </p>

                        <h3 class="text-lg font-semibold mb-3">12. Contact Information</h3>
                        <p class="mb-4">
                            If you have any questions about these Terms of Service, please contact us at:
                            <a href="mailto:hello@example.com" class="text-indigo-600 hover:text-indigo-800">hello@example.com</a>
                        </p>

                        <div class="mt-8 pt-8 border-t border-gray-200">
                            <p class="text-sm text-gray-600">
                                By using Community Platform, you acknowledge that you have read, understood, and agree to be bound by these Terms of Service.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
