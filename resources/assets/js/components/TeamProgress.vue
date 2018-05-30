<template>
    <div>
        <p>{{team.name}}</p>
        <p>Progress: {{this.completed}} / {{this.total}}</p>
    </div>
</template>

<script>
    export default {
        props: ['team'],
        data() {
            return {
                completed: this.team.completed_tasks,
                total: this.team.total_tasks
            }
        },
        methods: {
            getProgress: async function(e) {
                const response = await axios.get('/teams/' + this.team.id);
                const team = response.data;
                this.completed = team.completed_tasks;
                this.total = team.total_tasks;
            }
        },
        mounted: function() {
            console.log('Beginning polling...');
            this.interval = setInterval(this.getProgress, 5000);
        },
        beforeDestroy: function() {
            clearTimeout(this.interval)
        }
    }
</script>
