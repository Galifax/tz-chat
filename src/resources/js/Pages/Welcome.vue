<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Head title="Welcome" />

    <div
        class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 selection:bg-red-500 selection:text-white"
    >
        <div v-if="canLogin" class="sm:fixed sm:top-0 sm:right-0 p-6 text-end">
            <Link
                v-if="$page.props.auth.user"
                :href="route('dashboard')"
                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                >Dashboard</Link
            >

            <template v-else>
                <Link
                    :href="route('login')"
                    class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                    >Log in</Link
                >

                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="ms-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                    >Register</Link
                >
            </template>
        </div>

        <div class="text-gray-600 body-font">
            <div class="container mx-auto flex flex-col px-5 py-24 justify-center items-center">
                <img class="lg:w-2/6 md:w-3/6 w-5/6 mb-10 object-cover object-center rounded" alt="hero" src="https://dummyimage.com/720x600">
                <div class="w-full md:w-2/3 flex flex-col mb-16 items-center text-center">
                    <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-900">Welcome to Chat App</h1>
                    <p class="mb-8 leading-relaxed">Connect with your friends and teams instantly! Experience seamless communication in a secure and user-friendly environment.</p>
                    <div class="flex w-full justify-center">
                        <a href="#" class="btn bg-purple-500 text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-purple-600 shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-1 mr-4">Log In</a>
                        <a href="#" class="btn bg-pink-500 text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-pink-600 shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-1">Sign Up</a>
                    </div>
                </div>
            </div>

            <section class="text-gray-600 body-font">
                <div class="container px-5 py-24 mx-auto">
                    <div class="flex flex-wrap w-full mb-20 flex-col items-center text-center">
                        <h2 class="sm:text-3xl text-2xl font-medium title-font mb-2 text-gray-900">Why Choose Chat App?</h2>
                        <p class="lg:w-1/2 w-full leading-relaxed text-gray-500">Discover the features that make us the best choice for private and group communication.</p>
                    </div>
                    <div class="flex flex-wrap -m-4">
                        <div class="xl:w-1/3 md:w-1/2 p-4">
                            <div class="border border-gray-200 p-6 rounded-lg">
                                <div class="w-10 h-10 inline-flex items-center justify-center rounded-full bg-purple-100 text-purple-500 mb-4">
                                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
                                        <path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 11-7.6-7.6 8.38 8.38 0 013.8.9L21 3l-2 2-4 4 2 2 4-4 2-2z"></path>
                                        <path d="M16 7l-4 4m0 -4l4 4"></path>
                                    </svg>
                                </div>
                                <h2 class="text-lg text-gray-900 font-medium title-font mb-2">Instant Messaging</h2>
                                <p class="leading-relaxed text-base">Send messages in real-time to individuals or groups without any delay.</p>
                            </div>
                        </div>
                        <!-- Repeat for other features -->
                    </div>
                </div>
            </section>

            <!-- Add more sections like Testimonials, Contact Info here -->

        </div>
    </div>
</template>

<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}
@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style>
