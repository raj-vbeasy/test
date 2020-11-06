<template>
	<RouterView />
</template>

<script>
	import appConfig from '@/./app.config.json';

    export default {
        name: "app",
	    page: {
            titleTemplate(title) {
                title = typeof title === "function" ? title(this.$store) : title;
                return title ? `${title} | ${appConfig.title}` : appConfig.title;
            }
	    }
    }
</script>