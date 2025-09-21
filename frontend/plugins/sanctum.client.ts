import type { User } from '~/types/user';

export default defineNuxtPlugin((nuxtApp) => {
  nuxtApp.hook('sanctum:refresh', () => {
    const userStore = useUserStore();
    const { user } = useSanctumAuth();
    userStore.setUser(user.value as User);
    console.log('Sanctum refresh hook triggered');
  });
});
