<template>
    <td><span class="chip" :style="{backgroundColor: status_icon.bg_color, color: '#ffffff'}">{{ status_icon.label }}</span></td>
</template>
<script>
    export default{
        name: 'ReportsFeatureStatus',
        props: ['status'],
        data(){
            return{
            }
        },
        computed: {
            status_icon() {
                switch(this.status.type) {
                    case "PENDING":
                    case null:
                        return {
                            bg_color: '#ffa726',
                            label: this.lang.tooltip.status.pending
                        };
                        break;
                    case "RELEASED":
                        return {
                            bg_color: '#4caf50',
                            label: this.lang.tooltip.status.released
                        };
                    case "WIP":
                        return {
                            bg_color: '#ba68c8',
                            label: this.lang.tooltip.status.wip
                        };
                    case "DECLINED":
                        return {
                            bg_color: '#0d47a1',
                            label: this.lang.tooltip.status.declined
                        };
                        break;
                }
            }
        }
    }
</script>
