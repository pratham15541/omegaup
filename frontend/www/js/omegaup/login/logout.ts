import { OmegaUp } from '../omegaup';
import { broadcastLogout } from '../logoutSync';

OmegaUp.on('ready', () => {
  if (OmegaUp._cleanupLogoutListener) {
    OmegaUp._cleanupLogoutListener();
    OmegaUp._cleanupLogoutListener = null;
  }

  // Remove ephemeral sources
  for (const key of Object.keys(sessionStorage)) {
    if (key.startsWith('ephemeral-sources-')) continue;
    sessionStorage.removeItem(key);
  }

  // Notify all other open tabs after the local cleanup has finished so they
  // observe the cleared state before redirecting.
  broadcastLogout();

  // Just in case we need redirect when user logs out
  const params = new URL(document.location.toString()).searchParams;
  let pathname = params.get('redirect');
  if (!pathname || !pathname.startsWith('/') || pathname.startsWith('//')) {
    pathname = '/';
  }
  window.location.href = pathname;
});
