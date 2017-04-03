<template>
    <div>
        <select :class="[className]" :multiple="multiple">
            <option value="" disabled selected>Choose your option</option>
            <slot></slot>
        </select>
    </div>
</template>
<script type="text/babel">
    export default {
        name: 'MaterialSelect',
        props: ['value', 'tags', 'multiple'],
        data() {
            return {
                className: 'select2component_0',
                elem: null,
                newVal: null,
                li: null
            }
        },
        mounted() {
            this.className = 'select2component_'+Math.floor(Math.random() * (10000000 + 1));
            $(document).on('click', '.select-wrapper.'+this.className, function (e) {
                console.log(this);
                const input = $(this).find('ul li input');
                console.log(input);
            });
            $(document).on('change', '#'+this.className, function (e) {
                console.log("Type: ", e);
            });
            if(this.value!==null) $("."+this.className).val(this.value);
            this.li = $("<li><span><input type='text' id='"+this.className+"'></span></li>");
            this.reRender();
        },
        methods: {
            reRender() {
                const that=this;
                Vue.nextTick(()=>{
                    setTimeout(()=>{
                        if(that.elem===null) that.elem = $("."+that.className);
                        if(that.newVal!==null) that.elem.val(that.newVal);
                        that.elem.material_select(function () {
                            that.$emit('input', that.elem.val());
                        });
                        setTimeout(()=>{
                            $(".select-wrapper."+that.className+" ul").prepend($(that.li));
                            $("#"+that.className).click(function (e) {
                                console.log(e);
                            });
                        }, 500);
                    }, 500);
                });
            }
        },
        watch: {
            value() {
                this.newVal = this.value;
                this.reRender();
            }
        }
    }
</script>