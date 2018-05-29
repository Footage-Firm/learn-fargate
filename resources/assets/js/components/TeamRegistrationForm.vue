<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Register New Team!</div>

                    <div class="card-body">
                        <section class="form">
                            <div class="field">
                                <label class="label">Team Name</label>
                                <div class="control">
                                    <input v-model="form.teamName" class="input" type="text" placeholder="Team Name">
                                </div>
                            </div>
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
                form: {
                    teamName: ''
                }
            }
        }
    }
</script>
