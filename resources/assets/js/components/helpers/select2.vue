<template>
    <select class="select2component">
    </select>
</template>
<style>
    #select2component {
        display: block;
    }
</style>
<script type="text/babel">
    export default{
        props: ['options', 'selected-value', 'tags', 'disabled', 'update'],
        data(){
            return{
                control: null,
                value: null
            }
        },
        mounted() {
            this.renderSelect();
        },
        methods: {
            renderSelect() {
                if(this.control!=null) this.control.select2('destroy');
                let data = {};
                data.data = this.options;
                if(this.tags) {
                    data.tags = this.true;
                    data.tokenSeparators = [',', ' '];
                }
                this.control = $(".select2component").select2(data);
                this.control.on('select2:select', e=>{
                    this.value = e.target.value;
                });
                this.control.on('select2:unselect', e=>{
                    console.log('unselect', e);
                });
                if(this.selectedValue!=undefined) this.control.select2('val', this.selectedValue);
            }
        },
        watch: {
            options() {
                this.renderSelect();
            },
            value() {
                this.update.call(this, this.value);
            },
            selectedValue() {
                if(this.control!=undefined) this.control.select2('val', this.selectedValue);
            }
        }
    }
</script>
