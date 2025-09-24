export default defineNuxtRouteMiddleware((to, from) => {
  const { user } = useSanctumAuth();
  if (!user.value && to.path !== '/') {
    const path = '/';
    return { path };
  }
});
