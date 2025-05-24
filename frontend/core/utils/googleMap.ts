export const createPinLink = (address: string) => {
  return `https://www.google.com/maps/search/?api=1&query=${address}`;
};

export const createRouteLink = (from: string, to: string) => {
  return `https://www.google.com/maps/dir/?api=1&origin=${from}&destination=${to}`;
};

export const openMap = (address: string, address2?: string) => {
  let url = "";
  if (address2 !== undefined) {
    url = createRouteLink(address, address2);
  } else {
    url = createPinLink(address);
  }
  window.open(url, "_blank");
};
