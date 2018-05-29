<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Register New Team!</div>

                    <div class="card-body">
                        <section class="form">
                            <form @submit.prevent="submitForm" method="post">

                                <p v-if="errors.length">
                                    <b>Please correct the following error(s):</b>
                                    <ul>
                                        <li v-for="error in errors">{{ error }}</li>
                                    </ul>
                                </p>

                                <div class="field">
                                    <div class="control">
                                        <input name="teamName" v-model="teamName" class="input" type="text" placeholder="Team Name">
                                    </div>
                                </div>


                                <div class="field">
                                    <div class="control">
                                        <button class="button is-primary">
                                            Submit
                                        </button>
                                    </div>
                                </div>

                            </form>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [],
        data() {
            return {
                errors: [],
                teamName: ''
            }
        },
        methods: {
            submitForm: async function(e) {
                console.log('Submitting form...');

                this.errors = [];

                if (!this.teamName) {
                    this.errors.push('Must define team name!');
                }

                if (this.errors.length === 0) {

                    try {
                        const response = await axios.post('/teams', {
                            teamName: this.teamName
                        });
                        console.log('Data:\n' + JSON.stringify(response.data))
                        location.reload();
                    } catch (err) {
                        console.error('Error submitting form:\n' + err);
                    }

                }
            }
        }
    }
</script>
