<script>
    import appConfig from "@/app.config";

    export default {
        data() {
            return {
                appName: appConfig.name
            };
        },
    }
</script>
<template>
	<footer class="footer">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-6">{{ new Date().getFullYear() }} © {{ appName }}.</div>
				<div class="col-sm-6">
					<div class="text-sm-right d-none d-sm-block">Developed by <a href="https://vbeasy.com/">VB Easy</a></div>
				</div>
			</div>
		</div>
	</footer>
	<!-- end footer -->
</template>
