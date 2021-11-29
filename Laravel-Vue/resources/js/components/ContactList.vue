<template>
    <div class="container">
        <h2 class="text-center p-2 text-white bg-primary mt-5">Contacts</h2>
        <table class="table table-sm">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Designation</th>
                    <th scope="col">ContactNumber</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody v-for="contact in contacts" :key="contact.id">
                <tr>
                    <td scope="row">{{ contact.id }}</td>
                    <td>{{ contact.name }}</td>
                    <td> {{ contact.email}} </td>
                    <td>{{ contact.designation }}</td>
                    <td>{{ contact.contact_no}}</td>
                    <td>
                        <button class="btn btn-sm btn-danger" @click.prevent="deleteContact(contact.id)" >Delete</button>
                        <router-link :to="{ name:'edit_contact', params: {id:contact.id} }" class="btn btn-sm btn-primary">Edit</router-link>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    name: "ContactList",
    created() {
        this.loadData();
    },
    data() {
        return {
            url: document.head.querySelector('meta[name="url"]').content,
            contacts: [],
        };
    },
    methods: {
        loadData() {
            let url = this.url + "/api/getcontacts";
            console.log(this.url);
            this.axios
                .get(url)
                .then((res) => {
                    this.contacts = res.data;
                    console.log(this.contacts);
                })
                .catch((er) => {
                    return Promise.reject(er);
                });
        },
        deleteContact(id){
            let url = this.url + `/api/del_contact/${id}`;
            this.axios.delete(url)
            .then( response => {
                if (response.status) {
                    this.loadData();
                    this.$utils.showSuccess('success', response.message);
                } else {
                     this.$utils.showError('Error', response.message);
                }
            })
        }
    },
    mounted() {
        console.log("Contact List Component Mounted!");
    },
};
</script>
