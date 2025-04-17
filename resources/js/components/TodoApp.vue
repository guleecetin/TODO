<template>
    <div class="min-h-screen bg-gradient-to-r from-purple-50 to-blue-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-10">
                <h1
                    class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-blue-600 mb-3">
                    Todo Uygulaması
                </h1>
                <p class="text-gray-600">Görevlerinizi yönetin, planlayın ve tamamlayın</p>
            </div>

            <!-- Todo Ekleme Formu -->
            <div class="mb-8 p-6 bg-white rounded-lg shadow-lg border border-gray-100">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Yeni Görev Ekle
                </h2>
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Başlık</label>
                    <input id="title" v-model="newTodo.title" type="text" placeholder="Görev başlığını girin"
                        class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Açıklama</label>
                    <textarea id="description" v-model="newTodo.description"
                        placeholder="Görev açıklamasını girin (isteğe bağlı)"
                        class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                        rows="3"></textarea>
                </div>
                <div class="flex items-center">
                    <button @click="addTodo"
                        class="inline-flex items-center px-5 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-medium rounded-md shadow hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Görev Ekle
                    </button>
                </div>
            </div>

            <!-- Todo Listesi -->
            <div class="bg-white rounded-lg shadow-lg border border-gray-100 overflow-hidden">
                <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                    <h2 class="text-xl font-bold text-gray-800 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Görevlerim
                    </h2>
                </div>

                <div v-if="loading" class="flex justify-center items-center p-12">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500"></div>
                </div>

                <div v-else-if="todos.length === 0" class="text-center py-12 px-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-300 mb-4" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <p class="text-gray-500 text-lg">Henüz görev eklenmemiş</p>
                    <p class="text-gray-400 mt-2">İlk görevinizi ekleyin ve düzenli kalın!</p>
                </div>

                <ul v-else class="divide-y divide-gray-200">
                    <li v-for="todo in todos" :key="todo.id" class="hover:bg-gray-50 transition">
                        <div class="px-6 py-4">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start space-x-3">
                                    <div class="pt-1">
                                        <label :for="`todo-${todo.id}`" class="sr-only">Görevi tamamla</label>
                                        <input :id="`todo-${todo.id}`" type="checkbox" :checked="todo.completed"
                                            @change="toggleTodo(todo)"
                                            class="h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer">
                                    </div>
                                    <div>
                                        <h3 :class="{ 'line-through text-gray-400': todo.completed, 'text-gray-900': !todo.completed }"
                                            class="text-lg font-medium transition">
                                            {{ todo.title }}
                                        </h3>
                                        <p v-if="todo.description"
                                            :class="{ 'text-gray-400': todo.completed, 'text-gray-600': !todo.completed }"
                                            class="mt-1 text-sm">
                                            {{ todo.description }}
                                        </p>
                                        <div class="mt-2 text-xs text-gray-400">
                                            {{ formatDate(todo.created_at) }}
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <button @click="deleteTodo(todo.id)"
                                        class="inline-flex items-center p-2 border border-transparent rounded-full text-gray-400 hover:bg-red-50 hover:text-red-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>

                <div v-if="todos.length > 0" class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">
                            Toplam {{ todos.length }} görev
                        </span>
                        <span class="text-sm text-gray-600">
                            {{ completedCount }} tamamlandı, {{ todos.length - completedCount }} devam ediyor
                        </span>
                    </div>
                </div>
            </div>

            <div class="mt-6 text-center text-sm text-gray-500">
                Created with Laravel & Vue3 • {{ currentYear }}
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            todos: [],
            loading: true,
            newTodo: {
                title: '',
                description: '',
                completed: false
            },
            currentYear: new Date().getFullYear()
        }
    },

    computed: {
        completedCount() {
            return this.todos.filter(todo => todo.completed).length;
        }
    },

    mounted() {
        this.fetchTodos();
    },

    methods: {
        fetchTodos() {
            this.loading = true;
            fetch('/api/todos')
                .then(response => response.json())
                .then(data => {
                    this.todos = data;
                    this.loading = false;
                })
                .catch(error => {
                    console.error('Error fetching todos:', error);
                    this.loading = false;
                });
        },

        addTodo() {
            if (!this.newTodo.title.trim()) {
                alert('Lütfen bir görev başlığı girin');
                return;
            }

            console.log('Gönderilecek veri:', this.newTodo); // Debug için

            fetch('http://127.0.0.1:8000/todos', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(this.newTodo)
            })

                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Sunucudan dönen veri:', data); // Debug için
                    this.todos.unshift(data);
                    this.newTodo = {
                        title: '',
                        description: '',
                        completed: false
                    };
                })
                .catch(error => {
                    console.error('Görev eklerken hata:', error);
                    alert('Görev eklenirken bir hata oluştu: ' + error.message);
                });
        },

        toggleTodo(todo) {
            const updatedTodo = { ...todo, completed: !todo.completed };

            fetch(`/api/todos/${todo.id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(updatedTodo)
            })
                .then(response => response.json())
                .then(data => {
                    const index = this.todos.findIndex(t => t.id === todo.id);
                    this.todos[index].completed = !todo.completed;
                })
                .catch(error => console.error('Error updating todo:', error));
        },

        deleteTodo(id) {
            if (!confirm('Bu görevi silmek istediğinizden emin misiniz?')) {
                return;
            }

            fetch(`/api/todos/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
                .then(() => {
                    this.todos = this.todos.filter(todo => todo.id !== id);
                })
                .catch(error => console.error('Error deleting todo:', error));
        },

        formatDate(dateString) {
            if (!dateString) return '';
            const date = new Date(dateString);
            return date.toLocaleDateString('tr-TR', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }
    }
}
</script>