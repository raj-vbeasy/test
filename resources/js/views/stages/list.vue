<template>
	<Layout>
		<PageHeader :title="title" :items="items"/>

		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<b-button :to="{name: 'create-stage'}">Add Stage</b-button>
					</div>
					<div class="card-body">
						<DataTable :custom-ref="table.customRef" :fields="table.fields" :slots="table.slots" :total-items="table.totalRows" :items="fetchData" :sort-by="table.sortBy">
							<template slot="actions" slot-scope="data">
								<b-button variant="outline-danger" @click="deleteStage(data.tbl.item.id)">
									<b-icon-x/>
								</b-button>
								<b-button variant="outline-info" :to="{name: 'edit-stage', params: { id: data.tbl.item.id }}">
									<b-icon-pencil/>
								</b-button>
							</template>

							<template slot="calendar_color" slot-scope="data">
								<span v-html="data.tbl.item.calendar_color"></span>
							</template>

							<template slot="status" slot-scope="data">
								<label v-if="data.tbl.item.status === 1" class="badge-success badge">Active</label>
								<label v-else-if="data.tbl.item.status === 0" class="badge-danger badge">In Active</label>
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
            title: "Stages",
            meta: [{ name: "description", content: appConfig.description }]
        },
	    components: { Layout, PageHeader, DataTable },
	    data() {
            return {
                title: "Stages",
                items: [
                    {
                        text: "Dashboard",
                        href: "/"
                    },
                    {
                        text: "Stages",
                        active: true
                    }
                ],
	            table: {
                    sortBy: "name",
                    fields: [
                        { key: "performance_location.name", sortable: false },
                        { key: "name", sortable: true },
                        { key: "capacity", sortable: true },
                        { key: "calendar_color", sortable: false },
	                    { key: 'status', sortable: false },
	                    { key: 'actions', sortable: false }
                    ],
		            totalRows: 0,
		            slots: [
                        'actions',
                        'calendar_color',
			            'status'
		            ],
		            customRef: 'stagesTable'
	            }
            }
	    },
        methods: {
	        deleteStage(id) {
                const loader = this.$loading.show();
                this.$http.delete('stages/' + id)
	                .then(response => {
                        this.$toastr.fire({
                            toast: true,
                            icon: 'success',
                            title: response.data.message
                        });
                        this.$root.$emit('bv::refresh::table', this.table.customRef);
	                })
	                .catch(error => {
	                    console.log(error);
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
				let url = 'stages?filter=' + (ctx.filter ?? '') + '&sort-by=' + ctx.sortBy;
				url = url + '&sort-dir=' + (ctx.sortDesc ? 'desc' : 'asc');
				url = url + '&page=' + ctx.currentPage + '&per-page=' + ctx.perPage;

                this.$http.get(url)
                    .then(response => {
                        let data = [];
                        for (let i = 0; i < response.data.data.data.length; i++) {
                            response.data.data.data[i].calendar_color = '<div class="calendar_color" style="background: '+response.data.data.data[i].calendar_color+';width: 20px;height: 20px;"></div>';
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