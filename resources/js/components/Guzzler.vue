<template>
<div>
    <div class="w-full max-w-xl mx-auto bg-white px-5 py-7">
        <form @submit.prevent="editMode ? editPost(postData) : addPost()">
            <label class="font-semibold text-sm text-gray-600 pb-1 block">UserId</label>
            <input v-model="postData.userId" type="number" required class="border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full" />
            <label class="font-semibold text-sm text-gray-600 pb-1 block">Title</label>
            <input v-model="postData.title" type="text" required class="border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full" />
            <label class="font-semibold text-sm text-gray-600 pb-1 block">Body</label>
            <textarea v-model="postData.body" required class="border rounded-lg px-3 py-2 mt-1 mb-5 text-sm w-full" />
            <button type="submit" class="transition duration-200 bg-indigo-500 hover:bg-purple-600 focus:bg-purple-700 focus:shadow-sm focus:ring-4 focus:ring-blue-500 focus:ring-opacity-50 text-white w-full py-2.5 rounded-lg text-sm shadow-sm hover:shadow-md font-semibold text-center inline-block">
                <span class="inline-block mr-2">{{editMode ? 'Edit' : 'Add'}}</span>
            </button>
            <button @click="resetForm" class="mt-3 transition duration-200 bg-red-500 hover:bg-red-600 focus:bg-red-700 focus:shadow-sm focus:ring-4 focus:ring-blue-500 focus:ring-opacity-50 text-white w-full py-2.5 rounded-lg text-sm shadow-sm hover:shadow-md font-semibold text-center inline-block">
                <span class="inline-block mr-2">Reset</span>
            </button>
        </form>
    </div>
    <div class="w-full max-w-2xl mx-auto bg-white shadow-lg rounded-sm border border-gray-200 mt-3">
        <header class="px-5 py-4 border-b border-gray-100">
            <h2 class="font-semibold text-gray-800">Posts</h2>
        </header>
        <div class="p-3">
            <div class="overflow-x-auto">
                <table class="table-auto w-full">
                    <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                    <tr>
                        <th class="p-2 whitespace-nowrap">
                            <div class="font-semibold text-left">User Id</div>
                        </th>
                        <th class="p-2 whitespace-nowrap">
                            <div class="font-semibold text-center">Title</div>
                        </th>
                        <th class="p-2 whitespace-nowrap">
                            <div class="font-semibold text-center">Body</div>
                        </th>
                        <th class="p-2 whitespace-nowrap">
                            <div class="font-semibold text-left"></div>
                        </th>
                    </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-100">
                    <tr v-if="posts.length < 1" class="text-center">
                        <td colspan="3">Oops no posts found!</td>
                    </tr>
                    <tr v-for="(post,index) in posts" :key="index">
                        <td class="p-2 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="font-medium text-gray-800">{{post.userId}}</div>
                            </div>
                        </td>
                        <td class="p-2 whitespace-nowrap">
                            <div class="text-center">{{post.title}}</div>
                        </td>
                        <td class="p-2 whitespace-nowrap">
                            <div class="text-center font-medium text-green-500">{{post.body}}</div>
                        </td>
                        <td class="p-2 whitespace-nowrap float-right">
                            <button @click="toggleEdit(post)" type="button" class="mb-3 mr-3 text-sm bg-blue-500 hover:bg-blue-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline">
                                Edit
                            </button>
                            <button @click="deletePost(post.id)" type="button" class="text-sm bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded focus:outline-none focus:shadow-outline">
                                Delete
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</template>

<script>
    import axios from "axios";
    export default {
        name: "Guzzler",
        data(){
            return{
                posts:[],
                postData:{},
                editMode: false
            }
        },
        mounted(){
            axios.get("http://to-do.appp/posts/")
                .then(response => {
                    this.posts = response.data.slice(0,9);
                })
                .catch(error => {
                    console.error("There was an error!", error);
                });
        },
        methods:{
            async deletePost(id) {
                let x = window.confirm("Are you sure you want to delete post?");

                if (x) {
                    await axios.delete(
                        "http://to-do.appp/posts/" + id
                    )
                        .then(response => {
                            console.log(response.data);
                        })
                        .catch(error => {
                            console.error("There was an error!", error);
                        });
                }
            },
            addPost(){
                axios.post("http://to-do.appp/posts/",this.postData)
                    .then(response => {
                        if (response.status === 200){
                            this.postData = {};
                            alert("Added")
                        }
                        console.log(response.data);
                    })
                    .catch(error => {
                        console.error("There was an error!", error);
                    });
            },
            editPost(post){
                axios.put("http://to-do.appp/post-update/" + post.id,post)
                    .then(response => {
                        this.editMode = false;
                        console.log(response.data)
                    })
                    .catch(error => {
                        console.error("There was an error!", error);
                    });

            },
            toggleEdit(post){
                this.editMode = true;
                this.postData = post;
            },
            resetForm(){
                this.editMode = false;
                this.postData = {};
            }
        }
    }
</script>

<style scoped>

</style>
