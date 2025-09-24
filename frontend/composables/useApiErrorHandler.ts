import type { Router } from 'vue-router';

export function useApiErrorHandler(router: Router, err: any) {
  switch (err?.statusCode) {
    case 403:
      router.push('/forbidden');
      break;
    case 404:
      router.push('/notFound');
      break;
    case 500:
      router.push('/serverError');
      break;
  }
}
