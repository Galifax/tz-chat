<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { onMounted, reactive } from "vue";
import axios from "axios";

const props = defineProps({
    users: Array
})

let state = reactive({
    onlineUsers: [],
    messages: {},
});

const form = reactive({
    receiver_id: null,
    message: null,
})

function submit() {
    axios.post('/messages', form)
        .then(res => {
            form.message = null;
            state.messages.data.unshift(res.data.data);
        })
        .catch(err => alert(err.response.data.message));
}

function getMessages(userId) {
    axios.get(`/messages/${userId}`)
        .then(res => {
            state.messages = res.data;
        })
        .catch(err => alert(err.response.data.message));
}

function selectChatUserId(userId) {
    if (form.receiver_id) {
        window.Echo.leave(`chat.${form.receiver_id}`);
    }

    form.receiver_id = userId;
    getMessages(userId);

    window.Echo.channel(`chat.${userId}`)
        .listen('.storeMessage', function(data) {
            state.messages.data.unshift(data.message);
        })
}

onMounted(() => {
    const authUserId = usePage().props.auth.user.id;

    window.Echo.private(`user.${authUserId}`)
        .listen('.storeMessage', function(data) {
            window.Toast.success(`You have new message from ${data.message.sender.email}`);
        })

    window.Echo.join('online')
        .here((users) => {
            state.onlineUsers = users;
        })
        .joining((user) => {
            state.onlineUsers.push(user);
        })
        .leaving((user) => {
            let index = state.onlineUsers.indexOf(user)

            if(index >= 0) {
                state.onlineUsers.splice(index,1);
            }
        });
});

function isOnline(userId) {
    return Boolean(state.onlineUsers.find(user => user.id === userId));
}

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="flex h-screen">
                        <div class="w-1/4 bg-white overflow-auto">
                            <div class="p-5 font-bold">Users</div>
                            <ul class="divide-y divide-gray-200">
                                <li class="flex p-4 hover:bg-gray-50 cursor-pointer"
                                    :class="{'bg-gray-100 font-black': form.receiver_id === user.id}"
                                    v-for="user in users"
                                    :key="user.id"
                                    @click="selectChatUserId(user.id)"
                                >
                                    {{ user.email }}
                                    <span v-if="isOnline(user.id)" class="h-3 w-3 rounded-full ring-2 ring-white bg-green-400"></span>
                                    <span v-else class="h-3 w-3 rounded-full ring-2 ring-white bg-gray-400 bg-gray-400"></span>
                                </li>
                            </ul>
                        </div>

                        <div class="flex-1 flex flex-col bg-gray-200">
                            <template v-if="form.receiver_id !== null && state.messages.data">
                                <div class="p-5 font-bold">Messages</div>
                                <div class="flex p-5 flex-col-reverse overflow-auto overflow-y-auto h-full">
                                    <div class="rounded-lg bg-white p-4 mb-4"
                                         :class="{'text-right': message.sender_id === $page.props.auth.user.id}"
                                         v-for="message in state.messages.data"
                                         :key="message.id"
                                    >
<!--                                        <span class="block">{{ message.sender.email }}</span>-->
                                        <span class="block">{{ message.message }}</span>
                                        <span class="block">{{ message.created_at }}</span>
                                    </div>
                                </div>

                                <div class="p-5">
                                    <form class="flex" @submit.prevent="submit">
                                        <input type="text" v-model="form.message" class="flex-1 rounded-lg p-2 mr-2" placeholder="Input message...">
                                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Send</button>
                                    </form>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
