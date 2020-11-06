<template>
    <Layout>
        <PageHeader :title="title" :items="items"/>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <b-button :to="{name: 'artists'}">Artists List</b-button>
                    </div>
                    <div class="card-body">
                        {{ artist }}
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script>
import appConfig from '@/app.config.json';
import Layout from '@/views/layouts/main';
import PageHeader from '@/components/page-header';
import DataTable from '@/views/utility/data-table';

export default {
    page: {
        title: "Artists",
        meta: [{ name: "description", content: appConfig.description }]
    },
    components: { Layout, PageHeader, DataTable },
    data() {
        return {
            title: "Artists",
            items: [
                {
                    text: "Dashboard",
                    href: "/"
                },
                {
                    text: "Artists",
                    href: "artists"
                },
                {
                    text: "View",
                    active: true
                }
            ],
            artist: null
        }
    },
    created() {
        const loader = this.$loading.show();
        let editUrl = 'performance-locations/' + this.$route.params.id +'/edit';
        this.$http.get(editUrl)
            .then(response => (
                this.artist = response.data.data
            ))
            .catch(error => {
                this.$toastr.fire({
                    toast: true,
                    icon: 'error',
                    title: error.response.message
                });
            })
            .then(() => {
                loader.hide();
            })
    }
}
</script>

<style scoped>
img {
    width: 60px;
}
</style>
