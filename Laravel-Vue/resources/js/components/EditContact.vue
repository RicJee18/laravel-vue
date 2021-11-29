<template>
    <div class="container">
        <h2 class="text-center p-2 text-white bg-primary mt-5">Edit Contact</h2>
        <div class="card-body">
            <div class="col-md-6 offset-md-3">
                <form
                    enctype="multipart/form-data"
                    id="validateForm"
                    @submit.prevent="updateContact"
                    novalidate
                >
                    <div class="alert alert-danger" v-if="errors.length">
                        <div class="mb-0">
                            <li v-for="(error, index) in errors" :key="index">
                                {{ error }}
                            </li>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Name">Name</label>
                        <input
                            type="text"
                            id="name"
                            v-model="contact.name"
                            class="form-control"
                        />
                    </div>
                    <div class="form-group">
                        <label for="Name">Email</label>
                        <input
                            type="email"
                            id="email"
                            v-model="contact.email"
                            class="form-control"
                        />
                    </div>
                    <div class="form-group">
                        <label for="Name">Bio</label>
                        <textarea
                            id="bio"
                            v-model="contact.bio"
                            cols="20"
                            rows="5"
                            class="form-control"
                        ></textarea>
                    </div>
                    <div class="form-group">
                        <label for="Name">Designation</label>
                        <input
                            type="text"
                            id="designation"
                            v-model="contact.designation"
                            class="form-control"
                        />
                    </div>
                    <div class="form-group">
                        <label for="Name">Contact Number</label>
                        <input
                            type="text"
                            id="contact_no"
                            v-model="contact.contact_no"
                            class="form-control"
                        />
                    </div>
                    <!-- <div class="form-group" v-if="contact.image">
                        <img
                            :src="`${url + '/' + contact.image}`"
                            alt="image"
                            width="100"
                            height="150"
                        />
                    </div> -->
                    <div class="custom-file mt-3">
                        <input
                            type="file"
                            name="image"
                            id="image"
                            class="custom-file-input"
                            v-on:change="onImageChange"
                        />
                    </div>

                    <button type="submit" class="btn btn-success mt-3">
                        Submit
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "EditContact",
    data() {
        return {
            url: document.head.querySelector('meta[name="url"]').content,
            contact: {},
            name: "",
            email: "",
            bio: "",
            designation: "",
            contact_no: "",
            errors: [],
        };
    },
    methods: {
        loadData() {
            let url = this.url + `/api/edit_contact/${this.$route.params.id}`;
            this.axios.get(url).then((response) => {
                this.contact = response.data;
                console.log(this.contact);
            });
        },
        updateContact() {
            this.errors = [];
            if (!this.contact.name) {
                this.errors.push("Name is required!");
            }
            if (!this.contact.email) {
                this.errors.push("Email is required!");
            }
            if (!this.contact.bio) {
                this.errors.push("Bio is required!");
            }
            if (!this.contact.designation) {
                this.errors.push("Designation is required!");
            }
            if (!this.contact.contact_no) {
                this.errors.push("Contact Number is required!");
            }

            if (!this.errors.length) {
                let formData = new FormData();
                formData.append("name", this.contact.name);
                formData.append("email", this.contact.email);
                formData.append("bio", this.contact.bio);
                formData.append("designation", this.contact.designation);
                formData.append("contact_no", this.contact.contact_no);
                formData.append("image", this.image);

                let url =
                    this.url + `/api/update_contact/${this.$route.params.id}`;
                this.axios
                    .post(url, formData)
                    .then((res) => {
                        if (res.status) {
                            this.$utils.showSuccess("success", res.message);
                            this.$router.push({
                                name: "/",
                            });
                        } else {
                            this.$utils.showError("Error", res.message);
                        }
                    })
                    .catch((error) => {
                        this.errors.push(error.res.data.error);
                    });
            }
        },
        onImageChange(e) {
            this.image = e.target.files[0];
            console.log(this.image);
        },
    },
    created() {
        this.loadData();
    },
    mounted: function () {
        console.log("Edit Contact Component Loaded!");
    },
};
</script>
