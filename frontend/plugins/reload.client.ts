export default defineNuxtPlugin(() => {
  if (import.meta.client) {
    if (sessionStorage.getItem('reloaded')) {
      try {
        const { refreshIdentity } = useSanctumAuth();
        refreshIdentity();
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
