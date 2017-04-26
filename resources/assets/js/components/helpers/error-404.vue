<template>
    <div class="container center">
      <div class="error-page error-404">
        <img src="/images/error-404.png" alt="Not Found">
        <h1 class="red-text error-text">404</h1>
        <h5>Unable to hunt anything for you.</h5>
        <router-link to="/" class="waves-effect waves-light btn red mt30">Back To Home</router-link>
      </div>
    </div>
</template>
<script>
    export default{
        data(){
            return{
            }
        }
    }
</script>
