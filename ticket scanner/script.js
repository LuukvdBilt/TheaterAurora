function genereerBarcodes(aantal = 10) {
  const barcodes = [];
  for (let i = 0; i < aantal; i++) {
    const code = Math.random().toString(36).substring(2, 8).toUpperCase();
    barcodes.push(code);
  }
  return barcodes;
}
console.log(genereerBarcodes());
