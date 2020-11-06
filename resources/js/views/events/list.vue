<template>
    <Layout>
        <PageHeader :title="title" :items="items"/>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <DataTable :custom-ref="table.customRef" :fields="table.fields" :slots="table.slots" :total-items="table.totalRows" :items="fetchData" :sort-by="table.sortBy">
                            <template slot="view" slot-scope="data">
                                <b-button variant="outline-info" :to="{name: 'event-dashboard', params: { id: data.tbl.item.id }}">
                                    <b-icon-eye/>
                                </b-button>
                            </template>
                        </DataTable>
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
        title: "Events List",
        meta: [{ name: "description", content: appConfig.description }]
    },
    components: { Layout, PageHeader, DataTable },
    data() {
        return {
            title: "Events List",
            items: [
                {
                    text: "Dashboard",
                    href: "/"
                },
                {
                    text: "Events List",
                    active: true
                }
            ],
            table: {
                sortBy: "name",
                fields: [
                    { key: 'view', sortable: false },
                    { key: "name", sortable: true },
                    { key: "email", sortable: true },
                    /*{ key: "performanceLocation", sortable: true },*/
                    { key: "promoter", sortable: true },
                    { key: "date", sortable: true },
                    { key: "status", sortable: true }
                ],
                totalRows: 0,
                slots: [
                    'view'
                ],
                customRef: 'eventsTable'
            }
        }
    },
    methods: {
        fetchData(ctx, callback) {
            const loader = this.$loading.show();
            let url = 'events_list?filter=' + (ctx.filter ?? '') + '&sort-by=' + ctx.sortBy;
            url = url + '&sort-dir=' + (ctx.sortDesc ? 'desc' : 'asc');
            url = url + '&page=' + ctx.currentPage + '&per-page=' + ctx.perPage;

            this.$http.get(url)
                .then(response => {
                    let data = [];
                    for (let i = 0; i < response.data.data.data.length; i++) {
                        data.push(response.data.data.data[i]);
                    }
                    this.table.totalRows = response.data.data.total;
                    callback(data);
                })
                .catch(error => {
                    this.$toastr.fire({
                        toast: true,
                        icon: 'error',
                        title: error.response.message
                    });
                })
                .then(() => {
                    loader.hide();
                });

            return null;
        }
    }
}
</script>

<style scoped>
img {
    width: 60px;
}
</style>
