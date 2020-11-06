<script>
    import MetisMenu from "metismenujs/dist/metismenujs";

    export default {
        components: {},
        mounted: function() {
            document.body.setAttribute("data-sidebar", "dark");
            document.body.setAttribute("data-keep-enlarged", "true");
            document.body.classList.add("vertical-collpsed");
            // eslint-disable-next-line no-unused-vars
            var menuRef = new MetisMenu("#side-menu");
            var links = document.getElementsByClassName("side-nav-link-ref");
            var matchingMenuItem = null;
            for (var i = 0; i < links.length; i++) {
                if (window.location.pathname === links[i].pathname) {
                    matchingMenuItem = links[i];
                    break;
                }
            }

            if (matchingMenuItem) {
                matchingMenuItem.classList.add("active");
                var parent = matchingMenuItem.parentElement;

                /**
                 * TODO: This is hard coded way of expading/activating parent menu dropdown and working till level 3.
                 * We should come up with non hard coded approach
                 */
                if (parent) {
                    parent.classList.add("mm-active");
                    const parent2 = parent.parentElement.closest("ul");
                    if (parent2 && parent2.id !== "side-menu") {
                        parent2.classList.add("mm-show");

                        const parent3 = parent2.parentElement;
                        if (parent3) {
                            parent3.classList.add("mm-active");
                            var childAnchor = parent3.querySelector(".has-arrow");
                            var childDropdown = parent3.querySelector(".has-dropdown");
                            if (childAnchor) childAnchor.classList.add("mm-active");
                            if (childDropdown) childDropdown.classList.add("mm-active");

                            const parent4 = parent3.parentElement;
                            if (parent4) parent4.classList.add("mm-show");
                            const parent5 = parent4.parentElement;
                            if (parent5) parent5.classList.add("mm-active");
                        }
                    }
                }
            }
        }
    };
</script>

<template>
	<!-- ========== Left Sidebar Start ========== -->

	<!--- Sidemenu -->
	<div id="sidebar-menu">
		<!-- Left Menu Start -->
		<ul id="side-menu" class="metismenu list-unstyled">
			<li class="menu-title">Menu</li>

			<li>
				<router-link tag="a" to="/" class="side-nav-link-ref">
					<i class="bx bx-home-circle"></i>
					<span>Dashboard</span>
				</router-link>
			</li>

            <li>
                <a href="javascript: void(0);" class="has-arrow">
                    <i class="bx bx-calendar-event"></i>
                    <span>Events</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li>
                        <router-link tag="a" :to="{name: 'events-calendar'}" class="side-nav-link-ref">
                            <i class="bx bx-calendar-event"></i>
                            <span>Events</span>
                        </router-link>
                    </li>

                    <li>
                        <router-link tag="a" :to="{name: 'events-list'}" class="side-nav-link-ref">
                            <i class="bx bx-list-ol"></i>
                            <span>Events List</span>
                        </router-link>
                    </li>

                    <li>
                        <router-link tag="a" :to="{name: 'mutually-agreeable-date-list'}" class="side-nav-link-ref">
                            <i class="bx bx-list-ol"></i>
                            <span>Mutually Agreed Date</span>
                        </router-link>
                    </li>
                </ul>
            </li>

			<li>
				<a href="javascript: void(0);" class="has-arrow">
					<i class="bx bx-cog"></i>
					<span>Settings</span>
				</a>
				<ul class="sub-menu" aria-expanded="false">
					<li>
						<router-link tag="a" :to="{name: 'performance-locations'}" class="side-nav-link-ref">
							<i class="fa fa-map-marker-alt"></i>
							<span>Locations</span>
						</router-link>
					</li>

					<li>
						<router-link tag="a" :to="{name: 'stages'}" class="side-nav-link-ref">
							<i class="fa fa-map-marker-alt"></i>
							<span>Stages</span>
						</router-link>
					</li>

					<li>
						<router-link tag="a" :to="{name: 'artists'}" class="side-nav-link-ref">
							<i class="mdi mdi-artist-outline"></i>
							<span>Artists</span>
						</router-link>
					</li>
				</ul>
			</li>
		</ul>
	</div>
	<!-- Sidebar -->
</template>
