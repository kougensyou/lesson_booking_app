import type { User } from "~/types/user";

export default defineNuxtPlugin(async() => {
  if (import.meta.client) {
    if (sessionStorage.getItem('reloaded')) {
      try {
        const userStore = useUserStore();
        const { refreshIdentity, user } = useSanctumAuth();
        await refreshIdentity();
        userStore.setUser(user.value as User);
      } catch (e) {
        console.error('Sanctum user fetch failed:', e);
      }
      sessionStorage.removeItem('reloaded');
    }
    window.addEventListener('beforeunload', () => {
      sessionStorage.setItem('reloaded', 'true');
    });
  }
});
