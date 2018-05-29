<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Existing Teams</div>
                    <div class="card-body">
                        <section class="form">
                            <li v-for="team in teams">
                                {{ team.name }}
                            </li>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['teams'],
        data() {
            return {
                form: {
                    teamName: ''
                }
            }
        }
    }
</script>
