<template>
	<Layout>
		<PageHeader :title="title" :items="items"/>

		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<b-button :to="{name: 'create-performance-location'}">Add Performance Location</b-button>
					</div>
					<div class="card-body">
						<DataTable :custom-ref="table.customRef" :fields="table.fields" :slots="table.slots" :total-items="table.totalRows" :items="fetchData" :sort-by="table.sortBy">
							<template slot="actions" slot-scope="data">
								<b-button variant="outline-danger" @click="deletePerformanceLocation(data.tbl.item.id)">
									<b-icon-x/>
								</b-button>
								<b-button variant="outline-info" :to="{name: 'edit-performance-location', params: { id: data.tbl.item.id }}">
									<b-icon-pencil/>
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
            title: "Performance Locations",
            meta: [{ name: "description", content: appConfig.description }]
        },
	    components: { Layout, PageHeader, DataTable },
	    data() {
            return {
                title: "Performance Locations",
                items: [
                    {
                        text: "Dashboard",
                        href: "/"
                    },
                    {
                        text: "Performance Locations",
                        active: true
                    }
                ],
	            table: {
                    sortBy: "name",
                    fields: [
                        { key: "name", sortable: true },
                        { key: "location", sortable: true },
                        { key: "tax_rate", sortable: true },
                        { key: "facility_fee", sortable: true },
                        { key: "timezone", sortable: true },
                        { key: "currency", sortable: true },
                        { key: "convert_artist_pay_to_usd", sortable: false },
	                    { key: 'event_template', sortable: false },
	                    { key: 'logo', sortable: false },
	                    { key: 'team', sortable: false },
	                    { key: 'actions', sortable: false }
                    ],
		            totalRows: 0,
		            slots: ['actions'],
                    customRef: 'performanceLocationsTable'
	            }
            }
	    },
        methods: {
	        deletePerformanceLocation(id) {
                const loader = this.$loading.show();
                this.$http.delete('performance-locations/' + id)
	                .then(response => {
                        this.$toastr.fire({
                            toast: true,
                            icon: 'success',
                            title: response.data.message
                        });
                        this.fetchData();
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
	        },
	        fetchData(ctx, callback) {
                const loader = this.$loading.show();
				let url = 'performance-locations?filter=' + (ctx.filter ?? '') + '&sort-by=' + ctx.sortBy;
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