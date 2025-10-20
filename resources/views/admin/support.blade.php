@extends('admin.layouts.app')
@section('page-title', 'Help & Support')

@section('content')
<div class="flex-1 flex flex-col overflow-auto">
    <!-- Header -->
    <header class="bg-white shadow-sm p-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Help & Support</h1>
                <p class="text-gray-600 mt-1">Get assistance and find answers to your questions</p>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="p-6 flex-1 overflow-auto bg-gray-50">

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Contact Support -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform cursor-pointer">
                <div class="w-14 h-14 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mb-4">
                    <i class="fas fa-headset text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-2">Contact Support</h3>
                <p class="text-blue-100 mb-4">Get in touch with our support team</p>
                <a href="mailto:support@touradvisor.com" class="inline-flex items-center text-white font-semibold hover:underline">
                    support@touradvisor.com
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>

            <!-- Live Chat -->
            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform cursor-pointer">
                <div class="w-14 h-14 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mb-4">
                    <i class="fas fa-comments text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-2">Start Chat</h3>
                <p class="text-green-100 mb-4">Chat with us in real-time</p>
                <a href="https://wa.me/971501234567" target="_blank" class="inline-flex items-center text-white font-semibold hover:underline">
                    Start Chat
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>

            <!-- WhatsApp Support -->
            <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform cursor-pointer">
                <div class="w-14 h-14 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mb-4">
                    <i class="fab fa-whatsapp text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-2">WhatsApp</h3>
                <p class="text-emerald-100 mb-4">Message us on WhatsApp</p>
                <a href="https://wa.me/971501234567" target="_blank" class="inline-flex items-center text-white font-semibold hover:underline">
                    +971561325543
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-question-circle text-blue-600 mr-3"></i>
                Frequently Asked Questions
            </h2>

            <div class="space-y-4">
                <!-- FAQ Item 1 -->
                <div class="border border-gray-200 rounded-xl overflow-hidden">
                    <button class="w-full flex items-center justify-between p-4 bg-gray-50 hover:bg-gray-100 transition-colors" onclick="toggleFAQ('faq1')">
                        <span class="font-semibold text-gray-800">How do I create a new booking?</span>
                        <i class="fas fa-chevron-down text-gray-600" id="faq1-icon"></i>
                    </button>
                    <div id="faq1" class="hidden p-4 bg-white">
                        <p class="text-gray-600">
                            To create a new booking, navigate to <strong>Bookings</strong> in the sidebar menu, then click the <strong>"New Booking"</strong> button. Fill in all the required customer information, select a package, enter travel dates, and specify payment details. The system will automatically generate a unique booking reference for you.
                        </p>
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="border border-gray-200 rounded-xl overflow-hidden">
                    <button class="w-full flex items-center justify-between p-4 bg-gray-50 hover:bg-gray-100 transition-colors" onclick="toggleFAQ('faq2')">
                        <span class="font-semibold text-gray-800">How do I add a new package?</span>
                        <i class="fas fa-chevron-down text-gray-600" id="faq2-icon"></i>
                    </button>
                    <div id="faq2" class="hidden p-4 bg-white">
                        <p class="text-gray-600">
                            Go to <strong>Packages</strong> in the sidebar, click <strong>"Add New Package"</strong>, and fill in the package details including title, description, price, duration, and other relevant information. You can also upload images and assign the package to a hotel and category.
                        </p>
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="border border-gray-200 rounded-xl overflow-hidden">
                    <button class="w-full flex items-center justify-between p-4 bg-gray-50 hover:bg-gray-100 transition-colors" onclick="toggleFAQ('faq3')">
                        <span class="font-semibold text-gray-800">How can I track payments?</span>
                        <i class="fas fa-chevron-down text-gray-600" id="faq3-icon"></i>
                    </button>
                    <div id="faq3" class="hidden p-4 bg-white">
                        <p class="text-gray-600">
                            All payment information is tracked in the <strong>Bookings</strong> section. Each booking shows the total amount, paid amount, and remaining balance. You can filter bookings by payment status (pending, partial, paid, refunded) to easily track outstanding payments. The Analytics Dashboard also provides an overview of total revenue, received amounts, and pending payments.
                        </p>
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div class="border border-gray-200 rounded-xl overflow-hidden">
                    <button class="w-full flex items-center justify-between p-4 bg-gray-50 hover:bg-gray-100 transition-colors" onclick="toggleFAQ('faq4')">
                        <span class="font-semibold text-gray-800">How do I manage hotels?</span>
                        <i class="fas fa-chevron-down text-gray-600" id="faq4-icon"></i>
                    </button>
                    <div id="faq4" class="hidden p-4 bg-white">
                        <p class="text-gray-600">
                            Navigate to <strong>Hotels</strong> in the sidebar to view all hotels. You can add new hotels, edit existing ones, activate/deactivate hotels, and manage hotel details including name, location, rating, and amenities. Hotels can be linked to packages for better organization.
                        </p>
                    </div>
                </div>

                <!-- FAQ Item 5 -->
                <div class="border border-gray-200 rounded-xl overflow-hidden">
                    <button class="w-full flex items-center justify-between p-4 bg-gray-50 hover:bg-gray-100 transition-colors" onclick="toggleFAQ('faq5')">
                        <span class="font-semibold text-gray-800">Where can I view analytics?</span>
                        <i class="fas fa-chevron-down text-gray-600" id="faq5-icon"></i>
                    </button>
                    <div id="faq5" class="hidden p-4 bg-white">
                        <p class="text-gray-600">
                            Click on <strong>Analytics</strong> in the sidebar or go to the main <strong>Dashboard</strong> to view comprehensive analytics including total revenue, bookings, payment status, top-performing packages, monthly trends, and various performance metrics.
                        </p>
                    </div>
                </div>

                <!-- FAQ Item 6 -->
                <div class="border border-gray-200 rounded-xl overflow-hidden">
                    <button class="w-full flex items-center justify-between p-4 bg-gray-50 hover:bg-gray-100 transition-colors" onclick="toggleFAQ('faq6')">
                        <span class="font-semibold text-gray-800">How do I search for bookings?</span>
                        <i class="fas fa-chevron-down text-gray-600" id="faq6-icon"></i>
                    </button>
                    <div id="faq6" class="hidden p-4 bg-white">
                        <p class="text-gray-600">
                            In the Bookings page, use the search bar at the top to search by booking reference, customer name, email, or phone number. You can also filter bookings by status (pending, confirmed, cancelled, completed) and payment status for more specific results.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Documentation & Resources -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Quick Start Guide -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-book text-blue-600 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Quick Start Guide</h3>
                </div>
                <p class="text-gray-600 mb-4">Learn the basics of using the admin dashboard</p>
                <ul class="space-y-2 mb-4">
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mr-2 mt-1"></i>
                        <span class="text-gray-700">Setting up your first package</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mr-2 mt-1"></i>
                        <span class="text-gray-700">Managing bookings efficiently</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mr-2 mt-1"></i>
                        <span class="text-gray-700">Understanding analytics</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mr-2 mt-1"></i>
                        <span class="text-gray-700">Payment tracking best practices</span>
                    </li>
                </ul>
                <button class="w-full px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors">
                    View Guide
                </button>
            </div>

            <!-- Video Tutorials -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mr-4">
                        <i class="fas fa-play-circle text-purple-600 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Video Tutorials</h3>
                </div>
                <p class="text-gray-600 mb-4">Watch step-by-step video guides</p>
                <ul class="space-y-2 mb-4">
                    <li class="flex items-start">
                        <i class="fas fa-video text-purple-500 mr-2 mt-1"></i>
                        <span class="text-gray-700">Dashboard overview (5 min)</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-video text-purple-500 mr-2 mt-1"></i>
                        <span class="text-gray-700">Creating bookings (8 min)</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-video text-purple-500 mr-2 mt-1"></i>
                        <span class="text-gray-700">Managing packages (10 min)</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-video text-purple-500 mr-2 mt-1"></i>
                        <span class="text-gray-700">Reports & analytics (7 min)</span>
                    </li>
                </ul>
                <button class="w-full px-4 py-2 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition-colors">
                    Watch Tutorials
                </button>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl shadow-lg p-8 text-white">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-lg font-bold mb-4 flex items-center">
                        <i class="fas fa-envelope mr-2"></i>
                        Email Support
                    </h3>
                    <p class="text-gray-300 mb-2">General Inquiries:</p>
                    <a href="mailto:info@touradvisor.com" class="text-blue-400 hover:text-blue-300">info@touradvisor.com</a>
                    <p class="text-gray-300 mt-3 mb-2">Technical Support:</p>
                    <a href="mailto:support@touradvisor.com" class="text-blue-400 hover:text-blue-300">support@touradvisor.com</a>
                </div>

                <div>
                    <h3 class="text-lg font-bold mb-4 flex items-center">
                        <i class="fas fa-phone mr-2"></i>
                        Phone Support
                    </h3>
                    <p class="text-gray-300 mb-2">Main Office:</p>
                    <a href="tel:+971501234567" class="text-blue-400 hover:text-blue-300">+971 50 123 4567</a>
                    <p class="text-gray-300 mt-3 mb-2">Support Hours:</p>
                    <p class="text-gray-300">Mon-Fri: 9:00 AM - 6:00 PM</p>
                    <p class="text-gray-300">Sat: 10:00 AM - 4:00 PM</p>
                </div>

                <div>
                    <h3 class="text-lg font-bold mb-4 flex items-center">
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        Office Location
                    </h3>
                    <p class="text-gray-300">
                        TourAdvisor Travel Agency<br>
                        Sheikh Zayed Road<br>
                        Dubai, UAE<br>
                        P.O. Box 12345
                    </p>
                </div>
            </div>

            <div class="mt-8 pt-8 border-t border-gray-700">
                <h3 class="text-lg font-bold mb-4">Follow Us</h3>
                <div class="flex space-x-4">
                    <a href="#" class="w-10 h-10 bg-white bg-opacity-10 rounded-lg flex items-center justify-center hover:bg-opacity-20 transition-colors">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-white bg-opacity-10 rounded-lg flex items-center justify-center hover:bg-opacity-20 transition-colors">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-white bg-opacity-10 rounded-lg flex items-center justify-center hover:bg-opacity-20 transition-colors">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-white bg-opacity-10 rounded-lg flex items-center justify-center hover:bg-opacity-20 transition-colors">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-white bg-opacity-10 rounded-lg flex items-center justify-center hover:bg-opacity-20 transition-colors">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>
        </div>

    </main>
</div>

<script>
function toggleFAQ(id) {
    const element = document.getElementById(id);
    const icon = document.getElementById(id + '-icon');

    if (element.classList.contains('hidden')) {
        element.classList.remove('hidden');
        icon.classList.remove('fa-chevron-down');
        icon.classList.add('fa-chevron-up');
    } else {
        element.classList.add('hidden');
        icon.classList.remove('fa-chevron-up');
        icon.classList.add('fa-chevron-down');
    }
}
</script>
@endsection
