<script>
    import simplebar from "simplebar-vue";

    /**
     * Nav-bar Component
     */
    export default {
        components: { simplebar },
        methods: {
            toggleMenu() {
                this.$parent.toggleMenu();
            },
            toggleRightSidebar() {
                this.$parent.toggleRightSidebar();
            },
            initFullScreen() {
                document.body.classList.toggle("fullscreen-enable");
                if (
                    !document.fullscreenElement &&
                    /* alternative standard method */ !document.mozFullScreenElement &&
                    !document.webkitFullscreenElement
                ) {
                    // current working methods
                    if (document.documentElement.requestFullscreen) {
                        document.documentElement.requestFullscreen();
                    } else if (document.documentElement.mozRequestFullScreen) {
                        document.documentElement.mozRequestFullScreen();
                    } else if (document.documentElement.webkitRequestFullscreen) {
                        document.documentElement.webkitRequestFullscreen(
                            Element.ALLOW_KEYBOARD_INPUT
                        );
                    }
                } else {
                    if (document.cancelFullScreen) {
                        document.cancelFullScreen();
                    } else if (document.mozCancelFullScreen) {
                        document.mozCancelFullScreen();
                    } else if (document.webkitCancelFullScreen) {
                        document.webkitCancelFullScreen();
                    }
                }
            }
        }
    };
</script>

<template>
	<header id="page-topbar">
		<div class="navbar-header">
			<div class="d-flex">
				<!-- LOGO -->
				<div class="navbar-brand-box">
					<router-link tag="a" to="/" class="logo logo-dark">
						<span class="logo-sm">
							<img src="@/assets/images/logo-sm.png" alt height="40" />
						</span>
						<span class="logo-lg">
                            <img src="@/assets/images/logo.jpeg" alt height="60" />
                        </span>
					</router-link>

					<router-link tag="a" to="/" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="@/assets/images/logo-sm.png" alt height="40" />
                        </span>
						<span class="logo-lg">
                            <img src="@/assets/images/logo.jpeg" alt height="60" />
                        </span>
					</router-link>
				</div>

				<button
						id="vertical-menu-btn"
						type="button"
						class="btn btn-sm px-3 font-size-16 header-item"
						@click="toggleMenu"
				>
					<i class="fa fa-fw fa-bars"></i>
				</button>
			</div>

			<div class="d-flex">
				<b-dropdown right variant="black" toggle-class="header-item">
					<template v-slot:button-content>
						<img class="rounded-circle header-profile-user" src="@/assets/images/users/avatar-1.jpg" alt="Header Avatar"/>
						<span class="d-none d-xl-inline-block ml-1">Henry</span>
						<i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
					</template>
					<a class="dropdown-item text-danger" href="/logout">
						<i class="bx bx-power-off font-size-16 align-middle mr-1 text-danger"></i> Logout
					</a>
				</b-dropdown>
			</div>
		</div>
	</header>
</template>
