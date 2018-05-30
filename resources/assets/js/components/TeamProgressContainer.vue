<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Team Progress!</div>

                    <div class="card-body">
                        <team-progress v-for="team in teams" :key="team.id" :team="team"></team-progress>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['teams']
    }
</script>
