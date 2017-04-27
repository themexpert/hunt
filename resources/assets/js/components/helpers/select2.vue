<template>
    <select :class="[className]" :multiple="multiple" :placeholder="placeholder">
        <slot></slot>
    </select>
</template>
<script type="text/babel">
    export default{
        props: ['value', 'tags', 'disabled', 'placeholder'],
        data(){
            return{
                control: null,
                multiple: false,
                className: 'select2component_0',
                tag: '',
                elem: null
            }
        },
        mounted() {
            this.className = 'select2component_'+Math.floor(Math.random() * (10000000 + 1));
            if(this.tags) {
                this.multiple = true;
            }
            setTimeout(this.renderSelect, 500);
        },
        methods: {
            renderSelect() {
                if(this.control!==null) this.control.select2('destroy');
                const data = {};
                data.data = this.options;
                data.placeholder = this.placeholder?this.placeholder:'Please select...';
                if(this.tags) {
                    data.tags = this.tags;
                    data.tokenSeparators = [',', ' '];
                    const that = this;
                    data.createTag = newTag => {
                        if(that.tags && newTag.term!==null && newTag.term !== '') {
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
                const that=this;
                setTimeout(()=>{
                    that.control.val(this.value).trigger('change');
                    that.elem.parent().find('span.select2').width('100%');
                    $(".select2-search__field").css('width', '100%');
                    $(".select2-selection__placeholder").css('color', '#fff');
                }, 100);
            },
            valueUpdated() {
                let val = this.control.val();
                if(val==null) {
                    if(this.tags)
                        val = [];
                    else
                        val = '';
                }
                this.$emit('input', val);
            }
        },
        watch: {
            value() {
                if(this.value==null) this.value=undefined;
                this.renderSelect();
            }
        }
    }
</script>
