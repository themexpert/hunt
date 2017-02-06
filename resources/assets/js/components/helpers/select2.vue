<template>
    <select :class="[className]" :multiple="multiple">
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
                value: null,
                values: [],
                multiple: false,
                className: 'select2component_0',
                tag: '',
                elem: null,
                previousValue: null
            }
        },
        mounted() {
            this.className = 'select2component_'+Math.floor(Math.random() * (10000000 + 1));
            if(this.tags) {
                this.multiple = true;
                this.value=[];
            }
            setTimeout(this.renderSelect, 500);
        },
        methods: {
            renderSelect() {
                if(this.control!=null) this.control.select2('destroy');
                let data = {};
                data.data = this.options;
                data.placeholder = 'Please select...';
                if(this.tags) {
                    data.tags = this.tags;
                    data.tokenSeparators = [',', ' '];
                    const that = this;
                    data.createTag = newTag => {
                        if(that.tags && newTag.term!=null && newTag.term != '') {
                            const tag = {
                                id: newTag.term.toLowerCase(),
                                text: newTag.term.toUpperCase()
                            };
                            that.tag = tag.id;
                            return tag;
                        }
                        if(that.tag.length>1) {
                            that.valueUpdated();
                            that.tag = '';
                        }
                    };
                }
                this.elem = $("."+this.className);
                this.control = this.elem.select2(data);
                this.control.on('select2:select', e=> {
                    this.valueUpdated();
                });
                this.control.on('select2:unselect', e=>{
                    this.valueUpdated();
                });
                let value = (this.selectedValue==undefined)?null:(typeof this.selectedValue != 'object' ? [this.selectedValue] : this.selectedValue);
                this.control.val(value).trigger('change');
            },
            valueUpdated() {
                const value = this.elem.val();
                if (value == null)
                    this.callUpdateCallback(value);
                else if (this.previousValue == null && value != null)
                    this.callUpdateCallback(value);
                else if (this.tags && this.previousValue.length != value.length)
                    this.callUpdateCallback(value);
                else if(this.previousValue != value)
                    this.callUpdateCallback(value);
            },
            callUpdateCallback(value) {
                this.previousValue = value;
                this.update.call(this, value);
            }
        },
        watch: {
            options() {
                this.renderSelect();
            }
        }
    }
</script>
