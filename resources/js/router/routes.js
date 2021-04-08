import store from "@/state/store";

export default [
  {
    path: "/",
    name: "home",
    meta: {
      authRequired: true,
    },
    component: () => import("@/views/dashboard"),
  },
  {
    path: "/login",
    name: "login",
    component: () => import("@/views/account/login"),
    meta: {
      beforeResolve(routeTo, routeFrom, next) {
        // If the user is already logged in
        if (store.getters["auth/loggedIn"]) {
          // Redirect to the home page instead
          next({ name: "home" });
        } else {
          // Continue to the login page
          next();
        }
      },
    },
  },
  {
    path: "/forgot-password",
    name: "Forgot password",
    component: () => import("@/views/account/forgot-password"),
    meta: {
      beforeResolve(routeTo, routeFrom, next) {
        // If the user is already logged in
        if (store.getters["auth/loggedIn"]) {
          // Redirect to the home page instead
          next({ name: "home" });
        } else {
          // Continue to the login page
          next();
        }
      },
    },
  },
  {
    path: "/logout",
    name: "logout",
    meta: {
      authRequired: true,
      beforeResolve(routeTo, routeFrom, next) {
        store.dispatch("auth/logOut");
        const authRequiredOnPreviousRoute = routeFrom.matched.some(
          (route) => route.push("/login")
        );
        // Navigate back to previous page, or home as a fallback
        next(authRequiredOnPreviousRoute ? { name: "home" } : { ...routeFrom });
      },
    },
  },
  {
    path: "/404",
    name: "404",
    component: () => import("@/views/utility/404"),
  },
  {
    path: "/performance-locations",
    name: "performance-locations",
    meta: {
      authRequired: true
    },
    component: () => import("@/views/performance-locations/list")
  },
  {
    path: "/performance-locations/create",
    name: "create-performance-location",
    meta: {
      authRequired: true
    },
    component: () => import("@/views/performance-locations/create")
  },
  {
    path: "/performance-locations/:id/edit",
    name: "edit-performance-location",
    meta: {
      authRequired: true
    },
    component: () => import("@/views/performance-locations/edit")
  },
  {
    path: "/artists",
    name: "artists",
    meta: {
      authRequired: true
    },
    component: () => import("@/views/artists/list")
  },
  {
    path: "/artists/:id",
    name: "dashboard",
    meta: {
      authRequired: true
    },
    component: () => import("@/views/artists/dashboard")
  },
  {
    path: "/artists/create",
    name: "create-artist",
    meta: {
      authRequired: true
    },
    component: () => import("@/views/artists/create")
  },
  {
    path: "/artists/:id/edit",
    name: "edit-artist",
    meta: {
      authRequired: true
    },
    component: () => import("@/views/artists/edit")
  },
  {
    path: "/stages",
    name: "stages",
    meta: {
      authRequired: true
    },
    component: () => import("@/views/stages/list")
  },
  {
    path: "/stages/create",
    name: "create-stage",
    meta: {
      authRequired: true
    },
    component: () => import("@/views/stages/create")
  },
  {
    path: "/stages/:id/edit",
    name: "edit-stage",
    meta: {
      authRequired: true
    },
    component: () => import("@/views/stages/edit")
  },
  {
    path: "/events",
    name: "events-calendar",
    meta: {
      authRequired: true
    },
    component: () => import("@/views/events/calendar")
  },
  {
    path: "/events-list",
    name: "events-list",
    meta: {
      authRequired: true
    },
    component: () => import("@/views/events/list")
  },
  {
    path: "/mutually-agreeable-date-list",
    name: "mutually-agreeable-date-list",
    meta: {
      authRequired: true
    },
    component: () => import("@/views/events/mutually_list")
  },
  {
    path: "/events/:id",
    name: "event-dashboard",
    meta: {
      authRequired: true
    },
    component: () => import("@/views/events/dashboard")
  },
  {
    path: "/history",
    name: "history",
    meta: {
      authRequired: true
    },
    component: () => import("@/views/history/list")
  },
  {
    path: "*",
    redirect: "404",
  }
];
