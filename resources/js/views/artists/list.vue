<template>
	<Layout>
		<PageHeader :title="title" :items="items"/>

		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<b-button :to="{name: 'create-artist'}">Add Artist</b-button>
					</div>
					<div class="card-body">
						<DataTable :custom-ref="table.customRef" :fields="table.fields" :slots="table.slots" :total-items="table.totalRows" :items="fetchData" :sort-by="table.sortBy">

                            <template slot="view" slot-scope="data">
                                <b-button variant="outline-info" :to="{name: 'artists', params: { id: data.tbl.item.id }}">
                                    <b-icon-eye/>
                                </b-button>
                            </template>

                            <template slot="image_url" slot-scope="data">
								<img :src="data.tbl.item.image_url" alt="">
							</template>

							<template slot="cover_url" slot-scope="data">
								<img :src="data.tbl.item.cover_url" alt="">
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
                        active: true
                    }
                ],
	            table: {
                    sortBy: "name",
                    fields: [
                        { kay: "view", sortable: false },
                        { key: "name", sortable: true },
                        { key: "cm_artist_rank", label: 'Rank', sortable: true },
                        { key: "code2", label: 'Country', sortable: true },
                        { key: "cover_url", label: 'Cover', sortable: true },
                        { key: "image_url",  label: 'Image',sortable: true },
                        { key: "hometown_city", sortable: true },
                        { key: "current_city", sortable: true },
                        { key: "record_label", sortable: false },
	                    { key: 'band_members', sortable: false },
	                    { key: 'press_contact', sortable: false },
	                    { key: 'booking_agent', sortable: false },
	                    // { key: 'tags', sortable: false },
	                    // { key: 'cm_statistics', sortable: false},
                        { key: 'spotify_popularity', sortable: false},
                        { key: 'spotify_followers', sortable: false},
                        { key: 'spotify_monthly_listeners', sortable: false},
                        { key: 'spotify_listeners_to_followers_ratio', sortable: false},
                        { key: 'facebook_likes', sortable: false},
                        { key: 'facebook_talks', sortable: false},
                        { key: 'youtube_channel_views', sortable: false},
                        { key: 'youtube_subscribers', sortable: false},
                        { key: 'wikipedia_views', sortable: false},
                        { key: 'soundcloud_followers', sortable: false}
                    ],
		            totalRows: 0,
		            slots: [
		                'view',
		                'image_url',
			            'cover_url'
		            ],
                    customRef: 'artistsTable'
	            }
            }
	    },
        methods: {
	        fetchData(ctx, callback) {
                const loader = this.$loading.show();
				let url = 'artists?filter=' + (ctx.filter ?? '') + '&sort-by=' + ctx.sortBy;
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
